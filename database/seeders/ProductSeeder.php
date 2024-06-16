<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Product::create([
            'category_id' => 1,
            'title' => 'Timberland Flyroam',
            'image' => 'https://media.karousell.com/media/photos/products/2024/2/26/timberland_flyroam_size_8_42_2_1708924106_54330ef4_progressive.jpg',
            'size' => "42",
            'weight' => 500,
            'year' => '2019',
            'price' => 1000000,
            'description' => "Timberland Flyroam",
        ]);
        Product::create([
            'category_id' => 1,
            'title' => 'Caterpillar Chukka Transcend Navy Lace Up',
            'image' => 'https://media.karousell.com/media/photos/products/2024/2/12/caterpillar_chukka_transcend_n_1707745048_8404b402_progressive.jpg',
            'size' => "41",
            'weight' => 600,
            'year' => '2018',
            'price' => 950000,
            'description' => "Caterpillar Chukka Transcend Navy Lace Up",
        ]);
        Product::create([
            'category_id' => 1,
            'title' => 'LOUISVUITTON x DORAEMON',
            'image' => 'https://media.karousell.com/media/photos/products/2024/1/12/louisvuitton_x_doraemon_size_4_1705090359_b7506470_progressive.jpg',
            'size' => "41",
            'weight' => 450,
            'year' => '2019',
            'price' => 850000,
            'description' => "LOUISVUITTON x DORAEMON",
        ]);
        Product::create([
            'category_id' => 2,
            'title' => 'Biker Jacket Perfecto Reform',
            'image' => 'https://media.karousell.com/media/photos/products/2024/1/31/biker_jacket_perfecto_reform_s_1706664627_62293c89_progressive.jpg',
            'size' => "M",
            'weight' => 2000,
            'year' => '2017',
            'price' => 350000,
            'description' => "Biker Jacket Perfecto Reform",
        ]);
        Product::create([
            'category_id' => 2,
            'title' => 'TETE HOMME by Issei Miyake',
            'image' => 'https://media.karousell.com/media/photos/products/2023/9/9/jacket_tete_homme_by_issey_miy_1694282407_171fdc11_progressive.jpg',
            'size' => "M",
            'weight' => 1500,
            'year' => '2019',
            'price' => 250000,
            'description' => "TETE HOMME by Issei Miyake",
        ]);
        Product::create([
            'category_id' => 2,
            'title' => 'ACHIEVESTAR',
            'image' => 'https://media.karousell.com/media/photos/products/2023/6/19/jacket_achievestar_size_l_1687206726_7ec50f00_progressive.jpg',
            'size' => "L",
            'weight' => 1200,
            'year' => '2018',
            'price' => 125000,
            'description' => "ACHIEVESTAR",
        ]);
        Product::create([
            'category_id' => 4,
            'title' => 'Longpant Denim WUTANG',
            'image' => 'https://media.karousell.com/media/photos/products/2024/2/27/longpant_denim_wutang_size_34_1709013850_bba45de8_progressive.jpg',
            'size' => "34",
            'weight' => 1500,
            'year' => '2017',
            'price' => 400000,
            'description' => "Longpant Denim WUTANG",
        ]);
        Product::create([
            'category_id' => 4,
            'title' => 'Chino Polo Ralphlaurent',
            'image' => 'https://media.karousell.com/media/photos/products/2024/2/19/chino_polo_ralphlaurent_size_3_1708355895_75b177ab_progressive.jpg',
            'size' => "36",
            'weight' => 1100,
            'year' => '2018',
            'price' => 150000,
            'description' => "Chino Polo Ralphlaurent",
        ]);
        Product::create([
            'category_id' => 4,
            'title' => 'Velvet Tsumori Chisato Issei Miyake',
            'image' => 'https://media.karousell.com/media/photos/products/2023/6/26/shortpant_velved_tsumori_chisa_1687814246_85cb2a94_progressive.jpg',
            'size' => "28",
            'weight' => 900,
            'year' => '2019',
            'price' => 250000,
            'description' => "Velvet Tsumori Chisato Issei Miyake",
        ]);
        Product::create([
            'category_id' => 3,
            'title' => 'FEAR OF GOD 6th Collection',
            'image' => 'https://media.karousell.com/media/photos/products/2023/7/12/kaos_fear_of_god_sixth_collect_1689177803_c6d05e77_progressive.jpg',
            'size' => "M",
            'weight' => 850,
            'year' => '2020',
            'price' => 400000,
            'description' => "FEAR OF GOD 6th Collection",
        ]);
        Product::create([
            'category_id' => 3,
            'title' => 'MERC LONDON',
            'image' => 'https://media.karousell.com/media/photos/products/2023/7/12/kemeja_merc_london_size_105_l_1689192259_37286761_progressive.jpg',
            'size' => "L",
            'weight' => 1050,
            'year' => '2018',
            'price' => 125000,
            'description' => "MERC LONDON",
        ]);
        Product::create([
            'category_id' => 3,
            'title' => 'SANTA CRUZ',
            'image' => 'https://media.karousell.com/media/photos/products/2023/5/31/kemeja_pria_stripe_santa_cruz__1685521572_882839d3_progressive.jpg',
            'size' => "L",
            'weight' => 750,
            'year' => '2019',
            'price' => 150000,
            'description' => "SANTA CRUZ",
        ]);
    }
}
