<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

if (!function_exists('get_tenant_id')) {
    function get_tenant_id($tenant = 'tenant_id')
    {
        if (config('tenant.user', false)) {
            $tenantId = data_get(auth()->user(), $tenant);
            return $tenantId;
        }
        $tenantId = \Callcocam\Tenant\Facades\Tenant::getTenantId($tenant);
        return $tenantId;
    }
}

if (!function_exists('get_tenant')) {
    function get_tenant($tenant = 'tenant_id')
    {
        $tenantId = \Callcocam\Tenant\Facades\Tenant::getTenantId($tenant);

        $model = config('tenant.models.tenant', \Callcocam\Tenant\Models\Tenant::class);
        
        return app($model)->query()->where('id', $tenantId)->first();
    }
}
