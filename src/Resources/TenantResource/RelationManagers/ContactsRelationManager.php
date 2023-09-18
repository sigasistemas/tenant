<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

 namespace Callcocam\Tenant\Resources\TenantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    protected static ?string $title = 'Contatos';

    protected static ?string $icon =  'fas-address-book';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('name')
                    ->options([
                        'phone' => 'Telefone Fixo',
                        'fax' => 'Fone Fax',
                        'cell' => 'Celular',
                        'whatsapp' => 'Whatsapp',
                        'email' => 'E-mail',
                        'site' => 'Site',
                    ])
                    ->required()
                    ->label('Tipo do Contato')
                    ->reactive(),
                PhoneNumber::make('description')
                    ->label('Contato')
                    ->required()
                    ->format(function (Get $get) {
                        $type = $get('name');
                        switch ($type):
                            case 'phone':
                            case 'fax':
                                return '(99) 9999-9999';
                                break;
                            case 'cell':
                            case 'whatsapp':
                                return '(99) 99999-9999';
                                break;
                            default:
                                return null;
                                break;
                        endswitch;
                    })

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
        ->modelLabel('Contato')
        ->pluralModelLabel('Contatos')
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tipo do Contato'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Contato'),
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
