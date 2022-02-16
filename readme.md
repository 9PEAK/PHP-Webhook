# Webhook 自动部署

该程序可根据仓库webhook回调时，自动执行所配置的shell。
<br>
通常用于开发后，将最终代码部署到测试环境或生产环境，程序虽然是PHP，但可使用在任何语言的项目上，只要服务器端能够正常执行PHP即可。
<ul>
    <li>cd /www/wwwroot/php-abc.com</li>
    <li>git pull</li>
    <li>composer install</li>
    <li>php artisan config:cache # Laravel 缓存更新</li>
    <li>php artisan migrate # Laravel迁移更新</li>
    <li>... </li>
    
</ul>


### 使用

首先配置项目，将“example-config.php”更名为“config.php”，配置说明如下：
```php
# 项目名称，多个项目名称不可重复
'webhook' => [
        # webhook中配置的token或secret
        'key' => '9e06118d2754dba90a7c5a2886cf2ef6',
        
        # 仓库站点，目前仅支持github和gitee
        'typ' => 'gitee',
        
        # shell
        'cmd' => [
            'cd /data/wwwroot/php-abc.net/'
            'git pull',
            'composer install',
            'php /data/wwwroot/yun.abc.net/artisan config:cache',
            'php /data/wwwroot/yun.abc.net/artisan migrate',
            
        ]
    ]
```

Webhook 的URL配置务必带上GET参数id，该参数即上述项目名称，表示具体需要部署的项目。
<br> 如 http://{domain}/webhook/index.php?id=webhook 表示更新部署项目“webhook”。 


### 避坑
<ul>
<li>
    服务器请务必做好对应用户和权限的配置：通常http请求的进程由www接管，若对应的目录下有归属非www且权限高于www的文件，则部分shell将执行失败（如 git pull拉取文件）。
</li>
</ul>
