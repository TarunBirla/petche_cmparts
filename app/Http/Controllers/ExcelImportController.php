<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelImportController extends Controller
{
    public function import()
    {
        @ini_set('memory_limit', '1024M');
        @set_time_limit(1800);

        $possiblePaths = [
            storage_path('app/imports/products.xlsx'),
            storage_path('app/public/imports/products.xlsx'),
            public_path('imports/products.xlsx'),
            base_path('products.xlsx')
        ];

        $filePath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $filePath = $path;
                break;
            }
        }

        if (!$filePath) {
            return response()->html("
                <div style='font-family: sans-serif; padding: 40px; text-align: center;'>
                    <h2 style='color: #e11d48;'>Excel File Not Found</h2>
                    <p>Could not find <code>products.xlsx</code> at <code>storage/app/imports/products.xlsx</code>.</p>
                    <p>Please place your Excel file at: <code>" . storage_path('app/imports/products.xlsx') . "</code></p>
                </div>
            ", 404);
        }

        $startTime = microtime(true);

        try {
            $reader = IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
        } catch (\Exception $e) {
            return response()->html("
                <div style='font-family: sans-serif; padding: 40px; text-align: center;'>
                    <h2 style='color: #e11d48;'>Error Reading Excel File</h2>
                    <p>" . htmlspecialchars($e->getMessage()) . "</p>
                </div>
            ", 500);
        }

        // Cache existing entities to minimize DB queries
        $categories = Category::all()->keyBy(fn($c) => strtolower(trim($c->name)));
        $subCategories = SubCategory::all()->keyBy(fn($sc) => $sc->category_id . '_' . strtolower(trim($sc->name)));
        $manufacturers = Manufacturer::all()->keyBy(fn($m) => strtolower(trim($m->name)));

        // Pluck existing product names to avoid duplicates
        $existingProductNames = DB::table('products')->pluck('name')->map(fn($n) => strtolower(trim($n)))->flip()->toArray();

        $maxProductId = (int) DB::table('products')->max('id');
        $productCounter = $maxProductId + 1;

        $newCategoriesCount = 0;
        $newSubCategoriesCount = 0;
        $newManufacturersCount = 0;
        $newProductsCount = 0;
        $skippedProductsCount = 0;

        $productsToInsert = [];
        $now = now()->toDateTimeString();

        foreach ($sheet->getRowIterator() as $rowIndex => $row) {
            if ($rowIndex == 1) {
                // Header row
                continue;
            }

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }

            $rawProductName      = isset($rowData[0]) ? trim((string)$rowData[0]) : '';
            $rawCategoryName     = isset($rowData[1]) ? trim((string)$rowData[1]) : '';
            $rawSubCategoryName  = isset($rowData[2]) ? trim((string)$rowData[2]) : '';
            $rawManufacturerName = isset($rowData[3]) ? trim((string)$rowData[3]) : '';
            $description         = isset($rowData[4]) ? trim((string)$rowData[4]) : '';

            if (empty($rawProductName)) {
                continue;
            }

            // Truncate names to safe VARCHAR(255) lengths
            $productName      = Str::limit($rawProductName, 240, '');
            $categoryName     = Str::limit($rawCategoryName, 190, '');
            $subCategoryName  = Str::limit($rawSubCategoryName, 190, '');
            $manufacturerName = Str::limit($rawManufacturerName, 190, '');

            $productNameKey = strtolower($productName);

            // Skip if product already exists in database
            if (isset($existingProductNames[$productNameKey])) {
                $skippedProductsCount++;
                continue;
            }

            try {
                // 1. Process Category
                $catId = null;
                if (!empty($categoryName)) {
                    $catKey = strtolower($categoryName);
                    if (!isset($categories[$catKey])) {
                        $catSlug = Str::limit(Str::slug($categoryName), 180, '') . '-' . rand(100, 999);
                        if (empty($catSlug) || $catSlug === '-') {
                            $catSlug = 'cat-' . rand(1000, 9999);
                        }
                        $newCat = Category::create([
                            'name' => $categoryName,
                            'slug' => $catSlug,
                            'is_active' => true,
                        ]);
                        $categories[$catKey] = $newCat;
                        $newCategoriesCount++;
                    }
                    $catId = $categories[$catKey]->id;
                }

                // 2. Process SubCategory
                $subCatId = null;
                if (!empty($subCategoryName) && $catId) {
                    $subCatKey = $catId . '_' . strtolower($subCategoryName);
                    if (!isset($subCategories[$subCatKey])) {
                        $subCatSlug = Str::limit(Str::slug($subCategoryName), 180, '') . '-' . rand(100, 999);
                        if (empty($subCatSlug) || $subCatSlug === '-') {
                            $subCatSlug = 'subcat-' . rand(1000, 9999);
                        }
                        $newSubCat = SubCategory::create([
                            'category_id' => $catId,
                            'name' => $subCategoryName,
                            'slug' => $subCatSlug,
                            'is_active' => true,
                        ]);
                        $subCategories[$subCatKey] = $newSubCat;
                        $newSubCategoriesCount++;
                    }
                    $subCatId = $subCategories[$subCatKey]->id;
                }

                // 3. Process Manufacturer
                $manufId = null;
                if (!empty($manufacturerName)) {
                    $manufKey = strtolower($manufacturerName);
                    if (!isset($manufacturers[$manufKey])) {
                        $manufSlug = Str::limit(Str::slug($manufacturerName), 180, '') . '-' . rand(100, 999);
                        if (empty($manufSlug) || $manufSlug === '-') {
                            $manufSlug = 'manufacturer-' . rand(1000, 9999);
                        }
                        $newManuf = Manufacturer::create([
                            'name' => $manufacturerName,
                            'slug' => $manufSlug,
                            'logo' => 'uploads/manufacturers/default.png',
                            'is_active' => true,
                        ]);
                        $manufacturers[$manufKey] = $newManuf;
                        $newManufacturersCount++;
                    }
                    $manufId = $manufacturers[$manufKey]->id;
                }

                // 4. Generate Part Number & Model Number
                $currentId = $productCounter++;
                $partNumber = 'PN-' . $currentId;
                $modelNumber = 'MN-' . $currentId;

                // Generate unique slug for product
                $baseSlug = Str::limit(Str::slug($productName), 180, '');
                if (empty($baseSlug)) {
                    $baseSlug = 'product-' . $currentId;
                }
                $slug = $baseSlug . '-' . $currentId;

                $summary = !empty($description) ? Str::limit($description, 200) : null;

                $productsToInsert[] = [
                    'id'              => $currentId,
                    'name'            => $productName,
                    'slug'            => $slug,
                    'category_id'     => $catId,
                    'sub_category_id' => $subCatId,
                    'manufacturer_id' => $manufId,
                    'part_number'     => $partNumber,
                    'model_number'    => $modelNumber,
                    'summary'         => $summary,
                    'description'     => $description,
                    'quantity'        => 10,
                    'price'           => 0.00,
                    'is_active'       => 1,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];

                $existingProductNames[$productNameKey] = true;
                $newProductsCount++;

                // Batch insert every 500 records
                if (count($productsToInsert) >= 500) {
                    try {
                        DB::table('products')->insert($productsToInsert);
                    } catch (\Exception $exBatch) {
                        // Fallback: row by row insert if batch fails
                        foreach ($productsToInsert as $singleProd) {
                            try {
                                DB::table('products')->insert($singleProd);
                            } catch (\Exception $exSingle) {
                                // Skip offending single product
                            }
                        }
                    }
                    $productsToInsert = [];
                }
            } catch (\Exception $eRow) {
                // Ignore single row exception and proceed
                continue;
            }
        }

        // Insert remaining batch
        if (!empty($productsToInsert)) {
            try {
                DB::table('products')->insert($productsToInsert);
            } catch (\Exception $exBatch) {
                foreach ($productsToInsert as $singleProd) {
                    try {
                        DB::table('products')->insert($singleProd);
                    } catch (\Exception $exSingle) {
                        // Skip offending single product
                    }
                }
            }
        }

        $executionTime = round(microtime(true) - $startTime, 2);
        $totalProductsInDb = Product::count();
        $totalCategoriesInDb = Category::count();
        $totalSubCategoriesInDb = SubCategory::count();
        $totalManufacturersInDb = Manufacturer::count();

        return response()->html("
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Excel Product Import Completed - Petchemparts</title>
            <script src='https://cdn.tailwindcss.com'></script>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
        </head>
        <body class='bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-6'>
            <div class='max-w-2xl w-full bg-slate-800 rounded-3xl border border-slate-700 shadow-2xl p-8'>
                <div class='text-center mb-8'>
                    <div class='w-20 h-20 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-4 border border-emerald-500/40'>
                        <i class='fa-solid fa-cloud-arrow-up text-3xl'></i>
                    </div>
                    <h1 class='text-3xl font-extrabold text-white'>Excel Product Import Successful!</h1>
                    <p class='text-slate-400 text-sm mt-2'>Processed file: <code class='bg-slate-900 px-2 py-1 rounded text-sky-400'>storage/app/imports/products.xlsx</code></p>
                </div>

                <div class='grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8'>
                    <div class='bg-slate-900/80 p-4 rounded-2xl border border-slate-700/60 text-center'>
                        <span class='text-xs uppercase font-bold text-slate-400 block mb-1'>New Products Added</span>
                        <span class='text-2xl font-black text-emerald-400'>+" . number_format($newProductsCount) . "</span>
                    </div>
                    <div class='bg-slate-900/80 p-4 rounded-2xl border border-slate-700/60 text-center'>
                        <span class='text-xs uppercase font-bold text-slate-400 block mb-1'>Skipped (Duplicates)</span>
                        <span class='text-2xl font-black text-amber-400'>" . number_format($skippedProductsCount) . "</span>
                    </div>
                    <div class='bg-slate-900/80 p-4 rounded-2xl border border-slate-700/60 text-center'>
                        <span class='text-xs uppercase font-bold text-slate-400 block mb-1'>Execution Time</span>
                        <span class='text-2xl font-black text-sky-400'>" . $executionTime . "s</span>
                    </div>
                    <div class='bg-slate-900/80 p-4 rounded-2xl border border-slate-700/60 text-center'>
                        <span class='text-xs uppercase font-bold text-slate-400 block mb-1'>New Categories</span>
                        <span class='text-2xl font-black text-indigo-400'>+" . number_format($newCategoriesCount) . "</span>
                    </div>
                    <div class='bg-slate-900/80 p-4 rounded-2xl border border-slate-700/60 text-center'>
                        <span class='text-xs uppercase font-bold text-slate-400 block mb-1'>New SubCategories</span>
                        <span class='text-2xl font-black text-purple-400'>+" . number_format($newSubCategoriesCount) . "</span>
                    </div>
                    <div class='bg-slate-900/80 p-4 rounded-2xl border border-slate-700/60 text-center'>
                        <span class='text-xs uppercase font-bold text-slate-400 block mb-1'>New Manufacturers</span>
                        <span class='text-2xl font-black text-rose-400'>+" . number_format($newManufacturersCount) . "</span>
                    </div>
                </div>

                <div class='bg-slate-900 p-5 rounded-2xl border border-slate-700 space-y-2 text-xs text-slate-300 mb-8'>
                    <div class='flex justify-between border-b border-slate-800 pb-2'>
                        <span class='text-slate-400'>Total Products in DB Now:</span>
                        <strong class='text-white font-mono'>" . number_format($totalProductsInDb) . "</strong>
                    </div>
                    <div class='flex justify-between border-b border-slate-800 pb-2'>
                        <span class='text-slate-400'>Total Categories in DB:</span>
                        <strong class='text-white font-mono'>" . number_format($totalCategoriesInDb) . "</strong>
                    </div>
                    <div class='flex justify-between border-b border-slate-800 pb-2'>
                        <span class='text-slate-400'>Total SubCategories in DB:</span>
                        <strong class='text-white font-mono'>" . number_format($totalSubCategoriesInDb) . "</strong>
                    </div>
                    <div class='flex justify-between'>
                        <span class='text-slate-400'>Total Manufacturers in DB:</span>
                        <strong class='text-white font-mono'>" . number_format($totalManufacturersInDb) . "</strong>
                    </div>
                </div>

                <div class='flex flex-col sm:flex-row gap-3 justify-center'>
                    <a href='" . route('products.index') . "' class='bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs py-3.5 px-6 rounded-xl transition text-center shadow-lg'>
                        <i class='fa-solid fa-boxes-stacked mr-1.5'></i> View Frontend Product Catalog
                    </a>
                    <a href='" . url('/') . "' class='bg-slate-700 hover:bg-slate-600 text-white font-bold text-xs py-3.5 px-6 rounded-xl transition text-center'>
                        <i class='fa-solid fa-house mr-1.5'></i> Back to Website
                    </a>
                </div>
            </div>
        </body>
        </html>
        ");
    }
}
