<?php

namespace Cjpanilag\SimpleNotifications\Providers;

use Cjpanilag\SimpleNotifications\Models\FcmToken;
use Cjpanilag\SimpleNotifications\Models\SimpleDevice;
use Illuminate\Database\Eloquent\Model;
use Luchavez\StarterKit\Abstracts\BaseStarterKitServiceProvider as ServiceProvider;
use Cjpanilag\SimpleNotifications\Services\SimpleNotifications;
use Luchavez\StarterKit\Interfaces\ProviderDynamicRelationshipsInterface;

/**
 * Class SimpleNotificationsServiceProvider
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class SimpleNotificationsServiceProvider extends ServiceProvider implements ProviderDynamicRelationshipsInterface
{
    /**
     * @var array
     */
    protected array $commands = [];

    /**
     * @var string|null
     */
    protected string|null $route_prefix = null;

    /**
     * @var bool
     */
    protected bool $prefix_route_with_file_name = false;

    /**
     * @var bool
     */
    protected bool $prefix_route_with_directory = false;

    /**
     * Polymorphism Morph Map
     *
     * @link    https://laravel.com/docs/8.x/eloquent-relationships#custom-polymorphic-types
     *
     * @example [ 'user' => User::class ]
     *
     * @var array
     */
    protected array $morph_map = [];

    /**
     * Laravel Observer Map
     *
     * @link    https://laravel.com/docs/8.x/eloquent#observers
     *
     * @example [ UserObserver::class => User::class ]
     *
     * @var array
     */
    protected array $observer_map = [];

    /**
     * Laravel Policy Map
     *
     * @link    https://laravel.com/docs/8.x/authorization#registering-policies
     *
     * @example [ UserPolicy::class => User::class ]
     *
     * @var array
     */
    protected array $policy_map = [];

    /**
     * Laravel Repository Map
     *
     * @example [ UserRepository::class => User::class ]
     *
     * @var array
     */
    protected array $repository_map = [];

    /**
     * Publishable Environment Variables
     *
     * @example [ 'HELLO_WORLD' => true ]
     *
     * @var array
     */
    protected array $env_vars = [
        // config/services.php
        'AWS_ACCESS_KEY_ID' => null,
        'AWS_SECRET_ACCESS_KEY' => null,
        'AWS_DEFAULT_REGION' => null,

        // config/mail.php
        'MAIL_MAILER' => 'ses',
        'MAIL_FROM_ADDRESS' => null,
        'MAIL_FROM_NAME' => '${APP_NAME}',

        // FCM related
        'FIREBASE_APP_LINK' => null,
        'FIREBASE_APN' => null,
        'FIREBASE_CM_KEY' => null,
        'FIREBASE_CREDENTIALS' => null,
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        // config injection
        if (! app()->configurationIsCached() && ! config('services.sns')) {
            config(['services.sns' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
                'region' => env('AWS_DEFAULT_REGION', 'ap-southeast-2'),
            ]]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        // Register the service the package provides.
        $this->app->singleton('simple-notifications', fn () => new SimpleNotifications());
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['simple-notifications'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../../config/simple-notifications.php' => config_path('simple-notifications.php'),
        ], 'simple-notifications.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/cjpanilag'),
        ], 'simple-notifications.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/cjpanilag'),
        ], 'simple-notifications.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/cjpanilag'),
        ], 'simple-notifications.views');*/

        // Registering package commands.
        $this->commands($this->commands);
    }

    /**
     * Dynamic Relationships.
     *
     * @return void
     *
     * @link   https://laravel.com/docs/8.x/eloquent-relationships#dynamic-relationships
     */
    public function registerDynamicRelationships(): void
    {
        starter_kit()->getUserModel()::resolveRelationUsing('simpleDevices', function (Model $model) {
            return $model->hasMany(SimpleDevice::class);
        });

        starter_kit()->getUserModel()::resolveRelationUsing('fcmTokens', function (Model $model) {
            return $model->hasManyThrough(FcmToken::class, SimpleDevice::class);
        });
    }
}
