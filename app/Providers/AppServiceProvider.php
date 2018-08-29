<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        /**
         * インターフェースと具象クラスを束縛(バインド)します
         * これにより、インターフェースをタイプヒンティングするだけで具象クラスのインスタンスが取得できます。
         */
        $this->app->bind(
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );
        $this->app->bind(
            \App\Repositories\AnswerRepositoryInterface::class,
            function ($app) {
                return new \App\Repositories\AnswerRepository(
                    new \App\Answers
                );
            }
        );
        $this->app->bind(
            \App\Repositories\ClickerItemRepositoryInterface::class,
            function ($app) {
                return new \App\Repositories\ClickerItemRepository(
                    new \App\ClickerItems
                );
            }
        );
    }
}
