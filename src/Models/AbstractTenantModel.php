<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Tenant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbstractTenantModel extends Model
{
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        $this->incrementing = config('tenant.incrementing', true);

        $this->keyType = config('tenant.keyType', 'int');

        parent::__construct($attributes);
    }

    protected $guarded = [
        'id'
    ];

    
}
