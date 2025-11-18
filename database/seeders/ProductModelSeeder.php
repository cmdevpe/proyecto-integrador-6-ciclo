<?php

namespace Database\Seeders;

use App\Models\ProductModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            'Classic',
            'Sport',
            'Premium',
            'Basic',
            'Slim Fit'
        ];

        foreach ($models as $model) {
            ProductModel::create([
                'name'   => $model,
                'status' => true,
            ]);
        }
    }
}
