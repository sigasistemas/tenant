<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Tenant\Commands;

use App\Models\Callcocam\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class TenantCommand extends Command
{
    public $signature = 'app:tenant-install';

    public $description = 'Install the Filament Acl tenant package';

    public function handle(): int
    {
        $this->info('Installing Filament Acl tenant');

        $this->call('vendor:publish', [
            '--tag' => 'tenant-config',
        ]);
        $this->call('vendor:publish', [
            '--tag' => 'tenant-migrations',
        ]);
        $this->call('vendor:publish', [
            '--tag' => 'tenant-translations',
        ]);

        if (!is_dir(app_path('Models/Callcocam'))) {
            File::makeDirectory(app_path('Models/Callcocam'), 0755, true);
        }

        if (!class_exists('App\Models\Callcocam\AbstractTenantModel')) {
            File::put(app_path('Models/Callcocam/AbstractTenantModel.php'), file_get_contents(__DIR__ . '/stubs/abstract-model.stub'));
        }

        if (!class_exists('App\Models\Callcocam\Tenant')) {
            File::put(app_path('Models/Callcocam/Tenant.php'), file_get_contents(__DIR__ . '/stubs/tenant-model.stub'));

            if (!class_exists('App\Models\Callcocam\Address')) {
                File::put(app_path('Models/Callcocam/Address.php'), file_get_contents(__DIR__ . '/stubs/address-model.stub'));
            }
            if (!class_exists('App\Models\Callcocam\Contact')) {
                File::put(app_path('Models/Callcocam/Contact.php'), file_get_contents(__DIR__ . '/stubs/contact-model.stub'));
            }
            if (!class_exists('App\Models\Callcocam\Document')) {
                File::put(app_path('Models/Callcocam/Document.php'), file_get_contents(__DIR__ . '/stubs/document-model.stub'));
            }
            if (!class_exists('App\Models\Callcocam\Social')) {
                File::put(app_path('Models/Callcocam/Social.php'), file_get_contents(__DIR__ . '/stubs/social-model.stub'));
            }
            if (!class_exists('App\Models\Callcocam\Image')) {
                File::put(app_path('Models/Callcocam/Image.php'), file_get_contents(__DIR__ . '/stubs/image-model.stub'));
            }

            $this->info('Tenant model created successfully.');
            $this->info('Please enable the tenant in config/tenant.php');
            $this->info('Please run "php artisan app:acl-tenant-install" to continue');
            return true;
        }
        if (!config('tenant.enabled')) {
            $this->error('Please enable the tenant in config/tenant.php');
            $this->error('Please run "php artisan app:acl-tenant-install" to continue');
            return true;
        }

        $this->call('migrate');

        if ($this->confirm('Do you want to create a tenant?')) {
            $this->createTenant();
        }

        $this->info('Filament Acl installed successfully.');
        
        return self::SUCCESS;
    }
    protected function createTenant()
    {

        $nome = $this->ask('What is the name of the tenant?', 'Tenant do sistema');

        $email = $this->ask('What is the email of the tenant?', 'tenant@example.com');

        $domain = $this->ask('What is the domain of the tenant?', request()->getHost());

        $status = $this->choice('What is the status of the tenant?', ['draft', 'published'], 1);

        $description = $this->ask('What is the description of the tenant?', 'Tenant do sistema');


        Tenant::create([
            'name' => $nome,
            'email' => $email,
            'domain' => $domain,
            'status' => $status,
            'description' => $description,
        ]);

        $this->info(sprintf('Tenant %s created successfully.', $nome));
    }
}
