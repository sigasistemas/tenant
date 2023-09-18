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
use Leandrocfe\FilamentPtbrFormFields\Document;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documentos';

    protected static ?string $icon =  'fas-id-badge';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name')
                    ->options([
                        'CPF' => 'CPF',
                        'CNPJ' => 'CNPJ',
                        'RG' => 'RG',
                        'IE' => 'IE',
                        'IM' => 'IM',
                        'CNH' => 'CNH',
                        'passport' => 'Passaporte',
                        'title' => 'Titulo de Eleitor',
                        'reservist' => 'Reservista',
                        'birth' => 'Certidão de Nascimento',
                        'marriage' => 'Certidão de Casamento',
                        'divorce' => 'Certidão de Divórcio',
                        'death' => 'Certidão de Óbito',
                        'other' => 'Outros',
                    ])->reactive()
                    ->label('Tipo do Documento')
                    ->required(),
                Document::make('description')
                    ->mask(function (Get $get ) {
                        $type = strtolower($get('name'));
                        switch ($type):
                            case 'cpf':
                                return '999.999.999-99';
                                break;
                            case 'cnpj':
                                return '99.999.999/9999-99';
                                break;
                            case 'rg':
                                return '99.999.999-9';
                                break;
                            default:
                                return null;
                                break;
                        endswitch;
                    })
                    ->label('Valor do Documento')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel('Documento')
            ->pluralModelLabel('Documentos')
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
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
