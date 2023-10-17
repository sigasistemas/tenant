<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\Tenant\Resources\TenantResource\Pages;

use Callcocam\Tenant\Resources\TenantResource;
use Callcocam\Tenant\Traits\HasDatesFormForTableColums;
use Callcocam\Tenant\Traits\HasEditorColumn;
use Callcocam\Tenant\Traits\HasStatusColumn;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Filament\Forms\Form;


class CreateTenant extends CreateRecord
{
    use HasStatusColumn, HasEditorColumn, HasDatesFormForTableColums;
    
    protected static string $resource = TenantResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema(function () {
                $contents = [];

                if (config('tenant.tenant.fields.type.visible', true)) {
                    $contents[] =  Forms\Components\Select::make('type')
                        ->label(__('tenant::tenant.forms.type.label'))
                        ->placeholder(__('tenant::tenant.forms.type.placeholder'))
                        ->options(config('tenant.tenant.type.options', [
                            'tenant' => 'Tenant',
                            'landlord' => 'Landlord',
                        ]))
                        ->columnSpan([
                            'md' => config('tenant.tenant.type.span', 2),
                        ])
                        ->required(config('tenant.tenant.type.required', false));
                }
                if (config('tenant.tenant.fields.name.visible', true)) {
                    $contents[] = Forms\Components\TextInput::make('name')
                        ->label(__('tenant::tenant.forms.name.label'))
                        ->placeholder(__('tenant::tenant.forms.name.placeholder'))
                        ->columnSpan([
                            'md' => config('tenant.tenant.name.span', 6),
                        ])
                        ->required(config('tenant.tenant.name.required', false))
                        ->maxLength(config('tenant.tenant.name.maxLength', 255));
                }
                if (config('tenant.tenant.fields.email.visible', true)) {
                    $contents[] = Forms\Components\TextInput::make('email')
                        ->label(__('tenant::tenant.forms.email.label'))
                        ->placeholder(__('tenant::tenant.forms.email.placeholder'))
                        ->columnSpan([
                            'md' => config('tenant.tenant.email.span', 4),
                        ])
                        ->required(config('tenant.tenant.email.required', false))
                        ->maxLength(config('tenant.tenant.email.maxLength', 255));
                }

                if (config('tenant.tenant.fields.domain.visible', true)) {
                    $contents[] = Forms\Components\TextInput::make('domain')
                        ->label(__('tenant::tenant.forms.domain.label'))
                        ->placeholder(__('tenant::tenant.forms.domain.placeholder'))
                        ->columnSpan([
                            'md' => config('tenant.tenant.domain.span', 6),
                        ])
                        ->required(config('tenant.tenant.domain.required', false))
                        ->maxLength(config('tenant.tenant.domain.maxLength', 255));
                }

                if (config('tenant.tenant.fields.provider.visible', true)) {
                    $contents[] = Forms\Components\TextInput::make('provider')
                        ->label(__('tenant::tenant.forms.provider.label'))
                        ->placeholder(__('tenant::tenant.forms.provider.placeholder'))
                        ->columnSpan([
                            'md' => config('tenant.tenant.provider.span', 3),
                        ])
                        ->required(config('tenant.tenant.provider.required', false))
                        ->helperText(__('tenant::tenant.forms.provider.helperText'))
                        ->maxLength(config('tenant.tenant.provider.maxLength', 255));
                }

                if (config('tenant.tenant.fields.prefix.visible', true)) {
                    $contents[] = Forms\Components\TextInput::make('prefix')
                        ->label(__('tenant::tenant.forms.prefix.label'))
                        ->placeholder(__('tenant::tenant.forms.prefix.placeholder'))
                        ->columnSpan([
                            'md' => config('tenant.tenant.prefix.span', 3),
                        ])
                        ->required(config('tenant.tenant.prefix.required', false))
                        ->helperText(__('tenant::tenant.forms.prefix.helperText'))
                        ->maxLength(config('tenant.tenant.prefix.maxLength', 255));
                } 

                $contents[] =  static::getStatusFormRadioField();
                $contents[] = static::getEditorFormField();

                return $contents;
            })->columns(12);
    }
}
