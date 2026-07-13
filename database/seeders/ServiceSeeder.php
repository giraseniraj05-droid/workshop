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
                'image' => 'images/Glass & Aluminium Works.jpg',
                'icon' => 'cog',
                'status' => 'active',
                'price' => 150.00,
                'gallery' => ['images/Glass & Aluminium Works.jpg'],
            ],
            [
                'name_en' => 'Building Cleaning Services',
                'name_ar' => 'خدمات تنظيف المباني',
                'slug' => 'building-cleaning-services',
                'description_en' => 'Complete deep cleaning and sanitization services for commercial buildings, residential complexes, and individual apartments.',
                'description_ar' => 'خدمات تنظيف عميق وتعقيم كاملة للمباني التجارية والمجمعات السكنية والشقق الفردية والفلل.',
                'image' => 'images/Building Cleaning Services.jpg',
                'icon' => 'sparkles',
                'status' => 'active',
                'price' => 80.00,
                'gallery' => ['images/Building Cleaning Services.jpg'],
            ],
            [
                'name_en' => 'Floor & Wall Tiling Works',
                'name_ar' => 'أعمال بلاط الأرضيات والجدران',
                'slug' => 'floor-wall-tiling-works',
                'description_en' => 'Expert floor tiling, backsplash setup, and wall tiling solutions with marble, ceramic, vitrified, or mosaic tiles.',
                'description_ar' => 'حلول احترافية لتبليط الأرضيات وتركيب السيراميك للجدران والمطابخ باستخدام الرخام أو السيراميك أو البورسلان.',
                'image' => 'images/Floor & Wall Tiling Works.jpg',
                'icon' => 'grid',
                'status' => 'active',
                'price' => 200.00,
                'gallery' => ['images/Floor & Wall Tiling Works.jpg'],
            ],
            [
                'name_en' => 'Painting Contracting',
                'name_ar' => 'مقاولات الأصباغ والدهانات',
                'slug' => 'painting-contracting',
                'description_en' => 'Premium interior and exterior wall painting, textures, waterproofing coats, and wood polishing using top-tier paint brands.',
                'description_ar' => 'دهان جدران داخلي وخارجي متميز، وطلاء مقاوم للماء وتلميع الأخشاب مع اختيار أرقى الألوان.',
                'image' => 'images/Painting Contracting.jpg',
                'icon' => 'paint-brush',
                'status' => 'active',
                'price' => 250.00,
                'gallery' => ['images/Painting Contracting.jpg'],
            ],
            [
                'name_en' => 'Plaster Works',
                'name_ar' => 'أعمال اللياسة والجبس',
                'slug' => 'plaster-works',
                'description_en' => 'Flawless gypsum plastering, cement plastering, and wall leveling services to prepare surfaces for painting or tiling.',
                'description_ar' => 'خدمات جبس ولياسة أسمنتية وتسوية الجدران لإعداد الأسطح لأعمال الدهان أو التبليط بشكل مستو ومثالي.',
                'image' => 'images/Plaster Works.jpg',
                'icon' => 'layer-group',
                'status' => 'active',
                'price' => 120.00,
                'gallery' => ['images/Plaster Works.jpg'],
            ],
            [
                'name_en' => 'Carpentry & Wood Flooring',
                'name_ar' => 'أعمال النجارة والأرضيات الخشبية',
                'slug' => 'carpentry-wood-flooring-works',
                'description_en' => 'Premium wooden flooring installations, door repairs, custom wardrobes, cabinet assembly, and generic furniture maintenance.',
                'description_ar' => 'تركيب الأرضيات الخشبية الفاخرة، وإصلاح الأبواب، وتفصيل الخزائن المخصصة، وتجميع وصيانة الأثاث.',
                'image' => 'images/Carpentry & Wood Flooring.jpg',
                'icon' => 'hammer',
                'status' => 'active',
                'price' => 180.00,
                'gallery' => ['images/Carpentry & Wood Flooring.jpg'],
            ],
            [
                'name_en' => 'Plumbing & Sanitary Installation',
                'name_ar' => 'أعمال السباكة والتمديدات الصحية',
                'slug' => 'plumbing-sanitary-installation',
                'description_en' => 'Quick leak repairs, pipeline layout fixes, bathroom fixture installations, water pump servicing, and drain cleaning.',
                'description_ar' => 'إصلاح التسربات السريعة، وإصلاح شبكات الأنابيب، وتركيب أدوات الحمام وصيانة مضخات المياه وتنظيف المجاري.',
                'image' => 'images/Plumbing & Sanitary Installation.jpg',
                'icon' => 'droplet',
                'status' => 'active',
                'price' => 90.00,
                'gallery' => ['images/Plumbing & Sanitary Installation.jpg'],
            ],
            [
                'name_en' => 'False Ceiling & Light Partitions',
                'name_ar' => 'الأسقف المستعارة والقواطع الجبسية',
                'slug' => 'false-ceiling-light-partition-installation',
                'description_en' => 'Elegant POP/Gypsum false ceiling installations, drywall partitions, profile light channels, and acoustic ceiling setups.',
                'description_ar' => 'تركيب أسقف مستعارة أنيقة من الجبس بورد، وقواطع جافة، وتمديد قنوات الإضاءة المخفية والأسقف الصوتية.',
                'image' => 'images/False Ceiling & Light Partitions.jpg',
                'icon' => 'square',
                'status' => 'active',
                'price' => 300.00,
                'gallery' => ['images/False Ceiling & Light Partitions.jpg'],
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
