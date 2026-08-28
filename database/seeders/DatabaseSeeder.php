<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Certification;
use App\Models\CultureItem;
use App\Models\JobOpening;
use App\Models\Milestone;
use App\Models\Office;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\UspItem;
use App\Models\ValueProp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->seedAdminUser();
        $this->seedSettings();
        $this->seedUspItems();
        $categories = $this->seedCategories();
        $this->seedProducts($categories);
        $this->seedTestimonials();
        $this->seedStats();
        $this->seedValueProps();
        $this->seedMilestones();
        $this->seedCertifications();
        $this->seedProcessSteps();
        $this->seedCultureItems();
        $this->seedOffices();
        $this->seedJobOpenings();
    }

    private function seedAdminUser(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@rjspharma.in')],
            [
                'name' => 'RJS Pharma Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'RjsAdmin@2026')),
            ]
        );
    }

    private function seedSettings(): void
    {
        $settings = [
            'logo_url' => '/images/logo.png',
            'phone_primary' => '+91 361 796 2687',
            'phone_secondary' => '+91 86384 75910',
            'phone_process' => '+91 80119 26222',
            'email' => 'info@rjspharma.in',
            'hero_badge_value' => '22+',
            'hero_badge_label' => 'Therapeutic areas of expertise',
            'footer_tagline' => 'Innovating medicines, improving lives. Creating a healthier tomorrow — from research to every doorstep.',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    private function seedUspItems(): void
    {
        $items = [
            ['icon_key' => 'shield', 'title' => 'Quality First', 'description' => 'Strict quality control and WHO-GMP aligned manufacturing across every product.'],
            ['icon_key' => 'users', 'title' => 'Patient Focused', 'description' => 'Patient-centered solutions designed around real, everyday treatment needs.'],
            ['icon_key' => 'bulb', 'title' => 'Driven by Innovation', 'description' => 'Advanced formulation techniques backed by continuous R&D investment.'],
            ['icon_key' => 'globe', 'title' => 'Trusted Nationwide', 'description' => 'Trusted by healthcare providers across India, rated 4.9 average by our partners.'],
        ];

        foreach ($items as $i => $item) {
            UspItem::updateOrCreate(['title' => $item['title']], $item + ['sort_order' => $i]);
        }
    }

    /** @return array<string, Category> */
    private function seedCategories(): array
    {
        $categories = [
            ['name' => 'Anti-Infectives', 'slug' => 'anti-infectives', 'icon' => '🦠', 'accent_color' => '#0F7A72', 'description' => "Antifungal & antibacterial therapies — Ritraz, Cefutil-500, Tero-Scab."],
            ['name' => 'Dermatology', 'slug' => 'dermatology', 'icon' => '🧴', 'accent_color' => '#E85D4C', 'description' => 'Skin, scalp & cosmetic dermatology — Ridsone, Melanowhite, Faceolift.'],
            ['name' => 'General Medicine', 'slug' => 'general-medicine', 'icon' => '💊', 'accent_color' => '#3FA66B', 'description' => 'Broad-spectrum everyday care — Dezacort, Ridmont FX, Absozyme.'],
            ['name' => 'Nutraceuticals', 'slug' => 'nutraceuticals', 'icon' => '🌿', 'accent_color' => '#0B2D4E', 'description' => 'Wellness & supplementation — Glution-Plus, Pravit-9G, Absozyme Syrup.'],
            ['name' => 'Respiratory & Allergy', 'slug' => 'respiratory', 'icon' => '🩺', 'accent_color' => '#E8A83F', 'description' => 'Anti-allergic & respiratory support — Ridmont FX (Montelukast + Fexofenadine).'],
        ];

        $result = [];
        foreach ($categories as $i => $cat) {
            $result[$cat['slug']] = Category::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat + ['sort_order' => $i]
            );
        }

        return $result;
    }

    /** @param array<string, Category> $categories */
    private function seedProducts(array $categories): void
    {
        $products = [
            ['name' => 'Neo Melfade Tablets', 'pack_size' => '1×10', 'cat' => 'dermatology', 'composition' => 'Picrorhiza Kurroa, Silybum Marianum & Ginkgo Biloba Extract, N-Acetyl L-Cysteine, Vitamins & Minerals', 'grad' => ['#7B5EE0', '#4C3499'], 'description' => 'A depigmenting nutraceutical combination that supports skin repigmentation from within, combining antioxidant herbal extracts with essential vitamins and minerals.'],
            ['name' => 'Melfade Tablets', 'pack_size' => '1×10', 'cat' => 'dermatology', 'composition' => 'Depigmentation support combination', 'grad' => ['#7B5EE0', '#4C3499'], 'description' => 'Oral adjunct therapy for pigmentary skin conditions, formulated to complement topical depigmenting regimens.', 'featured' => true],
            ['name' => 'MelanoWhite Cream', 'pack_size' => '15g', 'cat' => 'dermatology', 'composition' => 'β-White, Tyrostat-09, Melanostatine-5 with Lecigel base', 'grad' => ['#E8A83F', '#C4841F'], 'description' => 'A tyrosinase-inhibiting brightening cream for hyperpigmentation and uneven skin tone, delivered in a fast-absorbing Lecigel base.', 'featured' => true],
            ['name' => 'Faceolift Serum', 'pack_size' => '30ml', 'cat' => 'dermatology', 'composition' => 'Retinol + Hyaluronic Acid', 'grad' => ['#E85D4C', '#B03A2C'], 'description' => 'An anti-ageing facial serum combining Retinol for cell turnover with Hyaluronic Acid for deep hydration.'],
            ['name' => 'Renate Foaming Face Wash', 'pack_size' => '30ml', 'cat' => 'dermatology', 'composition' => 'Salicylic Acid 2%, Glycolic Acid & Lactic Acid', 'grad' => ['#3FA66B', '#1F7A47'], 'description' => 'A gentle exfoliating cleanser for acne-prone and oily skin, formulated with a blend of AHA/BHA acids.'],
            ['name' => 'Ridsone Cream', 'pack_size' => '20g', 'cat' => 'dermatology', 'composition' => 'Mometasone Furoate 0.1% w/w', 'grad' => ['#E85D4C', '#c73f30'], 'description' => 'A topical corticosteroid for inflammatory and pruritic dermatoses, including eczema and dermatitis.', 'featured' => true],
            ['name' => 'Ridsone-F Cream', 'pack_size' => '15g', 'cat' => 'dermatology', 'composition' => 'Mometasone Furoate 0.1% w/w + Fusidic Acid 2% w/w', 'grad' => ['#E85D4C', '#8a2b21'], 'description' => 'Combines a corticosteroid with an antibacterial agent for infected inflammatory skin conditions.'],
            ['name' => 'Ridnide Cream/Lotion', 'pack_size' => '15g / 20ml', 'cat' => 'dermatology', 'composition' => 'Desonide 0.05% w/w', 'grad' => ['#E85D4C', '#d16457'], 'description' => 'A low-potency topical corticosteroid suitable for sensitive skin areas and paediatric dermatoses.'],
            ['name' => 'Ridocaine Gel', 'pack_size' => '30g', 'cat' => 'dermatology', 'composition' => 'Lidocaine & Prilocaine', 'grad' => ['#0F7A72', '#0c5f59'], 'description' => 'A topical anaesthetic gel for numbing skin ahead of minor dermatological or aesthetic procedures.'],
            ['name' => 'Cefutil-500 Tablets', 'pack_size' => '1×10', 'cat' => 'anti-infectives', 'composition' => 'Cefuroxime Axetil 500mg', 'grad' => ['#0F7A72', '#0c5f59'], 'description' => 'A second-generation cephalosporin antibiotic for respiratory, ENT, skin and urinary tract infections.'],
            ['name' => 'Ritraz 100 / 200 Capsules', 'pack_size' => '1×10', 'cat' => 'anti-infectives', 'composition' => 'Itraconazole 100mg / 200mg', 'grad' => ['#0F7A72', '#123A61'], 'description' => 'A broad-spectrum antifungal used for systemic fungal infections including dermatophytosis and candidiasis.'],
            ['name' => 'Ritraz Antifungal Dusting Powder', 'pack_size' => '100g', 'cat' => 'anti-infectives', 'composition' => 'Itraconazole Dusting Powder 1.0% w/w', 'grad' => ['#0F7A72', '#123A61'], 'description' => 'A topical antifungal powder for moisture-prone areas, helping prevent recurrent fungal infections.'],
            ['name' => 'Tero-Scab 500 Tablets', 'pack_size' => '1×7', 'cat' => 'anti-infectives', 'composition' => 'Terbinafine Hydrochloride 500mg', 'grad' => ['#3FA66B', '#1F7A47'], 'description' => 'An oral antifungal for scabies-associated and dermatophyte skin infections.'],
            ['name' => 'KetoGaurd Soap', 'pack_size' => '75g', 'cat' => 'anti-infectives', 'composition' => 'Ketoconazole 2%', 'grad' => ['#E8A83F', '#a5701a'], 'description' => 'An antifungal cleansing bar for seborrhoeic dermatitis, dandruff and fungal skin conditions.'],
            ['name' => 'KetoGaurd-ZP Lotion', 'pack_size' => '100ml', 'cat' => 'anti-infectives', 'composition' => 'Ketoconazole 2% w/v + Zinc Pyrithione 1% w/v', 'grad' => ['#E8A83F', '#a5701a'], 'description' => 'An anti-dandruff scalp lotion combining an antifungal with zinc pyrithione for flake and itch control.'],
            ['name' => 'Luliburn Cream', 'pack_size' => '30g', 'cat' => 'anti-infectives', 'composition' => 'Luliconazole 1% w/v', 'grad' => ['#0F7A72', '#0c5f59'], 'description' => 'A once-daily topical antifungal cream effective against a broad range of dermatophytes.'],
            ['name' => 'Roperm Lotion', 'pack_size' => '60ml', 'cat' => 'anti-infectives', 'composition' => 'Permethrin 5% w/v & Cetrimide 0.5% w/w', 'grad' => ['#123A61', '#0B2D4E'], 'description' => 'A scabicidal lotion combining permethrin with an antiseptic agent for scabies management.'],
            ['name' => 'Dezacort-12 Tablets', 'pack_size' => '10×10', 'cat' => 'general-medicine', 'composition' => 'Deflazacort 12mg', 'grad' => ['#0B2D4E', '#123A61'], 'description' => 'A corticosteroid used across inflammatory, allergic, respiratory and rheumatic conditions.', 'featured' => true],
            ['name' => 'Ridmont FX Tablets', 'pack_size' => '1×10', 'cat' => 'respiratory', 'composition' => 'Montelukast 10mg & Fexofenadine Hydrochloride 120mg', 'grad' => ['#E8A83F', '#C4841F'], 'description' => 'A combination therapy for allergic rhinitis and asthma-related symptom control.'],
            ['name' => 'Glution-Plus Tablets', 'pack_size' => '1×10', 'cat' => 'nutraceuticals', 'composition' => 'L-Glutathione 500mg, Grape Seed Extract, Alpha-Lipoic Acid, Rosehip Extract & Vitamin C', 'grad' => ['#3FA66B', '#0F7A72'], 'description' => 'An antioxidant glutathione combination supporting skin radiance and cellular protection.', 'featured' => true],
            ['name' => 'Neo Glution Plus Tablets', 'pack_size' => '1×10', 'cat' => 'nutraceuticals', 'composition' => 'L-Glutathione, Grape Seed, Alpha-Lipoic Acid, Rosehip & Vitamin C', 'grad' => ['#3FA66B', '#0F7A72'], 'description' => 'An enhanced antioxidant formulation for skin health and cellular wellness support.'],
            ['name' => 'Pravit-9G Softgel Capsules', 'pack_size' => '1×10', 'cat' => 'nutraceuticals', 'composition' => 'Ginseng, Antioxidants with Multivitamin & Multimineral', 'grad' => ['#3FA66B', '#1F7A47'], 'description' => 'A daily wellness softgel combining ginseng and a broad multivitamin-multimineral base.'],
            ['name' => 'Moiseguard Cream / Lotion / Soap', 'pack_size' => '50g / 100ml / 75g', 'cat' => 'nutraceuticals', 'composition' => 'White Soft Paraffin, Light Liquid Paraffin, Aloe Vera & Shea Butter', 'grad' => ['#123A61', '#0B2D4E'], 'description' => 'A moisturising skincare range for dry and sensitive skin, formulated with aloe vera and shea butter.'],
            ['name' => 'Absozyme Syrup', 'pack_size' => '200ml', 'cat' => 'general-medicine', 'composition' => 'Fungal Diastase & Papain with Multivitamin Syrup', 'grad' => ['#0B2D4E', '#123A61'], 'description' => 'A digestive enzyme syrup that supports digestion alongside essential multivitamin supplementation.'],
        ];

        foreach ($products as $i => $p) {
            $product = Product::updateOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'category_id' => $categories[$p['cat']]->id,
                    'name' => $p['name'],
                    'pack_size' => $p['pack_size'],
                    'composition' => $p['composition'],
                    'description' => $p['description'],
                    'gradient_start' => $p['grad'][0],
                    'gradient_end' => $p['grad'][1],
                    'is_featured' => $p['featured'] ?? false,
                    'sort_order' => $i,
                ]
            );

            $product->categories()->sync([$categories[$p['cat']]->id]);
        }
    }

    private function seedTestimonials(): void
    {
        $testimonials = [
            [
                'name' => 'Dr. Rahul Sharma',
                'title' => 'Chief Medical Officer',
                'quote' => 'RJS Pharma has truly set the bar high with their pharmaceutical solutions. Their commitment to quality and innovation has consistently improved the health of our patients.',
                'avatar_url' => 'https://rjspharma.in/wp-content/uploads/2024/03/user1.jpg',
            ],
            [
                'name' => 'Dr. Sanjay Kumar',
                'title' => 'Senior Oncologist',
                'quote' => "The products from RJS Pharma consistently meet the highest standards of quality. Our patients trust the results, and we've seen remarkable improvements across treatments.",
                'avatar_url' => 'https://rjspharma.in/wp-content/uploads/2024/03/user2.jpg',
            ],
            [
                'name' => 'Dr. Anjali Verma',
                'title' => 'Head of Neurology',
                'quote' => 'Partnering with RJS Pharma has been a game-changer for our practice. Their innovative medicines have helped us deliver better patient outcomes with confidence.',
                'avatar_url' => 'https://rjspharma.in/wp-content/uploads/2024/03/user3.jpg',
            ],
        ];

        foreach ($testimonials as $i => $t) {
            Testimonial::updateOrCreate(
                ['name' => $t['name']],
                $t + ['show_on_home' => true, 'show_on_about' => true, 'sort_order' => $i]
            );
        }
    }

    private function seedStats(): void
    {
        $home = [
            ['value' => '22+', 'label' => 'Areas of Expertise'],
            ['value' => '5K+', 'label' => 'Patient Reviews'],
            ['value' => '19+', 'label' => 'Products in Portfolio'],
            ['value' => '4.9', 'label' => 'Average Provider Rating'],
        ];
        $about = [
            ['value' => '22+', 'label' => 'Areas of Expertise'],
            ['value' => '19+', 'label' => 'Products in Portfolio'],
            ['value' => '4.9', 'label' => 'Avg. Provider Rating'],
        ];

        foreach ($home as $i => $s) {
            Stat::updateOrCreate(['page' => 'home', 'label' => $s['label']], $s + ['page' => 'home', 'sort_order' => $i]);
        }
        foreach ($about as $i => $s) {
            Stat::updateOrCreate(['page' => 'about', 'label' => $s['label']], $s + ['page' => 'about', 'sort_order' => $i]);
        }
    }

    private function seedValueProps(): void
    {
        $items = [
            ['title' => 'Our Mission', 'description' => 'To innovate and deliver high-quality pharmaceutical solutions that enhance health and improve lives, ensuring the well-being of patients and communities across India.'],
            ['title' => 'Our Vision', 'description' => 'To lead the future of medicine through cutting-edge research, advanced formulation technologies and a commitment to addressing pressing health challenges nationwide.'],
            ['title' => 'Our Values', 'description' => 'Innovation, integrity, collaboration and accountability — with an unwavering commitment to excellence and patient-centered care in everything we do.'],
        ];

        foreach ($items as $i => $item) {
            ValueProp::updateOrCreate(['title' => $item['title']], $item + ['sort_order' => $i]);
        }
    }

    private function seedMilestones(): void
    {
        $items = [
            ['title' => 'Foundation', 'description' => 'RJS Pharma established with a focus on dermatology and anti-infective therapies, headquartered in New Delhi.'],
            ['title' => 'Portfolio Expansion', 'description' => 'Extended into nutraceuticals and general medicine, growing the range to 19+ marketed products.'],
            ['title' => 'Regional Growth', 'description' => 'Opened operations in Guwahati, Assam to strengthen distribution across North-East India.'],
            ['title' => 'Quality Recognition', 'description' => 'Manufacturing partners aligned to WHO-GMP standards; consistently rated 4.9/5 by healthcare partners.'],
            ['title' => 'Today', 'description' => 'Serving healthcare providers nationwide with a focus on innovation, quality control and patient-centred care.'],
        ];

        foreach ($items as $i => $item) {
            Milestone::updateOrCreate(['title' => $item['title']], $item + ['sort_order' => $i]);
        }
    }

    private function seedCertifications(): void
    {
        $items = [
            ['icon' => '🏭', 'title' => 'WHO-GMP Aligned', 'subtitle' => 'Manufacturing partners'],
            ['icon' => '🧪', 'title' => 'Batch Quality Testing', 'subtitle' => 'Every production batch'],
            ['icon' => '📋', 'title' => 'Regulatory Compliant', 'subtitle' => 'CDSCO guidelines'],
            ['icon' => '🔒', 'title' => 'Secure Supply Chain', 'subtitle' => 'Traceable distribution'],
        ];

        foreach ($items as $i => $item) {
            Certification::updateOrCreate(['title' => $item['title']], $item + ['sort_order' => $i]);
        }
    }

    private function seedProcessSteps(): void
    {
        $steps = [
            ['step_number' => 1, 'title' => 'Research & Development', 'description' => 'Our scientific team identifies unmet therapeutic needs and researches active ingredients, drawing on the latest clinical literature and formulation science.', 'tag' => 'In-house R&D'],
            ['step_number' => 2, 'title' => 'Formulation', 'description' => 'Candidate formulations are developed and refined for stability, bioavailability and patient compliance across tablets, creams, capsules and syrups.', 'tag' => 'Formulation Lab'],
            ['step_number' => 3, 'title' => 'Clinical Trials', 'description' => 'Formulations undergo safety and efficacy evaluation in line with applicable clinical and bioequivalence requirements before approval is sought.', 'tag' => 'Safety & Efficacy'],
            ['step_number' => 4, 'title' => 'Regulatory Approval', 'description' => 'Our regulatory affairs team compiles and submits documentation for approval in line with CDSCO and applicable state licensing authority requirements.', 'tag' => 'CDSCO Compliant'],
            ['step_number' => 5, 'title' => 'Manufacturing', 'description' => 'Approved products move to WHO-GMP aligned manufacturing partners, where every batch undergoes strict in-process and release quality testing.', 'tag' => 'WHO-GMP'],
            ['step_number' => 6, 'title' => 'Distribution', 'description' => 'Finished products move through a secure, temperature-controlled supply chain to stockists, pharmacies and healthcare providers nationwide.', 'tag' => 'Nationwide Reach'],
        ];

        foreach ($steps as $i => $step) {
            ProcessStep::updateOrCreate(['step_number' => $step['step_number']], $step + ['sort_order' => $i]);
        }
    }

    private function seedCultureItems(): void
    {
        $items = [
            ['icon' => '🔬', 'title' => 'Meaningful Work', 'description' => 'Contribute to medicines used by patients across India every day.'],
            ['icon' => '📈', 'title' => 'Room to Grow', 'description' => 'Clear paths across R&D, quality, regulatory, sales and operations.'],
            ['icon' => '🤝', 'title' => 'Collaborative Culture', 'description' => 'Flat teams where new ideas are heard, from the lab to the field.'],
            ['icon' => '🏥', 'title' => 'Health First, Literally', 'description' => 'Wellness benefits reflecting the same care we put into our products.'],
        ];

        foreach ($items as $i => $item) {
            CultureItem::updateOrCreate(['title' => $item['title']], $item + ['sort_order' => $i]);
        }
    }

    private function seedOffices(): void
    {
        $items = [
            ['city' => 'Delhi', 'address' => 'H50 South Ext Part 1, New Delhi 110049'],
            ['city' => 'Guwahati', 'address' => 'GS Road, Barman Complex, Near SBI, Six Mile, Guwahati 781022'],
        ];

        foreach ($items as $i => $item) {
            Office::updateOrCreate(['city' => $item['city']], $item + ['sort_order' => $i]);
        }
    }

    private function seedJobOpenings(): void
    {
        $jobs = [
            ['title' => 'Medical Representative', 'department' => 'Sales', 'location' => 'Guwahati, Assam', 'employment_type' => 'Full-time'],
            ['title' => 'Quality Control Executive', 'department' => 'Quality', 'location' => 'New Delhi', 'employment_type' => 'Full-time'],
            ['title' => 'Regulatory Affairs Associate', 'department' => 'Regulatory', 'location' => 'New Delhi', 'employment_type' => 'Full-time'],
            ['title' => 'Formulation & Development Scientist', 'department' => 'R&D', 'location' => 'New Delhi', 'employment_type' => 'Full-time'],
        ];

        foreach ($jobs as $i => $job) {
            JobOpening::updateOrCreate(['title' => $job['title']], $job + ['is_active' => true, 'sort_order' => $i]);
        }
    }
}
