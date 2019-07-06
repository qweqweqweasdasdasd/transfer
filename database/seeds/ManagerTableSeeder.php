<?php

use Illuminate\Database\Seeder;

class ManagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //使用 faker 实现大量数据的模拟
        $faker = \Faker\Factory::create();  //'zh_CN'
        //填充20条数据
        for ($i=0; $i < 10; $i++) { 
            Illuminate\Support\Facades\DB::table('managers')->insert([
                'mg_name' => $faker->lastName,          //管理员(名)
                'password' => bcrypt('123456'),         //密码
                'status' => 1
            ]);
        }
    }
}
