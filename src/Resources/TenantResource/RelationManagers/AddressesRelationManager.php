<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Tenant\Resources\TenantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $title = 'Endereços';

    protected static ?string $icon =  'fas-map-location-dot';


    public static function getIcon(Model $ownerRecord, string $pageClass): ?string
    {
        return config('tenant.resources.address.icon', static::$icon);
    }

    public static function getIconPosition(Model $ownerRecord, string $pageClass): IconPosition
    {
        return config('tenant.resources.address.iconPosition', static::$iconPosition);
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return config('tenant.resources.address.badge', static::$badge);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return  config('tenant.resources.address.title',   parent::getTitle($ownerRecord, $pageClass));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('tenant::tenant.forms.address.name.label'))
                    ->placeholder(__('tenant::tenant.forms.address.name.placeholder'))
                    ->columnSpan([
                        'md' => config('tenant.resources.address.name.columnSpan', 5),
                    ])
                    ->hidden(config('tenant.resources.address.name.hidden', false))
                    ->required(config('tenant.resources.address.name.required', true))
                    ->maxLength(config('tenant.resources.address.name.maxLength', 255)),
                \Leandrocfe\FilamentPtbrFormFields\Cep::make('zip')
                    ->label(__('tenant::tenant.forms.address.zip.label'))
                    ->placeholder(__('tenant::tenant.forms.address.zip.placeholder'))
                    ->hidden(config('tenant.resources.address.zip.hidden', false))
                    ->viaCep(
                        mode: 'suffix', // Determines whether the action should be appended to (suffix) or prepended to (prefix) the cep field, or not included at all (none).
                        errorMessage: 'CEP inválido.', // Error message to display if the CEP is invalid.

                        /**
                         * Other form fields that can be filled by ViaCep.
                         * The key is the name of the Filament input, and the value is the ViaCep attribute that corresponds to it.
                         * More information: https://viacep.com.br/
                         */
                        setFields: [
                            'street' => 'logradouro',
                            'number' => 'numero',
                            'complement' => 'complemento',
                            'district' => 'bairro',
                            'city' => 'localidade',
                            'state' => 'uf'
                        ]
                    )
                    ->columnSpan([
                        'md' => config('tenant.resources.address.zip.columnSpan', 3),
                    ])
                    ->required(config('tenant.resources.address.zip.required', true))
                    ->maxLength(config('tenant.resources.address.zip.maxLength', 255)),
                Forms\Components\TextInput::make('street')
                    ->label(__('tenant::tenant.forms.address.street.label'))
                    ->placeholder(__('tenant::tenant.forms.address.street.placeholder'))
                    ->hidden(config('tenant.resources.address.street.hidden', false))
                    ->columnSpan([
                        'md' => config('tenant.resources.address.street.columnSpan', 4),
                    ])
                    ->required(config('tenant.resources.address.street.required', true))
                    ->maxLength(config('tenant.resources.address.street.maxLength', 255)),
                Forms\Components\TextInput::make('number')
                    ->label(__('tenant::tenant.forms.address.number.label'))
                    ->placeholder(__('tenant::tenant.forms.address.number.placeholder'))
                    ->columnSpan([
                        'md' => config('tenant.resources.address.number.columnSpan', 4),
                    ])
                    ->required(config('tenant.resources.address.number.required', true))
                    ->maxLength(config('tenant.resources.address.number.maxLength', 255)),
                Forms\Components\TextInput::make('complement')
                    ->label(__('tenant::tenant.forms.address.complement.label'))
                    ->placeholder(__('tenant::tenant.forms.address.complement.placeholder'))
                    ->columnSpan([
                        'md' => config('tenant.resources.address.complement.columnSpan', 8),
                    ])
                    ->required(config('tenant.resources.address.complement.required', true))
                    ->maxLength(config('tenant.resources.address.complement.maxLength', 255)),
                Forms\Components\TextInput::make('district')
                    ->label(__('tenant::tenant.forms.address.district.label'))
                    ->placeholder(__('tenant::tenant.forms.address.district.placeholder'))
                    ->columnSpan([
                        'md' => config('tenant.resources.address.district.columnSpan', 4),
                    ])
                    ->required(config('tenant.resources.address.district.required', true))
                    ->maxLength(config('tenant.resources.address.district.maxLength', 255)),
                Forms\Components\TextInput::make('city')
                    ->label(__('tenant::tenant.forms.address.city.label'))
                    ->placeholder(__('tenant::tenant.forms.address.city.placeholder'))
                    ->columnSpan([
                        'md' => config('tenant.resources.address.city.columnSpan', 5),
                    ])
                    ->required(config('tenant.resources.address.city.required', true))
                    ->maxLength(config('tenant.resources.address.city.maxLength', 255)),
                Forms\Components\Select::make('state')
                    ->options(config('tenant.resources.address.options.state', []))
                    ->label(__('tenant::tenant.forms.address.state.label'))
                    ->placeholder(__('tenant::tenant.forms.address.state.placeholder'))
                    ->columnSpan([
                        'md' => config('tenant.resources.address.state.columnSpan', 3)
                    ])
                    ->required(),
                Forms\Components\TextInput::make('country')
                    ->label(__('tenant::tenant.forms.address.country.label'))
                    ->placeholder(__('tenant::tenant.forms.address.country.placeholder'))
                    ->default('Brasil')
                    ->columnSpan([
                        'md' => config('tenant.resources.address.country.columnSpan', 4),
                    ])
                    ->required(config('tenant.resources.address.country.required', true))
                    ->maxLength(config('tenant.resources.address.country.maxLength', 255)),
                Forms\Components\TextInput::make('latitude')
                    ->label(__('tenant::tenant.forms.address.latitude.label'))
                    ->placeholder(__('tenant::tenant.forms.address.latitude.placeholder'))
                    ->columnSpan([
                        'md' => config('tenant.resources.address.latitude.columnSpan', 4)
                    ])
                    ->required()
                    ->maxLength(config('tenant.resources.address.latitude.maxLength', 255)),
                Forms\Components\TextInput::make('longitude')
                    ->label(__('tenant::tenant.forms.address.longitude.label'))
                    ->placeholder(__('tenant::tenant.forms.address.longitude.placeholder'))
                    ->columnSpan([
                        'md' => config('tenant.resources.address.longitude.columnSpan', 4)
                    ])
                    ->required(config('tenant.resources.address.longitude.required', true))
                    ->maxLength(config('tenant.resources.address.longitude.maxLength', 255)),
                Forms\Components\Radio::make('status')
                    ->label(__('tenant::tenant.forms.address.status.label'))
                    ->inline()
                    ->options([
                        'draft' => 'Rascunho',
                        'published' => 'Publicado',
                    ])
                    ->columnSpanFull()
                    ->required(config('tenant.resources.address.status.required', true)),
            ])->columns(12);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel(__('tenant::tenant.forms.address.modelLabel'))
            ->pluralModelLabel(__('tenant::tenant.forms.address.pluralModelLabel'))
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('tenant::tenant.forms.address.name.label'))
                    ->placeholder(__('tenant::tenant.forms.address.name.placeholder'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('zip')
                    ->label(__('tenant::tenant.forms.address.zip.label'))
                    ->placeholder(__('tenant::tenant.forms.address.zip.placeholder'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('street')
                    ->label(__('tenant::tenant.forms.address.street.label'))
                    ->placeholder(__('tenant::tenant.forms.address.street.placeholder'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions(
                config('tenant.resources.address.header_actions', [
                    Tables\Actions\CreateAction::make(),
                ])
            )
            ->actions(
                config('tenant.resources.address.actions', [
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(config(
                    'tenant.resources.address.bulk_actions',
                    [
                        Tables\Actions\DeleteBulkAction::make(),
                    ]
                )),
            ])
            ->emptyStateActions(config(
                'tenant.resources.address.emptyState',
                [
                    Tables\Actions\CreateAction::make(),
                ]
            ));
    }
}
