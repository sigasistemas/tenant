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
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    protected static ?string $title = 'Contatos';

    protected static ?string $icon =  'fas-address-book';

    public static function getIcon(Model $ownerRecord, string $pageClass): ?string
    {
        return config('tenant.resources.contacts.icon', static::$icon);
    }

    public static function getIconPosition(Model $ownerRecord, string $pageClass): IconPosition
    {
        return config('tenant.resources.contacts.iconPosition', static::$iconPosition);
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return config('tenant.resources.contacts.badge', static::$badge);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return  config('tenant.resources.contacts.title',   parent::getTitle($ownerRecord, $pageClass));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('name')
                    ->options(config('tenant.resources.contacts.options', []))
                    ->required(config('tenant.resources.contacts.required', true))
                    ->hidden(config('tenant.resources.contacts.hidden', false))
                    ->label(__('tenant::tenant.forms.contact.name.label'))
                    ->placeholder(__('tenant::tenant.forms.contact.name.placeholder'))
                    ->reactive(),
                PhoneNumber::make('description')
                    ->label(__('tenant::tenant.forms.contact.description.label'))
                    ->placeholder(__('tenant::tenant.forms.contact.description.placeholder'))
                    ->required(config('tenant.resources.contacts.required', true))
                    ->hidden(config('tenant.resources.contacts.hidden', false))
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
            ->modelLabel(__('tenant::tenant.forms.contact.modelLabel'))
            ->pluralModelLabel(__('tenant::tenant.forms.contact.pluralModelLabel'))
            ->recordTitleAttribute(config('tenant.resources.contacts.title', 'name'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('tenant::tenant.forms.contact.name.label')),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('tenant::tenant.forms.contact.description.label')),
            ])
            ->filters([
                //
            ])
            ->headerActions(config('tenant.resources.contacts.header_actions', [
                Tables\Actions\CreateAction::make(),
            ]))
            ->actions(config('tenant.resources.contacts.actions', [
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]))
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(config(
                    'tenant.resources.contacts.bulk_actions',
                    [
                        Tables\Actions\DeleteBulkAction::make(),
                    ]
                )),
            ])
            ->emptyStateActions(config('tenant.resources.contacts.emptyState_actions', [
                Tables\Actions\CreateAction::make(),
            ]));
    }
}
