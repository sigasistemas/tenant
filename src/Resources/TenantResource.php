<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Tenant\Resources;

use Callcocam\Tenant\Models\Tenant;
use Callcocam\Profile\Resources\RelationManagers;
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
use Illuminate\Support\Str;

class TenantResource extends Resource
{
    use HasStatusColumn, HasEditorColumn, HasDatesFormForTableColums;

    protected static ?string $model = Tenant::class;

    protected static ?string $navigationGroup = "Acl";

    protected static ?string $modelLabel = "Locatário";

    protected static ?string $pluralModelLabel = "Locatários";

    protected static ?string $navigationIcon = 'fas-building-user';

    protected static ?int $navigationSort = 1;

    public static function getModel(): string
    {
        return config('tenant.models.tenant', Tenant::class);
    }

    public static function getNavigationGroup(): ?string
    {
        return config('acl.navigation.tenant.group', static::$navigationGroup);
    }

    public static function getNavigationIcon(): ?string
    {
        return config('acl.navigation.tenant.icon', static::$navigationIcon);
    }

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? config('acl.navigation.tenant.label', Str::headline(static::getPluralModelLabel()));
    }


    public static function getNavigationBadge(): ?string
    {
        return config('acl.navigation.tenant.badge', null);
    }

    /**
     * @return string | array{50: string, 100: string, 200: string, 300: string, 400: string, 500: string, 600: string, 700: string, 800: string, 900: string, 950: string} | null
     */
    public static function getNavigationBadgeColor(): string | array | null
    {
        return config('acl.navigation.tenant.badge_color', null);
    }

    public static function getNavigationSort(): ?int
    {
        return config('acl.navigation.tenant.sort', static::$navigationSort);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(function (){
                $contents = [];

                if(config('tenant.tenant.fields.type.visible', true)){
                    $contents[] =  Forms\Components\Select::make('type')
                        ->label(__('tenant::tenant.forms.type.label'))
                        ->placeholder(__('tenant::tenant.forms.type.placeholder'))
                        ->options([
                            'tenant' => 'Tenant',
                            'landlord' => 'Landlord',
                        ])
                        ->columnSpan([
                            'md' => config('tenant.tenant.prefix.span', 3),
                        ])
                        ->required();
                }
                if(config('tenant.tenant.fields.name.visible', true)){
                    $contents[] = Forms\Components\TextInput::make('name')
                        ->label(__('tenant::tenant.forms.name.label'))
                        ->placeholder(__('tenant::tenant.forms.name.placeholder'))
                        ->columnSpan([
                            'md' => config('tenant.tenant.prefix.span', 9),
                        ])
                        ->required()
                        ->maxLength(255);
                }

                if(config('tenant.tenant.fields.domain.visible', true)){
                    $contents[] = Forms\Components\TextInput::make('domain')
                        ->label(__('tenant::tenant.forms.domain.label'))
                        ->placeholder(__('tenant::tenant.forms.domain.placeholder'))
                        ->columnSpan([
                            'md' => config('tenant.tenant.prefix.span', 6),
                        ])
                        ->required()
                        ->maxLength(255);
                }

                if(config('tenant.tenant.fields.provider.visible', true)){
                    $contents[] = Forms\Components\TextInput::make('provider')
                        ->label(__('tenant::tenant.forms.provider.label'))
                        ->placeholder(__('tenant::tenant.forms.provider.placeholder'))
                        ->columnSpan([
                            'md' => config('tenant.tenant.prefix.span', 3),
                        ])
                        ->helperText(__('tenant::tenant.forms.provider.helperText'))
                        ->maxLength(255);
                }

                if(config('tenant.tenant.fields.prefix.visible', true)){
                    $contents[] = Forms\Components\TextInput::make('prefix')
                        ->label(__('tenant::tenant.forms.prefix.label'))
                        ->placeholder(__('tenant::tenant.forms.prefix.placeholder'))
                        ->columnSpan([
                            'md' => config('tenant.tenant.prefix.span', 3),
                        ])
                        ->helperText(__('tenant::tenant.forms.prefix.helperText'))
                        ->maxLength(255);
                }
                $contents[] =  static::getStatusFormRadioField();
                $contents[] = static::getEditorFormField();

                return $contents;

            })->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modelLabel(__('tenant::tenant.modelLabel'))
            ->pluralModelLabel(__('tenant::tenant.pluralModelLabel'))
            ->columns(function (){
                $contents = [];
                if(config('tenant.tenant.fields.type.visible', true)) {
                    $contents[] = Tables\Columns\TextColumn::make('type')
                        ->label(__('tenant::tenant.forms.type.label'))
                        ->searchable();
                }

                if(config('tenant.tenant.fields.name.visible', true)) {
                    $contents[] = Tables\Columns\TextColumn::make('name')
                        ->label(__('tenant::tenant.forms.name.label'))
                        ->searchable();
                }
                if(config('tenant.tenant.fields.domain.visible', true)) {
                    $contents[] = Tables\Columns\TextColumn::make('domain')
                        ->label(__('tenant::tenant.forms.domain.label'))
                        ->searchable();
                }
                $contents[] = static::getStatusTableIconColumn();
                $contents[] = [...static::getFieldDatesFormForTable()];
                return $contents;
            })
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(
                    config('tenant.actions.tenant.bulk', [
                        Tables\Actions\DeleteBulkAction::make(),
                        Tables\Actions\ForceDeleteBulkAction::make(),
                        Tables\Actions\RestoreBulkAction::make(),
                    ])
                ),
            ])
            ->emptyStateActions(config('tenant.actions.tenant.emptyState', [
                Tables\Actions\CreateAction::make(),
            ]));
    }

    public static function getRelations(): array
    {

        $relations = [];

        if (config('tenant.relations.tenant.address',  true)) {
            $relations[] = RelationManagers\AddressesRelationManager::class;
        }
        if (config('tenant.relations.tenant.contact',  true)) {
            $relations[] = RelationManagers\ContactsRelationManager::class;
        }
        if (config('tenant.relations.tenant.document',  true)) {
            $relations[] = RelationManagers\DocumentsRelationManager::class;
        }
        if (config('tenant.relations.tenant.social',  true)) {
            $relations[] = RelationManagers\SocialsRelationManager::class;
        }

        return array_merge($relations, config('tenant.relations.tenant', [])) ;
    }

    public static function getPages(): array
    {
        return config('tenant.pages.tenant', [
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes(config('tenant.scopes.tenant', [
                SoftDeletingScope::class,
            ]))->when(config('tenant.query.tenant', []), function ($query, $callback) {
                return $callback($query);
            });
    }
}
