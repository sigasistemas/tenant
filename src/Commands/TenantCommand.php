<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Tenant\Commands;

use Callcocam\Tenant\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class TenantCommand extends Command
{
    public $signature = 'app:tenant-install';

    public $description = 'Install the Filament Acl tenant package';

    public function handle(): int
    {
        $this->info('Installing Filament Acl tenant');

    
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
