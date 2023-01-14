<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'title' => 'Unlocking Android',
            'description' => 'Unlocking Android: A Developers Guide provides concise, hands-on instruction for the Android operating system and development tools.',
            'code' => 'B1',
            'price' => 10000,
            'image' => 'https://s3.amazonaws.com/AKIAJC5RLADLUMVRPFDQ.book-thumb-images/ableson.jpg',
            'qty' => 1,
            'stock' => 10,
            'supplier_id' => 1,
        ]);

        Product::create([
            'title' => 'Android in Action, Second Edition',
            'description' => 'Android in Action, Second Edition is a comprehensive tutorial for Android developers. Taking you far beyond \"Hello Android,\" this fast-paced book puts you in the drivers seat as you learn important architectural concepts and implementation strategies.',
            'code' => 'B2',
            'price' => 20000,
            'image' => 'https://s3.amazonaws.com/AKIAJC5RLADLUMVRPFDQ.book-thumb-images/ableson2.jpg',
            'stock' => 20,
            'qty' => 1,
            'supplier_id' => 2,
        ]);

        Product::create([
            'title' => 'Flex 3 in Action',
            'description' => 'New web applications require engaging user-friendly interfaces   and the cooler, the better. With Flex 3, web developers at any skill level can create high-quality, effective, and interactive Rich Internet Applications (RIAs) quickly and easily.',
            'code' => 'B3',
            'price' => 30000,
            'image' => 'https://s3.amazonaws.com/AKIAJC5RLADLUMVRPFDQ.book-thumb-images/ahmed.jpg',
            'stock' => 30,
            'qty' => 1,
            'supplier_id' => 3,
        ]);

        Product::create([
            'title' => 'Collective Intelligence in Action',
            'description' => 'heres a great deal of wisdom in a crowd, but how do you listen to a thousand people talking at once  Identifying the wants, needs, and knowledge of internet users can be like listening to a mob.',
            'code' => 'B4',
            'price' => 40000,
            'image' => 'https://s3.amazonaws.com/AKIAJC5RLADLUMVRPFDQ.book-thumb-images/alag.jpg',
            'stock' => 40,
            'qty' => 1,
            'supplier_id' => 4,
        ]);

        Product::create([
            'title' => 'Zend Framework in Action',
            'description' => 'Zend Framework in Action is a comprehensive tutorial that shows how to use the Zend Framework to create web-based applications and web services.',
            'code' => 'B5',
            'price' => 50000,
            'image' => 'https://s3.amazonaws.com/AKIAJC5RLADLUMVRPFDQ.book-thumb-images/allen.jpg',
            'stock' => 50,
            'qty' => 1,
            'supplier_id' => 5,
        ]);
    }
}
