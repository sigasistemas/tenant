<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

if (!function_exists('get_tenant_id')) {
    function get_tenant_id($tenant = 'tenant_id')
    {
        $tenantId = \Callcocam\Tenant\Facades\Tenant::getTenantId($tenant);
        return $tenantId;
    }
}

if (!function_exists('get_tenant')) {
    function get_tenant($tenant = 'tenant_id')
    {
        $tenantId = \Callcocam\Tenant\Facades\Tenant::getTenantId($tenant);
        return \App\Models\Callcocam\Tenant::query()->where('id', $tenantId)->first();
    }
}
