<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Tenant\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasGlobalSearchBase
{

    /**
     * Attributes que serão pesquisados globalmente
     * @return array
     */
    public static function getGloballySearchableAttributes(): array
    {
        return  static::getSearchAttributes();
    }

    /**
     * Attributes basicos que serão pesquisados globalmente
     */
    public static function getSearchAttributes(): array
    {
        return ['name', 'created_at', 'updated_at', 'status', 'description'];
    }

    /**
     * Retorna o titulo do resultado da pesquisa global
     * @param Model $record
     * @return string
     */
    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    /**
     * Retorna o subtitulo do resultado da pesquisa global
     * @param Model $record
     * @return string
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Author' => $record->user ? $record->user->name : 'N/A',
        ];
    }
}
