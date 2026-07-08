<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name_en' => 'Glass & Aluminium Works',
                'name_ar' => 'أعمال الزجاج والألومنيوم',
                'slug' => 'glass-aluminium-installation-maintenance',
                'description_en' => 'Professional installation, repair, and maintenance of glass panels, aluminium doors, windows, and custom framing for homes and offices.',
                'description_ar' => 'تركيب وإصلاح وصيانة احترافية للألواح الزجاجية والأبواب والنوافذ المصنوعة من الألومنيوم والإطارات المخصصة للمنازل والمكاتب.',
                'image' => 'services/glass-aluminium.jpg',
                'icon' => 'cog',
                'status' => 'active',
                'price' => 150.00,
                'gallery' => ['services/glass1.jpg', 'services/glass2.jpg'],
            ],
            [
                'name_en' => 'Building Cleaning Services',
                'name_ar' => 'خدمات تنظيف المباني',
                'slug' => 'building-cleaning-services',
                'description_en' => 'Complete deep cleaning and sanitization services for commercial buildings, residential complexes, and individual apartments.',
                'description_ar' => 'خدمات تنظيف عميق وتعقيم كاملة للمباني التجارية والمجمعات السكنية والشقق الفردية والفلل.',
                'image' => 'services/cleaning.jpg',
                'icon' => 'sparkles',
                'status' => 'active',
                'price' => 80.00,
                'gallery' => ['services/clean1.jpg', 'services/clean2.jpg'],
            ],
            [
                'name_en' => 'Floor & Wall Tiling Works',
                'name_ar' => 'أعمال بلاط الأرضيات والجدران',
                'slug' => 'floor-wall-tiling-works',
                'description_en' => 'Expert floor tiling, backsplash setup, and wall tiling solutions with marble, ceramic, vitrified, or mosaic tiles.',
                'description_ar' => 'حلول احترافية لتبليط الأرضيات وتركيب السيراميك للجدران والمطابخ باستخدام الرخام أو السيراميك أو البورسلان.',
                'image' => 'services/tiling.jpg',
                'icon' => 'grid',
                'status' => 'active',
                'price' => 200.00,
                'gallery' => ['services/tile1.jpg', 'services/tile2.jpg'],
            ],
            [
                'name_en' => 'Painting Contracting',
                'name_ar' => 'مقاولات الأصباغ والدهانات',
                'slug' => 'painting-contracting',
                'description_en' => 'Premium interior and exterior wall painting, textures, waterproofing coats, and wood polishing using top-tier paint brands.',
                'description_ar' => 'دهان جدران داخلي وخارجي متميز، وطلاء مقاوم للماء وتلميع الأخشاب مع اختيار أرقى الألوان.',
                'image' => 'services/painting.jpg',
                'icon' => 'paint-brush',
                'status' => 'active',
                'price' => 250.00,
                'gallery' => ['services/paint1.jpg', 'services/paint2.jpg'],
            ],
            [
                'name_en' => 'Plaster Works',
                'name_ar' => 'أعمال اللياسة والجبس',
                'slug' => 'plaster-works',
                'description_en' => 'Flawless gypsum plastering, cement plastering, and wall leveling services to prepare surfaces for painting or tiling.',
                'description_ar' => 'خدمات جبس ولياسة أسمنتية وتسوية الجدران لإعداد الأسطح لأعمال الدهان أو التبليط بشكل مستو ومثالي.',
                'image' => 'services/plaster.jpg',
                'icon' => 'layer-group',
                'status' => 'active',
                'price' => 120.00,
                'gallery' => ['services/plaster1.jpg', 'services/plaster2.jpg'],
            ],
            [
                'name_en' => 'Carpentry & Wood Flooring',
                'name_ar' => 'أعمال النجارة والأرضيات الخشبية',
                'slug' => 'carpentry-wood-flooring-works',
                'description_en' => 'Premium wooden flooring installations, door repairs, custom wardrobes, cabinet assembly, and generic furniture maintenance.',
                'description_ar' => 'تركيب الأرضيات الخشبية الفاخرة، وإصلاح الأبواب، وتفصيل الخزائن المخصصة، وتجميع وصيانة الأثاث.',
                'image' => 'services/carpentry.jpg',
                'icon' => 'hammer',
                'status' => 'active',
                'price' => 180.00,
                'gallery' => ['services/carpentry1.jpg', 'services/carpentry2.jpg'],
            ],
            [
                'name_en' => 'Plumbing & Sanitary Installation',
                'name_ar' => 'أعمال السباكة والتمديدات الصحية',
                'slug' => 'plumbing-sanitary-installation',
                'description_en' => 'Quick leak repairs, pipeline layout fixes, bathroom fixture installations, water pump servicing, and drain cleaning.',
                'description_ar' => 'إصلاح التسربات السريعة، وإصلاح شبكات الأنابيب، وتركيب أدوات الحمام وصيانة مضخات المياه وتنظيف المجاري.',
                'image' => 'services/plumbing.jpg',
                'icon' => 'droplet',
                'status' => 'active',
                'price' => 90.00,
                'gallery' => ['services/plumbing1.jpg', 'services/plumbing2.jpg'],
            ],
            [
                'name_en' => 'False Ceiling & Light Partitions',
                'name_ar' => 'الأسقف المستعارة والقواطع الجبسية',
                'slug' => 'false-ceiling-light-partition-installation',
                'description_en' => 'Elegant POP/Gypsum false ceiling installations, drywall partitions, profile light channels, and acoustic ceiling setups.',
                'description_ar' => 'تركيب أسقف مستعارة أنيقة من الجبس بورد، وقواطع جافة، وتمديد قنوات الإضاءة المخفية والأسقف الصوتية.',
                'image' => 'services/ceiling.jpg',
                'icon' => 'square',
                'status' => 'active',
                'price' => 300.00,
                'gallery' => ['services/ceiling1.jpg', 'services/ceiling2.jpg'],
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
