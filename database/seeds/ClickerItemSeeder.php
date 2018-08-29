<?php

use Illuminate\Database\Seeder;

class ClickerItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        DatabaseSeeder::truncateTable('clicker_items');
        DB::table('clicker_items')->truncate();
        for ($i = 1; $i <= 3; $i++){
            \App\ClickerItems::create([
                'resource_link_id' => '120988f929-00000'.$i,
                'body' => '明日は晴れると思う？'.$i,
                'status' => 'ONGOING',
            ]);
        }

    }
}
