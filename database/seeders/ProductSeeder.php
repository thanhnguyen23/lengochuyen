<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'iPhone 14 Pro Max',
                'description' => 'Điện thoại iPhone 14 Pro Max mới nhất với camera 48MP, chip A16 Bionic và Dynamic Island',
                'price' => 1299.99,
                'brand' => 'Apple',
                'color' => 'Deep Purple',
                'type' => 'Smartphone',
                'stock' => 50,
                'image_url' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-14-pro-finish-select-202209-6-7inch-deeppurple?wid=5120&hei=2880&fmt=p-jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'Samsung Galaxy S23 Ultra',
                'description' => 'Điện thoại Samsung Galaxy S23 Ultra với bút S-Pen, camera 200MP và pin 5000mAh',
                'price' => 1199.99,
                'brand' => 'Samsung',
                'color' => 'Phantom Black',
                'type' => 'Smartphone',
                'stock' => 45,
                'image_url' => 'https://images.samsung.com/vn/smartphones/galaxy-s23-ultra/images/galaxy-s23-ultra-highlights-color-green-front.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'MacBook Pro 16"',
                'description' => 'Laptop MacBook Pro 16 inch với chip M2 Pro, 16GB RAM và 512GB SSD',
                'price' => 2499.99,
                'brand' => 'Apple',
                'color' => 'Space Gray',
                'type' => 'Laptop',
                'stock' => 30,
                'image_url' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/mbp16-spacegray-select-202301?wid=904&hei=840&fmt=jpeg',
                'is_featured' => true,
            ],
            [
                'name' => 'Dell XPS 15',
                'description' => 'Laptop Dell XPS 15 với Intel Core i9, RTX 3050 Ti và màn hình OLED',
                'price' => 2299.99,
                'brand' => 'Dell',
                'color' => 'Silver',
                'type' => 'Laptop',
                'stock' => 25,
                'image_url' => 'https://i.dell.com/is/image/DellContent/content/dam/ss2/product-images/dell-client-products/notebooks/xps-notebooks/xps-15-9520/media-gallery/black/laptop-xps-9520-t-black-gallery-1.psd?fmt=png-alpha',
                'is_featured' => false,
            ],
            [
                'name' => 'iPad Pro 12.9"',
                'description' => 'Máy tính bảng iPad Pro 12.9 inch với chip M2, màn hình Liquid Retina XDR',
                'price' => 1099.99,
                'brand' => 'Apple',
                'color' => 'Silver',
                'type' => 'Tablet',
                'stock' => 40,
                'image_url' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/ipad-pro-12-select-wifi-silver-202104?wid=940&hei=1112&fmt=png-alpha',
                'is_featured' => true,
            ],
            [
                'name' => 'Samsung Galaxy Tab S9 Ultra',
                'description' => 'Máy tính bảng Samsung Galaxy Tab S9 Ultra với màn hình 14.6 inch, S-Pen',
                'price' => 1199.99,
                'brand' => 'Samsung',
                'color' => 'Graphite',
                'type' => 'Tablet',
                'stock' => 35,
                'image_url' => 'https://images.samsung.com/is/image/samsung/p6pim/vn/sm-x910nzaexev/gallery/vn-galaxy-tab-s9-ultra-wifi-x910-sm-x910nzaexev-thumb-537239027',
                'is_featured' => false,
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Tai nghe chống ồn Sony WH-1000XM5 với âm thanh Hi-Res',
                'price' => 399.99,
                'brand' => 'Sony',
                'color' => 'Black',
                'type' => 'Headphone',
                'stock' => 60,
                'image_url' => 'https://electronics.sony.com/image/5d02da5c70a68aa6c377b069ab05d41c?fmt=png-alpha&wid=660&hei=660',
                'is_featured' => true,
            ],
            [
                'name' => 'Apple AirPods Pro 2',
                'description' => 'Tai nghe Apple AirPods Pro 2 với chống ồn chủ động và âm thanh không gian',
                'price' => 249.99,
                'brand' => 'Apple',
                'color' => 'White',
                'type' => 'Headphone',
                'stock' => 75,
                'image_url' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MQD83?wid=1144&hei=1144&fmt=jpeg',
                'is_featured' => true,
            ],
            [
                'name' => 'Apple Watch Series 8',
                'description' => 'Đồng hồ thông minh Apple Watch Series 8 với cảm biến nhiệt độ và theo dõi sức khỏe',
                'price' => 399.99,
                'brand' => 'Apple',
                'color' => 'Midnight',
                'type' => 'Smartwatch',
                'stock' => 55,
                'image_url' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MQDY3ref_VW_34FR+watch-45-alum-midnight-nc-8s_VW_34FR_WF_CO?wid=1400&hei=1400',
                'is_featured' => true,
            ],
            [
                'name' => 'Samsung Galaxy Watch 6 Classic',
                'description' => 'Đồng hồ thông minh Samsung Galaxy Watch 6 Classic với vòng xoay bezel',
                'price' => 399.99,
                'brand' => 'Samsung',
                'color' => 'Black',
                'type' => 'Smartwatch',
                'stock' => 45,
                'image_url' => 'https://images.samsung.com/is/image/samsung/p6pim/vn/2307/gallery/vn-galaxy-watch6-classic-r955-sm-r955fzsaxxv-thumb-537234726',
                'is_featured' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
