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

class SocialsRelationManager extends RelationManager
{
    protected static string $relationship = 'socials';

    protected static ?string $title = 'Redes Sociais';

    protected static ?string $icon =  'fas-share-alt';


    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('name')
                    ->options([
                        'facebook' => 'Facebook',
                        'twitter' => 'Twitter',
                        'instagram' => 'Instagram',
                        'linkedin' => 'Linkedin',
                        'youtube' => 'Youtube',
                        'tiktok' => 'Tiktok',
                        'telegram' => 'Telegram',
                        'pinterest' => 'Pinterest',
                        'flickr' => 'Flickr',
                        'snapchat' => 'Snapchat',
                        'reddit' => 'Reddit',
                        'discord' => 'Discord',
                        'spotify' => 'Spotify',
                        'github' => 'Github',
                        'blogger' => 'Blogger',
                        'trello' => 'Trello',
                        'slack' => 'Slack',
                    ])
                    ->required()
                    ->reactive()
                    ->label('Tipo do Contato'),
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
                    ->label('Contato')
                    ->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel('Redes Social')
            ->pluralModelLabel('Redes Sociais')
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
