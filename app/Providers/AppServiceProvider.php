<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

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
            if (auth()->check()) {
                $user = auth()->user();
                $notifications = Notification::where('user_id', $user->id)
                                    ->latest()
                                    ->take(5)
                                    ->get();
                $unreadCount = Notification::where('user_id', $user->id)
                                    ->where('is_read', false)
                                    ->count();
                $view->with(compact('notifications', 'unreadCount'));
            }
        });
    }
}
