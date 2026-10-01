<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ExcelImportController;

class ImportExcelProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products, categories, subcategories, and manufacturers from storage/app/imports/products.xlsx';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Excel Product Import from storage/app/imports/products.xlsx...');
        
        $controller = new ExcelImportController();
        $response = $controller->import();

        $this->info('Import process completed successfully!');
        return Command::SUCCESS;
    }
}
