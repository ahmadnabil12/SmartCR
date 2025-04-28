<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

use App\Models\Grant; 

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
        // Admin gate
        Gate::define('isAdmin', function ($user) {
            return $user->userCategory === 'admin';
        });

        // Staff gate
        Gate::define('isStaff', function ($user) {
            return $user->userCategory === 'staff';
        });

        // Academician gate
        Gate::define('isAcademician', function ($user) {
            return $user->userCategory === 'academician';
        });

        // Admin and Staff combined gate
        Gate::define('AdminStaff', function ($user) {
            return $user->userCategory === 'admin' || $user->userCategory === 'staff';
        });

        // Admin, Academician, and Staff combined gate
        Gate::define('AdminAcademicianStaff', function ($user) {
            return $user->userCategory === 'admin' || $user->userCategory === 'staff' || $user->userCategory === 'academician';
        });

        // Define the isLeader gate properly
        Gate::define('isLeader', function ($user) {

            //$grants = Grant::all();

                         return Grant::whereHas('academicians', function ($query) use ($user) {
                            $query->where('user_id', $user->id)
                                  ->where('role', 'leader');
                        })->exists();
        });

        Gate::define('AdminStaffLeader', function ($user) {
            return $user->userCategory === 'admin' || $user->userCategory === 'staff' || 
                   Grant::whereHas('academicians', function ($query) use ($user) {
                       $query->where('user_id', $user->id)
                             ->where('role', 'leader');
                   })->exists();
        });

        /*Gate::define('isMember', function ($user, $grant) {
            return $grant -> academicians()->wherePivot(academician_id, $user->academician_id)->exists();
        });

        Gate::define('isLeader', function ($user, $grant) {
            return $grant -> leader_id == $user -> academician_id;
        });
        
        Gate::define('isLeader', function ($user, $grant) {
            return $grant->leader_id == $user->id;
        });*/

    }
}
