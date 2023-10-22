<?php

use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Temperature device (AC, heater, ventilator, ...)',],
            ['id' => 2, 'name' => 'Lamp / lighting device',],
            ['id' => 3, 'name' => 'Extention cable',],
            ['id' => 4, 'name' => 'Other',]
 

        ];

        foreach ($items as $item) {
            \App\Category::create($item);
        }
    }
}
