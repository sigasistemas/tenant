<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\Tenant\Resources\TenantResource\Pages;

use Callcocam\Tenant\Resources\TenantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Forms\Form;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema(function (){
                $contents = [];

                if(config('tenant.tenant.fields.type.visible', true)){
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
                if(config('tenant.tenant.fields.name.visible', true)){
                    $contents[] = Forms\Components\TextInput::make('name')
                        ->label(__('tenant::tenant.forms.name.label'))
                        ->placeholder(__('tenant::tenant.forms.name.placeholder'))
                        ->columnSpan([
                            'md' => config('tenant.tenant.name.span', 6),
                        ])
                        ->required(config('tenant.tenant.name.required', false))
                        ->maxLength(config('tenant.tenant.name.maxLength', 255));
                }
                if(config('tenant.tenant.fields.email.visible', true)){
                    $contents[] = Forms\Components\TextInput::make('email')
                        ->label(__('tenant::tenant.forms.email.label'))
                        ->placeholder(__('tenant::tenant.forms.email.placeholder'))
                        ->columnSpan([
                            'md' => config('tenant.tenant.email.span', 4),
                        ])
                        ->required(config('tenant.tenant.email.required', false))
                        ->maxLength(config('tenant.tenant.email.maxLength', 255));
                }

                if(config('tenant.tenant.fields.domain.visible', true)){
                    $contents[] = Forms\Components\TextInput::make('domain')
                        ->label(__('tenant::tenant.forms.domain.label'))
                        ->placeholder(__('tenant::tenant.forms.domain.placeholder'))
                        ->columnSpan([
                            'md' => config('tenant.tenant.domain.span', 6),
                        ])
                        ->required(config('tenant.tenant.domain.required', false))
                        ->maxLength(config('tenant.tenant.domain.maxLength', 255));
                }

                if(config('tenant.tenant.fields.provider.visible', true)){
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

                if(config('tenant.tenant.fields.prefix.visible', true)){
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
                if($extras = config('tenant.tenant.fields.extra', [])):
                    $contents =  static::getExtraFieldsSchemaForm($extras, $contents );
                endif;


                $contents[] =  static::getStatusFormRadioField();
                $contents[] = static::getEditorFormField();

                return $contents;

            })->columns(12);
    }

    protected static function getExtraFieldsSchemaForm($record,  $contents=[]) {

        if(class_exists('App\Core\Helpers\TenantHellper')){
            if(method_exists(app('App\Core\Helpers\TenantHelper'), 'getExtrafileds')){
                $extras = app('App\Core\Helpers\TenantHelper')->getExtrafileds($record);
                foreach ($extras as $extra) {
                    $content =  Forms\Components\Section::make(data_get($extra, 'name'))
                        ->description(data_get($extra, 'description'))
                        ->collapsed()
                        ->schema(function () use ($extra){
                            $contents_ = [];
                            if($fields = data_get($extra, 'fields')){
                                foreach ($fields as $class => $field) {
                                    $fieldForm = app($class,[
                                        'name'=> data_get($field,'name')
                                    ]);
                                    if($relationship = data_get($field, 'relationship')):
                                        $fieldForm->relationship($relationship);
                                    endif;
                                    if($options = data_get($extra, 'options')):
                                        $fieldForm->options(function () use($options){
                                            if(is_string($options)){
                                                return app($options)->query()->pluck('name','id')->toArray();
                                            }
                                            if(is_array($options)){
                                                return $options;
                                            }
                                            return null;
                                        });
                                    endif;
                                    $contents_[] = $fieldForm;
                                }
                            }
                            return $contents_;
                        });
                    if(data_get($extra, 'relationship')){
                        $content->relationship(data_get($extra, 'relationship'));
                    }
                    $contents[] = $content;
                }
            }
        }

        return  $contents;
    }
}
