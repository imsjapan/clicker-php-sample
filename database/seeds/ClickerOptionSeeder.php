<?php

use Illuminate\Database\Seeder;

class ClickerOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('clicker_options')->truncate();
        for ($i = 1; $i <= 3; $i++){
            \App\ClickerOptions::create([
                'title' => '選択肢'.$i.'-1',
                'clicker_items_id' => $i,
            ]);
            \App\ClickerOptions::create([
                'title' => '選択肢'.$i.'-2',
                'clicker_items_id' => $i,
            ]);
        }

    }
}
