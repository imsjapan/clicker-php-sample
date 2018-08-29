<?php

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
        // $this->call(UsersTableSeeder::class);
        $this->call(ClickerItemSeeder::class);
        $this->call(ClickerOptionSeeder::class);
        $this->call(AnswerSeeder::class);
        // 外部キーを追加
        Schema::table('clicker_options', function ($table) {
            $table->foreign('clicker_items_id')->references('id')
                ->on('clicker_items')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('answers', function ($table) {
            $table->foreign('clicker_items_id')->references('id')
                ->on('clicker_items')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('answers', function ($table) {
            $table->foreign('clicker_options_id')->references('id')
                ->on('clicker_options')->onDelete('cascade')->onUpdate('cascade');
        });




    }
}
