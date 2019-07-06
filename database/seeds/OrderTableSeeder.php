<?php

use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
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
        for ($i=0; $i < 500; $i++) { 
            Illuminate\Support\Facades\DB::table('orders')->insert([
                'type' => $faker->randomElement(['wechat','alipay']),     
                'order_no' => md5(mt_rand(0000,9999)),
                'money' => mt_rand(0000,9999),
                'mark' => strtolower($faker->lastName),
                'dt' => date('Y-m-d H:i:s',time()),
                'mch_id' => $faker->randomElement(['111111','222222','333333']),
                'shopId' => $faker->randomElement(['555555','666666','777777']),
                'account' => '22222222',
                'status' => mt_rand(1,5),
                'desc' => $faker->text(200),
            ]);
        }
    }
}
