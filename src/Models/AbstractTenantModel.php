<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Tenant\Models;

use Callcocam\Profile\Traits\HasProfileModel;
use Callcocam\Tenant\Traits\HasUlids;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbstractTenantModel extends Model
{
    use SoftDeletes, HasProfileModel, HasUlids;

    public function __construct(array $attributes = [])
    {
        $this->incrementing = config('tenant.incrementing', true);

        $this->keyType = config('tenant.keyType', 'int');

        parent::__construct($attributes);
    }

    protected $guarded = [
        'id'
    ];

    public function scopeTenant(Builder $query): void
    {
        // $query->where('tenant_id', auth()->user()->tenant_id);
    }
}
