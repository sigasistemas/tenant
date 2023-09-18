<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Tenant\Resources;

use App\Models\Callcocam\Tenant;
use  Callcocam\Tenant\Resources\TenantResource\RelationManagers; 
use Callcocam\Tenant\Resources\TenantResource\Pages;
use Callcocam\Tenant\Traits\HasDatesFormForTableColums;
use Callcocam\Tenant\Traits\HasEditorColumn;
use Callcocam\Tenant\Traits\HasStatusColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TenantResource extends Resource
{
    use HasStatusColumn, HasEditorColumn, HasDatesFormForTableColums;

    protected static ?string $model = Tenant::class;

    protected static ?string $navigationGroup = "Acl";
    
    protected static ?string $modelLabel = "Locatário";

    protected static ?string $pluralModelLabel = "Locatários";

    protected static ?string $navigationIcon = 'fas-building-user';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Tipo de locatário')
                    ->options([
                        'tenant' => 'Tenant',
                        'landlord' => 'Landlord',
                    ])
                    ->columnSpan([
                        'md' => 3,
                    ])
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nome do locatário')
                    ->columnSpan([
                        'md' => 9,
                    ])
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('domain')
                    ->label('Domínio do locatário')
                    ->columnSpan([
                        'md' => 6,
                    ])
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('provider')
                    ->label('Provedor do locatário')
                    ->columnSpan([
                        'md' => 3,
                    ])
                    ->helperText('Geralmente é o nome da conexão com o banco de dados')
                    ->maxLength(255),
                Forms\Components\TextInput::make('prefix')
                    ->label('Prefixo do locatário')
                    ->columnSpan([
                        'md' => 3,
                    ])
                    ->helperText('Geralmente é o path de acesso ao locatário ex: /admin')
                    ->maxLength(255),
                static::getStatusFormRadioField(),
                static::getEditorFormField()
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->modelLabel('Locatário')
        ->pluralModelLabel('Locatários')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo de locatário')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome do locatário')
                    ->searchable(),
                Tables\Columns\TextColumn::make('domain')
                    ->label('Domínio do locatário')
                    ->searchable(),
                static::getStatusTableIconColumn(),
                ...static::getFieldDatesFormForTable()
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AddressesRelationManager::class,
            RelationManagers\ContactsRelationManager::class,
            RelationManagers\DocumentsRelationManager::class,
            RelationManagers\SocialsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])->where('id', get_tenant_id());
    }
}
