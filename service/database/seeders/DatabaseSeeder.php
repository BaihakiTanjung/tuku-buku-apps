<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TransactionDetail;
use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\PaymentSeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\TransactionDetailSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
            PaymentSeeder::class,
            TransactionSeeder::class,
            TransactionDetailSeeder::class,
        ]);
    }
}
