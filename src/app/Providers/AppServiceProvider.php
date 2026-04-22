<?php

namespace App\Providers;

use App\Repositories\BookRepository;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\OrderRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('orders', function (Request $request) {

            return [
                Limit::perMinute(10)->by($request->ip()),
                Limit::perMinute(5)->by($request->header('Idempotency-Key')),
            ];
        });
    }
}
