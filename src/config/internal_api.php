<?php
return [
    /**
     * 对内部其他系统提供api
     *
     * 格式为：
     * 调用方标识 => 调用方secret
     */
    'server' => [
        // app id => app secret
        'finance' => 'a249f0e40e31877adedd76fac6c6c116',
        'mall' => '8b54fdc7b317906d93c83152be5f956b',
        'xiaoke' => '8b54fdc7b317906d93c83152be5f956b',
    ],
    /**
     * 配置可以使用的内部系统
     */
    'client' => [
        /**
         * key 为 api 项目的名称。
         * 数组为该系统的配置，由该系统的负责人提供
         */
        'finance' => [
            'base_uri' => env('INTERNAL_CLIENT_FINANCE_URI', ''),
            'appid' => env('INTERNAL_CLIENT_FINANCE_APPID', ''),
            'secret' => env('INTERNAL_CLIENT_FINANCE_SECRET', ''),
            'timeout' => 30,
        ],
        'mall' => [
            'base_uri' => env('INTERNAL_CLIENT_MALL_URI', ''),
            'appid' => env('INTERNAL_CLIENT_MALL_APPID', ''),
            'secret' => env('INTERNAL_CLIENT_MALL_SECRET', ''),
            'timeout' => 3,
        ],
    ],
];