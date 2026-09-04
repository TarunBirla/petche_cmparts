<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Manufacturer;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Pdf;
use App\Models\Product;
use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        User::create([
            'name' => 'Petchemparts Admin',
            'email' => 'admin@petchemparts.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Manufacturers List from User Image
        $manufacturersList = [
            'SCHNEIDER',
            'SIEMENS',
            'INGERSOLL RAND',
            'FLUKE',
            'JOHN CRANE',
            'FOXBORO',
            'PARKER',
            'PANDUIT',
            'AJ KOELLEMANN GMBH',
            'GBM SRL',
            'IGUS GMBH',
            'TMEIC',
            'SKF',
            'ATB RIVACALZONI SPA',
            'SBS STEEL BELT SYSTEMS SRL',
        ];

        $createdManufacturers = [];
        foreach ($manufacturersList as $mName) {
            $m = Manufacturer::create([
                'name' => $mName,
                'slug' => Str::slug($mName),
                'logo' => 'uploads/manufacturers/default.png',
                'is_active' => true,
            ]);
            $createdManufacturers[$mName] = $m;
        }

        // 3. New Petchemparts Categories & Sub-Categories
        $taxonomy = [
            'Electrical & Controls' => [
                'Ballast', 'Battery', 'Capacitors', 'Circuit Breakers', 
                'Switch Gear Panels / Boards', 'Fuses', 'Generators', 'Relays', 
                'Resistors', 'Switches Limit', 'Transformer', 'UPS', 'Motors', 
                'Fire Fighting Equipment & Spares'
            ],
            'Instrumentation & Control' => [
                'Chem Analysis Inst', 'Gas Flow & Level Measur', 'Liquid Flow & Level Measure', 
                'Measuring Instruments', 'Press Vacuum Measure', 'Temp Humid Meas Cont', 
                'Vibration Instrument'
            ],
            'Mechanical & Process' => [
                'Air Purification Eqp', 'Aircon & Refrigeration Equip & Parts', 'Separators', 
                'Air Compressors', 'Conveyors', 'Drier And Dehydrator', 'Fans & Blowers', 
                'Turbines', 'Heat Exchangers', 'Boilers', 'Mechanical Seals', 'Gauges & Hoses', 
                'Strainers', 'Filter and Filter Systems', 'Vacuum Pumps', 'Pumps', 
                'Pipe Fitting, Flanges & Plates', 'Engine Spares', 'Elevators', 
                'Material Handling Eqp', 'Cranes', 'Mechanical Seals & Coupling', 
                'Drive Belts', 'Packaging', 'Sealing & Adhesives', 'Gaskets'
            ],
            'Valves & Actuators' => [
                'Gate Valve', 'Globe Valve', 'Ball Valve', 'Solenoid Valve', 
                'Pneumatic Actuator', 'Stem Plug Valve', 'Linear Cage Valve', 'Dipleg Valve', 
                'Check Valve', 'Butterfly Valve', 'Safety Relief Valve', 
                'Thermostatic Expansion Valve', 'Deluge Valve', 'Manifold Valve', 
                'Exhaust Valve', 'Control Valve', 'Pressure Operated Relief Valve (PORV)', 
                'Other Valves', 'Needle Valve'
            ],
            'Chemicals & Lubricants' => [
                'Catalyst', 'Chemicals', 'Gases: Compressed and Liquefied', 
                'Miscellaneous Chemical Specialties', 'Lubricants'
            ],
            'Tools & Security' => [
                'Automatic Tools', 'Hand Tools', 'Security & Cameras', 
                'Workshop Eqpt, Tools, Accs'
            ],
            'IT Hardware & Accessories' => [
                'Routers, Switches', 'Hardware', 'Memories, Network Cables & Accessories', 
                'Microchips'
            ],
        ];

        $createdCategories = [];
        $createdSubCategories = [];

        foreach ($taxonomy as $catName => $subNames) {
            $cat = Category::create([
                'name' => $catName,
                'slug' => Str::slug($catName),
                'image' => 'uploads/categories/default.jpg',
                'is_active' => true,
            ]);

            $createdCategories[$catName] = $cat;

            foreach ($subNames as $subName) {
                $sub = SubCategory::create([
                    'category_id' => $cat->id,
                    'name' => $subName,
                    'slug' => Str::slug($subName),
                    'image' => 'uploads/subcategories/default.jpg',
                    'is_active' => true,
                ]);

                $createdSubCategories[$subName] = $sub;
            }
        }

        // 4. PDFs
        $pdf1 = Pdf::create([
            'title' => 'Schneider Electric Circuit Breaker Technical Datasheet',
            'file_path' => 'uploads/pdfs/sample_datasheet_1.pdf',
        ]);

        $pdf2 = Pdf::create([
            'title' => 'Siemens Industrial Control Valve Specs',
            'file_path' => 'uploads/pdfs/sample_datasheet_2.pdf',
        ]);

        // 5. Products
        Product::create([
            'manufacturer_id' => $createdManufacturers['SCHNEIDER']->id,
            'category_id' => $createdCategories['Electrical & Controls']->id,
            'sub_category_id' => $createdSubCategories['Circuit Breakers']->id,
            'pdf_id' => $pdf1->id,
            'name' => 'Schneider Electric Compact NSX100N Circuit Breaker 100A',
            'slug' => 'schneider-electric-compact-nsx100n-circuit-breaker-100a',
            'part_number' => 'SCH-NSX100N',
            'model_number' => 'LV429630',
            'summary' => '3-pole molded case circuit breaker with Micrologic 2.2 trip unit for industrial power distribution.',
            'description' => 'The Schneider Electric Compact NSX100N is a 3-pole 3d fixed circuit breaker designed to optimize space and breaking capacity for electrical protection.',
            'quantity' => 29,
            'price' => 450.00,
            'images' => ['images/newlogo.jpeg'],
            'is_active' => true,
        ]);

        Product::create([
            'manufacturer_id' => $createdManufacturers['SIEMENS']->id,
            'category_id' => $createdCategories['Electrical & Controls']->id,
            'sub_category_id' => $createdSubCategories['Motors']->id,
            'pdf_id' => $pdf2->id,
            'name' => 'Siemens SIMOTICS SD Severe Duty Industrial Motor 15kW',
            'slug' => 'siemens-simotics-sd-severe-duty-industrial-motor-15kw',
            'part_number' => 'SIE-SD-15KW',
            'model_number' => '1LE1501-1DB43-4AA4',
            'summary' => 'Cast iron housing high efficiency IE3 motor for harsh Petchemparts environments.',
            'description' => 'Siemens SIMOTICS SD motors are designed for harsh operation in chemical, oil, gas and offshore applications with high durability.',
            'quantity' => 30,
            'price' => 1890.00,
            'images' => ['images/newlogo.jpeg'],
            'is_active' => true,
        ]);

        Product::create([
            'manufacturer_id' => $createdManufacturers['INGERSOLL RAND']->id,
            'category_id' => $createdCategories['Mechanical & Process']->id,
            'sub_category_id' => $createdSubCategories['Air Compressors']->id,
            'pdf_id' => null,
            'name' => 'Ingersoll Rand R-Series 55kW Rotary Screw Air Compressor',
            'slug' => 'ingersoll-rand-r-series-55kw-rotary-screw-air-compressor',
            'part_number' => 'IR-R55I-A10',
            'model_number' => 'R55i-A10',
            'summary' => 'Reliable oil-flooded rotary screw air compressor providing continuous compressed air.',
            'description' => 'Ingersoll Rand R-Series compressors offer optimal performance and easier maintenance in industrial processing plants.',
            'quantity' => 1,
            'price' => 8400.00,
            'images' => ['images/newlogo.jpeg'],
            'is_active' => true,
        ]);

        Product::create([
            'manufacturer_id' => $createdManufacturers['FLUKE']->id,
            'category_id' => $createdCategories['Instrumentation & Control']->id,
            'sub_category_id' => $createdSubCategories['Measuring Instruments']->id,
            'pdf_id' => null,
            'name' => 'Fluke 87V Industrial Multimeter Service Kit',
            'slug' => 'fluke-87v-industrial-multimeter-service-kit',
            'part_number' => 'FLK-87V-KIT',
            'model_number' => 'FLUKE-87-5',
            'summary' => 'True-RMS industrial digital multimeter for troubleshooting complex electrical drives.',
            'description' => 'The Fluke 87V provides accurate frequency and voltage measurements on variable speed motor drives and plant equipment.',
            'quantity' => 6,
            'price' => 620.00,
            'images' => ['images/newlogo.jpeg'],
            'is_active' => true,
        ]);

        Product::create([
            'manufacturer_id' => $createdManufacturers['PARKER']->id,
            'category_id' => $createdCategories['Valves & Actuators']->id,
            'sub_category_id' => $createdSubCategories['Check Valve']->id,
            'pdf_id' => null,
            'name' => 'Parker Hannifin Stainless Steel High Pressure Check Valve',
            'slug' => 'parker-hannifin-stainless-steel-high-pressure-check-valve',
            'part_number' => 'PAR-SS-CV-12',
            'model_number' => '8A-C8L-10-SS',
            'summary' => 'Instrumentation grade unidirectional check valve for high pressure fluid lines.',
            'description' => 'Parker C Series check valves provide unidirectional flow control of liquids and gases in chemical processing systems.',
            'quantity' => 11,
            'price' => 310.00,
            'images' => ['images/newlogo.jpeg'],
            'is_active' => true,
        ]);

        // 6. CMS Pages
        Page::create([
            'title' => 'About Us',
            'slug' => 'about-us',
            'content' => <<<EOT
<h3>About Petchem Parts</h3>
<ol>
    <li>UK's leading Petchemparts, industrial, oil and gas spare parts, consumable &amp; MRO reseller globally.</li>
    <li>Large number of spare parts and accessories, spanning more than 500 brands/manufacturers from Europe and USA.</li>
    <li>End to end shipping globally.</li>
    <li>Minimize the unforeseen costs and disruption the breakdown of an equipment can cause to your plant.</li>
    <li>Fast and quick turnaround.</li>
    <li>Supply hard to source parts.</li>
</ol>
EOT,
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Delivery and Returns',
            'slug' => 'delivery',
            'content' => <<<EOT
<h3>Delivery and Returns</h3>
<p>Packages are generally dispatched within agreed delivery days after receipt of payment and are shipped via courier with tracking.</p>
EOT,
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Terms and Conditions',
            'slug' => 'terms-and-conditions',
            'content' => <<<EOT
<h3>TERMS AND CONDITIONS</h3>
<p>The www.petchemparts.com web site is owned and operated by Pearlcon Business Services Ltd, United Kingdom.</p>
EOT,
            'is_active' => true,
        ]);
    }
}
