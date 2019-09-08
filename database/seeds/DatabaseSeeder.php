<?php

use App\Models\User;
use App\Models\Information;
use App\Models\Wallet;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Tiền sinh hoạt',
            'user_id' => 1,
            'type' => CHI,
            'parent_id' => 0,
        ]); 

        DB::table('categories')->insert([
            'name' => 'Nhận lương',
            'user_id' => 1,
            'type' => THU,
            'parent_id' => 0,
        ]); 

        DB::table('categories')->insert([
            'name' => 'Tiền học tập',
            'user_id' => 2,
            'type' => CHI,
            'parent_id' => 0,
        ]); 

        DB::table('categories')->insert([
            'name' => 'Bán hàng',
            'user_id' => 2,
            'type' => THU,
            'parent_id' => 0,
        ]); 

        DB::table('categories')->insert([
            'name' => 'Tiền ăn chơi',
            'user_id' => 3,
            'type' => CHI,
            'parent_id' => 0,
        ]); 

        DB::table('categories')->insert([
            'name' => 'Ship hàng',
            'user_id' => 3,
            'type' => THU,
            'parent_id' => 0,
        ]); 

        factory(User::class, 3)->create()->each(function ($user) {
            factory(Information::class, 1)->create(['user_id'=>$user->id]);
            factory(Wallet::class, 5)->create(['user_id'=>$user->id]);
        });
        
        factory(Category::class, 15)->create();
    }
}
