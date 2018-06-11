# Internal API Server/Client(PHP版)


> 该项目使用 composer 来完成加载

执行 
```bash
composer config repositories.php-internal-api-client vcs git@git.int.haowumc.com:arch/php-internal-api-client.git
composer require arch/php-internal-api-client
```


### 如何使用

#### Server

* 注册中间件

```php
$app->routeMiddleware([
    'internal' => PdInternalApi\Middleware\InternalApi::class,
]);

```

* 增加配置文件：```config/internal_api.php```  , 在server数组中为调用方增加 secret。

```php
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
        '{{app name}}' => env('INTERNAL_SERVER_{{app name}}_SECRET'),
    ],
];
```

* 在项目 .env 文件中增加如下配置

```
INTERNAL_SERVER_{{app name}}_SECRET=323232323
```

* 在路由中启用中间件

```php
$route->group(['middleware'=>'internal'],function()use($router){
    //这里添加对应路由
});
```


#### Client

* 注册服务

```PHP
$app->register(PdInternalApi\ServiceProvider::class);
```
* 增加配置文件：```config/internal_api.php```  , 在server数组中为调用方增加 secret。

```php
<?php
return [
    /**
     * 配置可以使用的内部系统
     */
    'client' => [
        /**
         * key 为 api 项目的名称。
         * 数组为该系统的配置，由该系统的负责人提供
         */
        '{app name}' => [
            'base_uri' => env('INTERNAL_CLIENT_{{app name}}_URI', ''),
            'appid' => env('INTERNAL_CLIENT_{{app name}}_APPID', ''),
            'secret' => env('INTERNAL_CLIENT_{{app name}}_SECRET', ''),
            'timeout' => 30,
        ],
    ],
];
```

* 在项目 .env 文件中增加如下配置

```
INTERNAL_CLIENT_{app name}_URI=http://test.in.haowumc.com/
INTERNAL_CLIENT_{app name}_APPID=test
INTERNAL_CLIENT_{app name}_SECRET=sdfsdfsdf
```

* 调用

```php
$api = app('internal.api.{{app name}}')
$resp = $api->call('{{URI}}',$params);
```