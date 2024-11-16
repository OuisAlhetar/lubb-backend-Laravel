<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;



class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Filament::serving(function () {
            $user = Auth::user();

            if ($user) {
                if ($user->hasRole('super-admin')) {
                    Filament::registerNavigationGroups([
                        'Admin Section',
                        'Movies Management',
                        'Podcasts',
                        'Tags Management',
                        'Categories Management',
                    ]);
                } elseif ($user->hasRole('admin')) {
                    Filament::registerNavigationGroups([
                        'Movies Management',
                        'Podcasts',
                        'Tags Management',
                    ]);
                } else {
                    Filament::registerNavigationGroups([
                        'User Dashboard',
                    ]);
                }
            }
        });
    }
}