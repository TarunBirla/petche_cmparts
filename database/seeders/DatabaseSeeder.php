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

        // 2. Manufacturers
        $m1 = Manufacturer::create([
            'name' => 'Emerson Electric',
            'slug' => 'emerson-electric',
            'logo' => 'uploads/manufacturers/emerson.png',
            'is_active' => true,
        ]);

        $m2 = Manufacturer::create([
            'name' => 'Siemens Industrial',
            'slug' => 'siemens-industrial',
            'logo' => 'uploads/manufacturers/siemens.png',
            'is_active' => true,
        ]);

        $m3 = Manufacturer::create([
            'name' => 'Honeywell Process',
            'slug' => 'honeywell-process',
            'logo' => 'uploads/manufacturers/honeywell.png',
            'is_active' => true,
        ]);

        $m4 = Manufacturer::create([
            'name' => 'Yokogawa Electric',
            'slug' => 'yokogawa-electric',
            'logo' => 'uploads/manufacturers/yokogawa.png',
            'is_active' => true,
        ]);

        // 3. New B2B Categories & Sub-Categories
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
            'title' => 'Fisher 667 Control Valve Technical Datasheet',
            'file_path' => 'uploads/pdfs/sample_datasheet_1.pdf',
        ]);

        $pdf2 = Pdf::create([
            'title' => 'Rosemount 3051S Pressure Transmitter Specs',
            'file_path' => 'uploads/pdfs/sample_datasheet_2.pdf',
        ]);

        // 5. Products
        Product::create([
            'manufacturer_id' => $m1->id,
            'category_id' => $createdCategories['Valves & Actuators']->id,
            'sub_category_id' => $createdSubCategories['Control Valve']->id,
            'pdf_id' => $pdf1->id,
            'name' => 'Fisher 667 Size 30 Diaphragm Actuator Control Valve',
            'slug' => 'fisher-667-size-30-diaphragm-actuator-control-valve',
            'part_number' => 'FSH-667-SZ30',
            'model_number' => '667-DPA-30',
            'summary' => 'Heavy-duty reverse-acting diaphragm actuator for pneumatic control valves in chemical processing.',
            'description' => 'The Fisher 667 actuator is a reverse-acting, spring-opposed diaphragm actuator designed to position control valve stems in response to pneumatic output signals from control devices.',
            'quantity' => 15,
            'price' => 0.00,
            'images' => ['images/logo.png'],
            'is_active' => true,
        ]);

        Product::create([
            'manufacturer_id' => $m1->id,
            'category_id' => $createdCategories['Instrumentation & Control']->id,
            'sub_category_id' => $createdSubCategories['Press Vacuum Measure']->id,
            'pdf_id' => $pdf2->id,
            'name' => 'Rosemount 3051S Coplanar Pressure Transmitter',
            'slug' => 'rosemount-3051s-coplanar-pressure-transmitter',
            'part_number' => 'RM-3051S-CD2',
            'model_number' => '3051S1CD2A1011A1A',
            'summary' => 'Industry leading scalable pressure transmitter with HART 7 protocol.',
            'description' => 'The Rosemount 3051S Coplanar Pressure Transmitter delivers unmatched performance and safety in critical oil, gas, and petrochemical operations.',
            'quantity' => 28,
            'price' => 0.00,
            'images' => ['images/logo.png'],
            'is_active' => true,
        ]);

        Product::create([
            'manufacturer_id' => $m2->id,
            'category_id' => $createdCategories['Electrical & Controls']->id,
            'sub_category_id' => $createdSubCategories['Circuit Breakers']->id,
            'pdf_id' => null,
            'name' => 'Siemens 3VA Molded Case Circuit Breaker 250A',
            'slug' => 'siemens-3va-molded-case-circuit-breaker-250a',
            'part_number' => 'SIE-3VA-250A',
            'model_number' => '3VA1225-4EF32-0AA0',
            'summary' => 'High breaking capacity MCCB circuit breaker for industrial power distribution.',
            'description' => 'Siemens 3VA Molded Case Circuit Breakers set standard for safety and reliability in electrical power control.',
            'quantity' => 10,
           'price' => 0.00,
            'images' => ['images/logo.png'],
            'is_active' => true,
        ]);

        Product::create([
            'manufacturer_id' => $m3->id,
            'category_id' => $createdCategories['Instrumentation & Control']->id,
            'sub_category_id' => $createdSubCategories['Liquid Flow & Level Measure']->id,
            'pdf_id' => null,
            'name' => 'Honeywell VersaFlow Coriolis Mass Flowmeter',
            'slug' => 'honeywell-versaflow-coriolis-mass-flowmeter',
            'part_number' => 'HON-VF-CORIOLIS',
            'model_number' => 'VF-CM-100',
            'summary' => 'High precision mass flow sensor for aggressive liquid and gas applications.',
            'description' => 'The Honeywell VersaFlow Coriolis Mass Flowmeter measures mass flow, density, volume, temperature simultaneously.',
            'quantity' => 5,
            'price' => 0.00,
            'images' => ['images/logo.png'],
            'is_active' => true,
        ]);

        // 6. CMS Pages
        Page::create([
            'title' => 'About Us',
            'slug' => 'about-us',
            'content' => <<<EOT
<h3>About Petchem Parts</h3>
<ol>
    <li>UK's leading Petrochemical, industrial, oil and gas spare parts, consumable &amp; MRO reseller globally.</li>
    <li>Large number of spare parts and accessories, spanning more than 500 brands/manufacturers from Europe and USA.</li>
    <li>End to end shipping globally.</li>
    <li>Minimize the unforeseen costs and disruption the breakdown of an equipment can cause to your plant.</li>
    <li>Fast and quick turnaround.</li>
    <li>Supply hard to source parts.</li>
</ol>

<h3>About Us</h3>
<p>We're the leading Global spare parts reseller for Petrochemical, industrial and Oil and gas plants.</p>
<p>We're here to help you find spare parts, accessories, tools and consumables for all your electrical, mechanical, process, instrumentation, control, laboratory, safety, marine and hazardous equipment’s in your plants and infrastructure.</p>

<p>Since launching its parent company in 2009, at Petchemparts we have grown into the UK’s leading spare parts reseller, selling spare parts, accessories and consumables for petrochemical, industrial, oil, gas and energy plants and infrastructure, direct to the end users. Through our experience we have identified three key types of clients when it comes to plant maintenance:</p>
<ol>
    <li>Those who tolerate</li>
    <li>Those who fix</li>
    <li>Those who replace</li>
</ol>

<p>Our aim is to interact and engage with each of these end user types to help them minimise the unforeseen costs and disruption the breakdown of an equipment can cause. We also aim to minimise the impact on the environment, by encouraging clients to repair rather than replace their equipments.</p>

<p>To achieve our aims, we have large number of spare parts and accessories, spanning more than 500 brands – and we’re continuously expanding our product catalogue to enable our clients to find what they need.</p>

<p>At Petchemparts, we set ourselves apart from our competitors by providing more than an e-commerce experience. We also provide comprehensive information, via our technical engineers and manufacturer experts.</p>

<p>We have associations with many internationally renowned manufacturers and suppliers from across Europe, North America, and Asia. This allows us to source and supply exactly what our clients require, ensuring the best quality at the most competitive prices. Whether your requirement is for chemicals, equipment, spare parts, greases or lubricants, Petchemparts is your ideal partner of choice.</p>

<h3>Procurement &amp; Shipping</h3>
<p>We have immense experience in procurement, planning, scheduling, cost control, quality assurance, and inspections of all spares order. Our strong sourcing skills enhance the analysis, selection, engineering knowledge helps us to source directly from manufacturer all over UK, Europe &amp; USA.</p>
<p>The progress of every order is strictly chased for on-time delivery. Each order is inspected for quality and quantity prior to shipment and is packed and marked in accordance with the instructions on the purchase order.</p>
EOT,
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Delivery and Returns',
            'slug' => 'delivery',
            'content' => <<<EOT
<h3>Delivery and Returns</h3>

<h4>Your shipment</h4>
<p>Packages are generally dispatched within agreed delivery days after receipt of payment and are shipped via courier with tracking and drop-off without signature. If you prefer delivery by yourself, this can be arranged, so please contact us before choosing your delivery preference. Whichever shipment choice you make, we will provide you with a link to track your package online.</p>

<p>Shipping charges will include handling and packing fees as well as courier costs. Handling fees are fixed, whereas transport fees vary according to total weight of the shipment. We advise you to group your items in one order. We cannot group two distinct orders placed separately, and shipping fees will apply to each of them. Your package will be dispatched at your own risk, but special care is taken to protect fragile objects.</p>
EOT,
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Terms and Conditions',
            'slug' => 'terms-and-conditions',
            'content' => <<<EOT
<h3>TERMS AND CONDITIONS</h3>

<h4>General</h4>
<p>The www.petchemparts.com web site is owned and operated by Pearlcon Business Services Ltd, a company registered in United Kingdom.</p>

<h4>Terms of Use</h4>
<p>Your use of this web site, www.petchemparts.com (hereinafter referred to as the Petchemparts Web Site), is subject to, and contingent upon, your acceptance of all of the terms, conditions and legal notices published anywhere on the Petchemparts Web Site (hereinafter collectively referred to as Terms). If, for any reason, you do not agree to be bound by all Terms, your sole and exclusive remedy is to cease using the Petchemparts Web Site. Your use of the Petchemparts Web Site at any time constitutes a legally binding Terms of Use Agreement (hereinafter referred to as the Agreement) that obligates you to abide by these Terms. Any failure on your part to abide by these Terms constitutes a breach of the Agreement.</p>

<h4>Downloading Content</h4>
<p>As a condition of the use of the Petchemparts Web Site, you are strictly prohibited from modifying, transmitting, distributing, reusing, reposting, "framing" or using any content published on the Petchemparts Web Site including the text, images, html code, audio and/or video for public or commercial purposes without the express written consent of an authorized representative of Petchemparts. You are strictly prohibited, under any circumstance, or for any reason, from downloading any image of any of the products for sale on this site. You may only download Content displayed on the Petchemparts Web Site on the strict condition that you will use it exclusively for PERSONAL, NON-COMMERCIAL purposes, as long as you also ensure that you 1) preserve all copyright, trademark and other proprietary notices contained in the material, 2) do not modify or alter the material and 3) do not copy or post the material on any network computer or broadcast the material in any media. Any such downloaded content must be immediately destroyed if you have either breached or chosen to terminate the Agreement.</p>

<h4>Copyright Notice and Notice of Proprietary Rights</h4>
<p>All content included on or comprising the Petchemparts Web Site including information, data, software, photographs, graphs, videos, typefaces, graphics, and other material (collectively "Content") are protected by copyright, trademark, patent or other proprietary rights by the respective trademark owners, and these rights are valid and protected in all forms, media and technologies existing now or developed in the future. All Content is copyrighted as a collective work and Petchemparts owns, to the fullest extent allowed by such laws, the copyright in the selection, coordination, arrangement, and enhancement of all Content.</p>
<p>Except as expressly authorized or licensed, you may not copy, modify, remove, delete, augment, add to, publish, transmit, participate in the transfer or sale, lease or rental of, create derivative works from or in any way exploit any of the Content, in whole or in part.</p>

<h4>Confidentiality</h4>
<p>By using the Petchemparts Web Site, you agree that any information (except for purchase information), materials, suggestions, ideas or comments you send via the Petchemparts Web Site or any other third party using the Petchemparts Web Site is non-confidential.</p>

<h4>Indemnification</h4>
<p>You agree to defend, indemnify, save and hold harmless Petchemparts, its licensees and Petchemparts’s respective directors, officers, employees and agents from and against all liabilities, claims, damages and expenses.</p>

<h4>Choice of Law</h4>
<p>The Agreement shall be governed by and construed in accordance with the laws of United Kingdom without giving effect to any principles or conflicts of law.</p>

<h4>Disclaimer</h4>
<p>The data and information contained in this web site are believed to be accurate, but may contain inaccuracies and typographical errors.</p>
EOT,
            'is_active' => true,
        ]);
    }
}
