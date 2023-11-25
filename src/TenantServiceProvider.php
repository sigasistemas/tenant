<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Tenant;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Callcocam\Tenant\Commands\TenantCommand;
use Callcocam\Tenant\Facades\Tenant as FacadesTenant;
use Callcocam\Tenant\Models\Tenant;
use Callcocam\Tenant\Testing\TestsTenant;
use Illuminate\Support\Str;

class TenantServiceProvider extends PackageServiceProvider
{
    public static string $name = 'tenant';

    public static string $viewNamespace = 'tenant';

    protected $tenant;

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('callcocam/tenant');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(TenantManager::class, function () {
            return new TenantManager();
        });
    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/tenant/{$file->getFilename()}"),
                ], 'tenant-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsTenant());
        if (config('tenant.enabled', false)) {
            if (!app()->runningInConsole()) :
                $this->bootTenant();
            endif;
        }
    }

    protected function getAssetPackageName(): ?string
    {
        return 'callcocam/tenant';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('tenant', __DIR__ . '/../resources/dist/components/tenant.js'),
            // Css::make('tenant-styles', __DIR__ . '/../resources/dist/tenant.css'),
            // Js::make('tenant-scripts', __DIR__ . '/../resources/dist/tenant.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            TenantCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_tenant_table',
        ];
    }

    public function bootTenant()
    {

        try {
            if (config('tenant.user', false)) {
                if (auth()->check()) {
                    $this->tenant = app($this->getModel())->query()->where('user_id', auth()->user()->id)->first();
                }
            } else {
                $this->tenant = app($this->getModel())->query()->where('domain', str_replace("admin.", "", request()->getHost()))->first();
                if (!$this->tenant) :
                    die(response("Nenhuma empresa cadastrada com esse endereço " . str_replace("admin.", "", request()->getHost()), 401));
                endif;
            }
            if ($this->tenant) {
                FacadesTenant::addTenant("tenant_id", data_get($this->tenant, 'id'));
                config([
                    'app.tenant_id' => $this->tenant->id,
                    'app.name' => Str::limit($this->tenant->name, 20, '...'),
                    'app.tenant' => $this->tenant->toArray(),
                ]);
            }
        } catch (\PDOException $th) {

            throw $th;
        }
    }

    public  function getModel(): string
    {
        return config('tenant.models.tenant', Tenant::class);
    }
}
