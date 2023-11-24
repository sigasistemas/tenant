<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
return [
    /**
     * Habilite o recurso de locatário
     */
    'enabled' => false,
    /**
     * O nome da coluna no banco de dados que será usada para identificar o locatário
     */
    'default_tenant_columns' => ['tenant_id'],
    /*
    |--------------------------------------------------------------------------
    | Use Uuids
    |--------------------------------------------------------------------------
    |
    | Acl vem definida para usar chaves primárias incrementais por padrão. Se você
    | deseja usar UUIDs em vez disso, atualize esta configuração para true.
    | Você também precisará atualizar suas migrações para usar UUIDs.
    */

    'incrementing' => false,

    'keyType' => 'string',

    'connection' => 'mysql',

    'route' => [
        'prefix' => 'admin', 
    ],
    // 'navigation' => [
    //     'tenant' => [
    //         'group' => "Operacional",
    //         'icon' => null,
    //         'label' => 'Controle de Acesso',
    //         'badge' => null,
    //     ],
    // ],
];
