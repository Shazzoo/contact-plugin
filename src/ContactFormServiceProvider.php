<?php

namespace Shazzoo\ContactForm;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Shazzoo\ContactForm\Http\Controllers\ContactSubmissionController;
use Shazzoo\ContactForm\Models\ContactSubmission;

/**
 * Self-contained so this directory can be lifted into a Composer package: it
 * registers its own views, migrations and route and reaches for nothing
 * outside its own namespace.
 */
class ContactFormServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(dirname(__DIR__).'/config/contact-form.php', 'contact-form');
    }

    public function boot(): void
    {
        $base = dirname(__DIR__);

        $this->loadViewsFrom($base.'/resources/views', 'contact-form');
        $this->loadTranslationsFrom($base.'/lang', 'contact-form');
        $this->loadMigrationsFrom($base.'/database/migrations');

        // Elke site heeft zijn eigen vormgeving: publiceer de views die je wilt
        // herstylen naar resources/views/vendor/contact-form en pas ze daar aan,
        // dan blijft een update van de plugin doorwerken op de rest.
        $this->publishes([
            $base.'/resources/views' => resource_path('views/vendor/contact-form'),
        ], 'contact-form-views');

        $this->publishes([
            $base.'/config/contact-form.php' => config_path('contact-form.php'),
        ], 'contact-form-config');

        // Een taal toevoegen is lang/en/messages.php kopiëren naar
        // lang/<locale>/messages.php; publiceren is alleen nodig om de
        // meegeleverde talen per site te overschrijven.
        $this->publishes([
            $base.'/lang' => $this->app->langPath('vendor/contact-form'),
        ], 'contact-form-lang');

        // De BlockResolver zoekt "<slug>::blocks.<handle>", maar PluginLoader
        // leidt het component-alias af van de mapnaam -- in vendor/ is dat
        // "contact-form-plugin". Zelf registreren houdt de slug uit plugin.json
        // leidend, of de plugin nu in app/Plugins of in vendor/ staat.
        Blade::componentNamespace('Shazzoo\\ContactForm\\View\\Components', 'contact-form');

        // Bewaartermijn: model:prune vindt alleen modellen in app/Models, dus
        // draagt de plugin het model zelf aan. Uit zodra de termijn nul is.
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule): void {
            if ((int) config('contact-form.retention_days') > 0) {
                $schedule->command('model:prune', [
                    '--model' => [ContactSubmission::class],
                ])->daily();
            }
        });

        Route::middleware('web')->group(function (): void {
            Route::post('/contact-form/submit', ContactSubmissionController::class)
                ->name('contact-form.submit');
        });
    }
}
