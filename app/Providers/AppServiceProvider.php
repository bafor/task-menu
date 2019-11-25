<?php

namespace App\Providers;

use App\Domain\Menus as MenusDomain;
use App\Infrastructure\Domain\MenuFileRepository;
use App\Infrastructure\View\MenuViewEloquentRepository;
use App\View\Menus;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Menus::class, MenuViewEloquentRepository::class);
        $this->app->bind(MenusDomain::class, MenuFileRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Resource::withoutWrapping();
    }
}
