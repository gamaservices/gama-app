<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentIcon;
use Illuminate\Support\ServiceProvider;

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
        FilamentIcon::register([
            'actions::delete-action'            => 'phosphor-trash-duotone',
            'actions::force-delete-action'      => 'phosphor-trash-fill',
            'actions::delete-action.modal'      => 'phosphor-trash-duotone',
            'actions::restore-action'           => 'phosphor-arrow-u-up-left-duotone',
            'actions::edit-action'              => 'phosphor-pencil-duotone',
            'actions::edit-action.grouped'      => 'phosphor-pencil-duotone',
            'tables::actions.open-bulk-actions' => 'phosphor-dots-three-outline-vertical-duotone',

            'forms::components.text-input.actions.hide-password' => 'phosphor-eye-slash-duotone',
            'forms::components.text-input.actions.show-password' => 'phosphor-eye-duotone',

            'panels::global-search.field'           => 'phosphor-magnifying-glass-duotone',
            'panels::theme-switcher.dark-button'    => 'phosphor-moon-duotone',
            'panels::theme-switcher.light-button'   => 'phosphor-sun-duotone',
            'panels::theme-switcher.system-button'  => 'phosphor-desktop-duotone',
            'panels::topbar.global-search.field'    => 'phosphor-magnifying-glass-duotone',
            'panels::user-menu.logout-button'       => 'phosphor-sign-out-duotone',
            'panels::user-menu.profile-item'        => 'phosphor-user-square-duotone',
            'panels::widgets.account.logout-button' => 'phosphor-sign-out-duotone',

            'tables::actions.filter'            => 'phosphor-funnel-duotone',
            'tables::actions.toggle-columns'    => 'phosphor-square-split-horizontal-duotone',
            'tables::columns.icon-column.false' => 'phosphor-x-circle-duotone',
            'tables::columns.icon-column.true'  => 'phosphor-check-circle-duotone',
            'tables::search-field'              => 'phosphor-magnifying-glass-duotone',
        ]);
    }
}
