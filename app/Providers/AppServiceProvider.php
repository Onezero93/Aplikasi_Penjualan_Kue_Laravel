<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    View::composer('*', function ($view) {
        $jumlahKeranjang = 0;
        $items = collect(); // default kosong

        if (Auth::check()) {
            $userId = Auth::id();
            $jumlahKeranjang = Keranjang::where('user_id', $userId)->count();
            $items = Keranjang::with('produk')->where('user_id', $userId)->get();
        }

        $view->with(compact('jumlahKeranjang', 'items'));
    });
}

}
