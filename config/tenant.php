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

    'resources' => [
        'address' => [
            'icon' => 'fas-map-location-dot',
            // 'iconPosition' => 'left',
            // 'badge' => '',
            'title' => 'Endereços',
            // 'header_actions' => [],
            // 'actions' => [],
            // 'bulk_actions' => [],
            // 'emptyState' => [],
            'options' => [
                'state' => [
                    'AC' => 'Acre',
                    'AL' => 'Alagoas',
                    'AP' => 'Amapá',
                    'AM' => 'Amazonas',
                    'BA' => 'Bahia',
                    'CE' => 'Ceará',
                    'DF' => 'Distrito Federal',
                    'ES' => 'Espírito Santo',
                    'GO' => 'Goiás',
                    'MA' => 'Maranhão',
                    'MT' => 'Mato Grosso',
                    'MS' => 'Mato Grosso do Sul',
                    'MG' => 'Minas Gerais',
                    'PA' => 'Pará',
                    'PB' => 'Paraíba',
                    'PR' => 'Paraná',
                    'PE' => 'Pernambuco',
                    'PI' => 'Piauí',
                    'RJ' => 'Rio de Janeiro',
                    'RN' => 'Rio Grande do Norte',
                    'RS' => 'Rio Grande do Sul',
                    'RO' => 'Rondônia',
                    'RR' => 'Roraima',
                    'SC' => 'Santa Catarina',
                    'SP' => 'São Paulo',
                    'SE' => 'Sergipe',
                    'TO' => 'Tocantins',
                    'EX' => 'Estrangeiro',
                ]
            ]
        ],
        'contacts' => [
            'icon' => 'fas-address-book',
            // 'iconPosition' => 'left',
            // 'badge' => '',
            'title' => 'Contatos',
            // 'header_actions' => [],
            // 'actions' => [],
            // 'bulk_actions' => [],
            // 'emptyState' => [],
            'options' => [
                'phone' => 'Telefone Fixo',
                'fax' => 'Fone Fax',
                'cell' => 'Celular',
                'whatsapp' => 'Whatsapp',
                'email' => 'E-mail',
                'site' => 'Site',
            ]
        ],
        'documents' => [
            'icon' => 'fas-id-badge',
            // 'iconPosition' => 'left',
            // 'badge' => '',
            'title' => 'Documentos',
            // 'header_actions' => [],
            // 'actions' => [],
            // 'bulk_actions' => [],
            // 'emptyState' => [],
            'options' => [
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
            ]
        ],
        'social' => [
            'icon' => 'fas-share-alt',
            // 'iconPosition' => 'left',
            // 'badge' => '',
            'title' => 'Redes Sociais',
            // 'header_actions' => [],
            // 'actions' => [],
            // 'bulk_actions' => [],
            // 'emptyState' => [],
            'options' => [
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
            ]
        ]
    ]
];
