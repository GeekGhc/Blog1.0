<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name' => '极客学院',
                'link_title' => '国内最大的教育平台',
                'link_url' => 'http://www.jikexueyuan.com',
                'link_order' => 1,
            ],
            [
                'link_name' => '百度',
                'link_title' => '国内最大的教育平台1',
                'link_url' => 'http://www.baidu.com',
                'link_order' => 2,
            ],
            [
                'link_name' => '新浪',
                'link_title' => '国内最大的教育平台2',
                'link_url' => 'http://www.sina.com',
                'link_order' => 3,
            ]
        ];
        DB::table('links')->insert($data);
    }
}
