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
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Leandrocfe\FilamentPtbrFormFields\Document;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documentos';

    protected static ?string $icon =  'fas-id-badge';

    public static function getIcon(Model $ownerRecord, string $pageClass): ?string
    {
        return config('tenant.resources.documents.icon', static::$icon);
    }

    public static function getIconPosition(Model $ownerRecord, string $pageClass): IconPosition
    {
        return config('tenant.resources.documents.iconPosition', static::$iconPosition);
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return config('tenant.resources.documents.badge', static::$badge);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return  config('tenant.resources.documents.title',   parent::getTitle($ownerRecord, $pageClass));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name')
                    ->options(config('tenant.resources.documents.options', []))->reactive()
                    ->label(__('tenant::tenant.forms.document.name.label'))
                    ->placeholder(__('tenant::tenant.forms.document.name.placeholder'))
                    ->required(config('tenant.resources.documents.required', true))
                    ->hidden(config('tenant.resources.documents.hidden', false)),
                Document::make('description')
                    ->mask(function (Get $get) {
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
                    ->label(__('tenant::tenant.forms.document.description.label'))
                    ->placeholder(__('tenant::tenant.forms.document.description.placeholder'))
                    ->required(config('tenant.resources.documents.required', true))
                    ->hidden(config('tenant.resources.documents.hidden', false))
                    ->maxLength(config('tenant.resources.documents.maxlength', 255)),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel(__('tenant::tenant.forms.document.modelLabel'))
            ->pluralModelLabel(__('tenant::tenant.forms.document.pluralModelLabel'))
            ->recordTitleAttribute(config('tenant.resources.documents.title', 'name'))
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters(config('tenant.resources.documents.filters', []))
            ->headerActions(config(
                'tenant.resources.documents.header_actions',
                [
                    Tables\Actions\CreateAction::make(),
                ]
            ))
            ->actions(config(
                'tenant.resources.documents.actions',
                [
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]
            ))
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(config(
                    'tenant.resources.documents.bulk_actions',
                    [
                        Tables\Actions\DeleteBulkAction::make(),
                    ]
                )),
            ])
            ->emptyStateActions(config(
                'tenant.resources.documents.emptyState',
                [
                    Tables\Actions\CreateAction::make(),
                ]
            ));
    }
}
