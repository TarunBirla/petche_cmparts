<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * ONE-TIME IMPORT COMMAND (Optimized with In-Memory Caching)
 * ---------------------------------------------------------
 * Reads the Zoho product-list Excel file and inserts/updates
 * categories, sub_categories, manufacturers and products with
 * proper foreign keys.
 *
 * Usage:
 *   php artisan import:products
 *   php artisan import:products storage/app/imports/products.xlsx
 */
class ImportProductsFromExcel extends Command
{
    protected $signature = 'import:products {file=storage/app/imports/products.xlsx}';

    protected $description = 'One-time import of categories, sub categories, manufacturers and products from the Excel product list';

    private array $expectedHeaders = [
        'Product Name',
        'Category Name',
        'Sub Category Name',
        'Manufacturer Name',
        'Description',
        'Part Number',
        'Model Number',
    ];

    public function handle(): int
    {
        $path = base_path($this->argument('file'));

        if (! file_exists($path)) {
            $this->error("File nahi mili: {$path}");
            $this->line('Pehle xlsx file ko is path par rakh dein, ya command ke saath sahi path pass karein.');

            return self::FAILURE;
        }

        $this->info("Reading: {$path}");

        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, false);

        $header = array_map('trim', array_shift($rows));

        $colIndex = [];
        foreach ($this->expectedHeaders as $col) {
            $idx = array_search($col, $header, true);
            if ($idx === false) {
                $this->error("Column '{$col}' excel me nahi mila. Header row check karein.");

                return self::FAILURE;
            }
            $colIndex[$col] = $idx;
        }

        $this->info("Building in-memory caches for fast database operations...");

        // Pre-load categories
        $categoriesCache = [];
        $categorySlugs = [];
        foreach (Category::all() as $cat) {
            $categoriesCache[$cat->name] = $cat;
            $categorySlugs[$cat->slug] = true;
        }

        // Pre-load subcategories
        $subCategoriesCache = [];
        $subCategorySlugs = [];
        foreach (SubCategory::all() as $subCat) {
            $subCategoriesCache[$subCat->category_id.'_'.$subCat->name] = $subCat;
            $subCategorySlugs[$subCat->slug] = true;
        }

        // Pre-load manufacturers
        $manufacturersCache = [];
        $manufacturerSlugs = [];
        foreach (Manufacturer::all() as $m) {
            $manufacturersCache[$m->name] = $m;
            $manufacturerSlugs[$m->slug] = true;
        }

        // Pre-load products
        $productsByPartNum = [];
        $productsByNameManuf = [];
        $productSlugs = [];
        foreach (Product::all() as $p) {
            if ($p->part_number && $p->part_number !== 'N/A') {
                $productsByPartNum[$p->part_number] = $p;
            }
            $productsByNameManuf[$p->name.'_'.$p->manufacturer_id] = $p;
            $productSlugs[$p->slug] = true;
        }

        $created = ['category' => 0, 'sub_category' => 0, 'manufacturer' => 0, 'product' => 0];
        $updated = 0;
        $skipped = 0;

        $bar = $this->output->createProgressBar(count($rows));
        $bar->start();

        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                $productName = trim((string) ($row[$colIndex['Product Name']] ?? ''));
                $categoryName = trim((string) ($row[$colIndex['Category Name']] ?? ''));
                $subCategoryName = trim((string) ($row[$colIndex['Sub Category Name']] ?? ''));
                $manufacturerName = trim((string) ($row[$colIndex['Manufacturer Name']] ?? ''));
                $description = trim((string) ($row[$colIndex['Description']] ?? ''));
                $partNumber = trim((string) ($row[$colIndex['Part Number']] ?? ''));
                $modelNumber = trim((string) ($row[$colIndex['Model Number']] ?? ''));

                if ($productName === '' || $categoryName === '') {
                    $skipped++;
                    $bar->advance();
                    continue;
                }

                // 1) Category ---------------------------------------------------
                if (isset($categoriesCache[$categoryName])) {
                    $category = $categoriesCache[$categoryName];
                } else {
                    $cSlug = $this->makeSlug($categoryName, $categorySlugs);
                    $category = Category::create([
                        'name' => $categoryName,
                        'slug' => $cSlug,
                        'is_active' => 1,
                    ]);
                    $categoriesCache[$categoryName] = $category;
                    $created['category']++;
                }

                // 2) Sub Category -----------------------------------------------
                $subCategory = null;
                if ($subCategoryName !== '') {
                    $subKey = $category->id.'_'.$subCategoryName;
                    if (isset($subCategoriesCache[$subKey])) {
                        $subCategory = $subCategoriesCache[$subKey];
                    } else {
                        $scSlug = $this->makeSlug($subCategoryName, $subCategorySlugs);
                        $subCategory = SubCategory::create([
                            'name' => $subCategoryName,
                            'category_id' => $category->id,
                            'slug' => $scSlug,
                            'is_active' => 1,
                        ]);
                        $subCategoriesCache[$subKey] = $subCategory;
                        $created['sub_category']++;
                    }
                }

                // 3) Manufacturer -----------------------------------------------
                $mName = $manufacturerName !== '' ? $manufacturerName : 'General';
                if (isset($manufacturersCache[$mName])) {
                    $manufacturer = $manufacturersCache[$mName];
                } else {
                    $mSlug = $this->makeSlug($mName, $manufacturerSlugs);
                    $manufacturer = Manufacturer::create([
                        'name' => $mName,
                        'slug' => $mSlug,
                        'is_active' => 1,
                    ]);
                    $manufacturersCache[$mName] = $manufacturer;
                    $created['manufacturer']++;
                }

                // 4) Product ----------------------------------------------------
                $partNumFinal = $partNumber !== '' ? $partNumber : 'N/A';
                $modelNumFinal = $modelNumber !== '' ? $modelNumber : 'N/A';

                $existing = null;
                if ($partNumber !== '' && isset($productsByPartNum[$partNumber])) {
                    $existing = $productsByPartNum[$partNumber];
                } elseif (isset($productsByNameManuf[$productName.'_'.$manufacturer->id])) {
                    $existing = $productsByNameManuf[$productName.'_'.$manufacturer->id];
                }

                $data = [
                    'manufacturer_id' => $manufacturer->id,
                    'category_id' => $category->id,
                    'sub_category_id' => $subCategory?->id,
                    'name' => $productName,
                    'part_number' => $partNumFinal,
                    'model_number' => $modelNumFinal,
                    'summary' => Str::limit($description, 150),
                    'description' => $description,
                    'is_active' => 1,
                ];

                if ($existing) {
                    $existing->update($data);
                    $updated++;
                } else {
                    $data['slug'] = $this->makeSlug($productName, $productSlugs);
                    $data['quantity'] = 0;
                    $data['price'] = 0;
                    $newProduct = Product::create($data);
                    $created['product']++;

                    if ($partNumber !== '') {
                        $productsByPartNum[$partNumber] = $newProduct;
                    }
                    $productsByNameManuf[$productName.'_'.$manufacturer->id] = $newProduct;
                }

                $bar->advance();
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $bar->finish();
            $this->newLine(2);
            $this->error('Error aa gaya, koi bhi data save nahi hua (rollback ho gaya): '.$e->getMessage());

            return self::FAILURE;
        }

        $bar->finish();
        $this->newLine(2);

        $this->info('Import complete!');
        $this->table(
            ['Type', 'Naye Bane', 'Extra'],
            [
                ['Category', $created['category'], ''],
                ['Sub Category', $created['sub_category'], ''],
                ['Manufacturer', $created['manufacturer'], ''],
                ['Product (naye)', $created['product'], ''],
                ['Product (update hue)', $updated, ''],
            ]
        );

        if ($skipped > 0) {
            $this->warn("{$skipped} rows skip hui kyunki Product Name ya Category Name khali tha.");
        }

        return self::SUCCESS;
    }

    /**
     * Generates a unique slug fast using an in-memory lookup table.
     */
    private function makeSlug(string $name, array &$usedSlugs): string
    {
        $base = Str::slug($name);
        if (empty($base)) {
            $base = 'item';
        }
        $slug = $base;
        $i = 1;

        while (isset($usedSlugs[$slug])) {
            $slug = $base.'-'.$i;
            $i++;
        }

        $usedSlugs[$slug] = true;

        return $slug;
    }
}
