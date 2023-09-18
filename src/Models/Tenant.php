<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

 namespace Callcocam\Tenant\Models;

use App\Models\Callcocam\AbstractModel;
use Callcocam\Tenant\Traits\HasInfoModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Tenant extends AbstractModel
{
    use HasFactory, Notifiable;

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function socials()
    {
        return $this->morphMany(Social::class, 'socialable');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
 
  
}
