<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // INSERT INTO Categories (parent_id, name , slug , description , image)
        // VALUES (null , 'clothes' , 'clothes' , null ,  null)
    
        // Query Builder
        // DB::table('categories')->insert([
        //     'parent_id' => null,
        //     'name' => 'Clothes',
        //     'slug' => 'Clothe',
        //     'description' => null ,
        //     'image' => null,
        // ]);

        DB::statement("INSERT INTO categories (parent_id, name , slug , description , image)
        VALUES( 1 , 'Kids' , 'Kid' , null ,  null)");
    }
}
