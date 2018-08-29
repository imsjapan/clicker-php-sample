<?php

use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('answers')->truncate();

        for ($i = 1; $i <= 3; $i++){
            $clicker_option = DB::table('clicker_options')->find($i);
            \App\Answers::create([
                'user_id' => '0000'.($i*2),
                'clicker_items_id' => $clicker_option->clicker_items_id,
                'clicker_options_id' => $clicker_option->id,
            ]);
        }

    }
}
