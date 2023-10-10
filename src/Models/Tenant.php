<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

 namespace Callcocam\Tenant\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Tenant extends AbstractTenantModel
{
    use HasFactory, Notifiable;

    
  
}
