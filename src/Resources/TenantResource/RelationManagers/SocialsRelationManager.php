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

class SocialsRelationManager extends RelationManager
{
    protected static string $relationship = 'socials';

    protected static ?string $title = 'Redes Sociais';

    protected static ?string $icon =  'fas-share-alt';

    public static function getIcon(Model $ownerRecord, string $pageClass): ?string
    {
        return config('tenant.resources.social.icon', static::$icon);
    }

    public static function getIconPosition(Model $ownerRecord, string $pageClass): IconPosition
    {
        return config('tenant.resources.social.iconPosition', static::$iconPosition);
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return config('tenant.resources.social.badge', static::$badge);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return  config('tenant.resources.social.title',   parent::getTitle($ownerRecord, $pageClass));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('name')
                    ->options(config('tenant.resources.social.options', []))
                    ->required(config('tenant.resources.social.required', true))
                    ->hidden(config('tenant.resources.social.hidden', false))
                    ->reactive()
                    ->label(__('tenant::tenant.forms.social.name.label'))
                    ->placeholder(__('tenant::tenant.forms.social.name.placeholder')),
                Forms\Components\TextInput::make('description')
                    ->suffixIcon(function (Get $get) {
                        $type = $get('name');
                        switch ($type):
                            case 'facebook':
                                return 'fab-facebook';
                                break;
                            case 'twitter':
                                return 'fab-twitter';
                                break;
                            case 'instagram':
                                return 'fab-instagram';
                                break;
                            case 'linkedin':
                                return 'fab-linkedin';
                                break;
                            case 'youtube':
                                return 'fab-youtube';
                                break;
                            case 'tiktok':
                                return 'fab-tiktok';
                                break;
                            case 'telegram':
                                return 'fab-telegram';
                                break;
                            case 'pinterest':
                                return 'fab-pinterest';
                                break;
                            case 'flickr':
                                return 'fab-flickr';
                                break;
                            case 'snapchat':
                                return 'fab-snapchat';
                                break;
                            case 'reddit':
                                return 'fab-reddit';
                                break;
                            case 'discord':
                                return 'fab-discord';
                                break;
                            case 'spotify':
                                return 'fab-spotify';
                                break;
                            case 'github':
                                return 'fab-github';
                                break;
                            case 'blogger':
                                return 'fab-blogger';
                                break;
                            case 'trello':
                                return 'fab-trello';
                                break;
                            case 'slack':
                                return 'fab-slack';
                                break;
                            default:
                                return null;
                                break;
                        endswitch;
                    })
                    ->label(__('tenant::tenant.forms.social.description.label'))
                    ->placeholder(__('tenant::tenant.forms.social.description.placeholder'))
                    ->required(config('tenant.resources.social.required', true))
                    ->hidden(config('tenant.resources.social.hidden', false))

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel(__('tenant::tenant.forms.social.modelLabel'))
            ->pluralModelLabel(__('tenant::tenant.forms.social.pluralModelLabel'))
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('tenant::tenant.forms.social.name.label'))
                    ->searchable(),
            ])
            ->filters(config('tenant.resources.social.filters', [
                //
            ]))
            ->headerActions(
                config('tenant.resources.social.header_actions', [
                    Tables\Actions\CreateAction::make(),
                ])
            )
            ->actions(
                config('tenant.resources.social.actions', [
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(config('tenant.resources.social.bulk_actions', [
                    Tables\Actions\DeleteBulkAction::make(),
                ])),
            ])
            ->emptyStateActions(config('tenant.resources.social.emptyState', [
                Tables\Actions\CreateAction::make(),
            ]));
    }
}
