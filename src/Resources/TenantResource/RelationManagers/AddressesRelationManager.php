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
use Filament\Tables;
use Filament\Tables\Table; 

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $title = 'Endereços';

    protected static ?string $icon =  'fas-map-location-dot';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome do Endereço')
                    ->columnSpan([
                        'md' => 5,
                    ])
                    ->required()
                    ->maxLength(255),
                \Leandrocfe\FilamentPtbrFormFields\Cep::make('zip')
                    ->label('CEP')
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
                        'md' => 3,
                    ])
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('street')
                    ->label('Rua / Avenida / Logradouro')
                    ->columnSpan([
                        'md' => 4,
                    ])
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('number')
                    ->label('Número')
                    ->columnSpan([
                        'md' => 4,
                    ])
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('complement')
                    ->label('Complemento')
                    ->columnSpan([
                        'md' => 8,
                    ])
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('district')
                    ->label('Bairro')
                    ->columnSpan([
                        'md' => 4,
                    ])
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->label('Cidade')
                    ->columnSpan([
                        'md' => 5,
                    ])
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('state')
                    ->options([
                        'AC' => 'Acre',
                        'AL' => 'Alagoas',
                        'AP' => 'Amapá',
                        'AM' => 'Amazonas',
                        'BA' => 'Bahia',
                        'CE' => 'Ceará',
                        'DF' => 'Distrito Federal',
                        'ES' => 'Espírito Santo',
                        'GO' => 'Goiás',
                        'MA' => 'Maranhão',
                        'MT' => 'Mato Grosso',
                        'MS' => 'Mato Grosso do Sul',
                        'MG' => 'Minas Gerais',
                        'PA' => 'Pará',
                        'PB' => 'Paraíba',
                        'PR' => 'Paraná',
                        'PE' => 'Pernambuco',
                        'PI' => 'Piauí',
                        'RJ' => 'Rio de Janeiro',
                        'RN' => 'Rio Grande do Norte',
                        'RS' => 'Rio Grande do Sul',
                        'RO' => 'Rondônia',
                        'RR' => 'Roraima',
                        'SC' => 'Santa Catarina',
                        'SP' => 'São Paulo',
                        'SE' => 'Sergipe',
                        'TO' => 'Tocantins',
                        'EX' => 'Estrangeiro',
                    ])
                    ->label('Estado')
                    ->columnSpan([
                        'md' => 3,
                    ])
                    ->required(),
                Forms\Components\TextInput::make('country')
                    ->label('País')
                    ->default('Brasil')
                    ->columnSpan([
                        'md' => 4,
                    ])
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->label('Latitude')
                    ->columnSpan([
                        'md' => 4,
                    ])
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('longitude')
                    ->label('Longitude')
                    ->columnSpan([
                        'md' => 4,
                    ])
                    ->required()
                    ->maxLength(255),
                Forms\Components\Radio::make('status')
                    ->label('Status')
                    ->inline()
                    ->options([
                        'draft' => 'Rascunho',
                        'published' => 'Publicado',
                    ])
                    ->columnSpanFull()
                    ->required(),
            ])->columns(12);
    }

    public function table(Table $table): Table
    {
        return $table 
           ->modelLabel('Endereços')
           ->pluralModelLabel('Endereços')
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome do Endereço'),
                Tables\Columns\TextColumn::make('zip')
                    ->label('CEP'),
                Tables\Columns\TextColumn::make('street')
                    ->label('Rua / Avenida / Logradouro'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
