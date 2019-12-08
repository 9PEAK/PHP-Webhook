# Webhook 自动部署

该程可根据仓库回调webhook配置的url时，自动执行所配置的shell。
<br>
通常用于开发后，将最终代码部署到测试环境或生产环境，程序脚本虽然是PHP，但可使用在任何语言的项目上，只要服务器端能够正常执行PHP即可。目前作者已成功执行的shell如下：
<ul>
    <li>git pull</li>
    <li>php artisan config:cache # Laravel 缓存更新</li>
    <li>php artisan migrate # Laravel迁移更新</li>
</ul>



### 使用

首先配置项目，将“example-config.php”更名为“config.php”，配置如下：
```php
'9-huba' => [ // 项目名称，多个项目名称不可重复
        'key' => '9e06118d2754dba90a7c5a2886cf2ef6', // webhook中配置的token
        'typ' => 'gitee', // 仓库站点，目前仅支持github和gitee
        'msg' => '# GIT DEPLOY', // 口令，当git push时附带的消息将与此口令匹配（大小写敏感），完全一致时执行shell
        'dir' => '/data/wwwroot/yun.abc.net/', // 项目所在目录
        'cmd' => [ // shell，其中{$dir}将被解析为项目所在目录。
            'git pull',
            'php {$dir}artisan migrate',
            'php {$dir}artisan config:cache',
//            'composer install',
        ]
    ]
```

Webhook 的URL配置务必带上id参数，该参数即上述项目名称，表示具体需要部署的项目。
<br> 如 http://abc.net/webhook/index.php?id=webhook 表示更新部署项目“webhook”。 

### 问题
目前作者尚未成功实现执行Composer install，如有成功解决者请留言告知，谢谢。
<ul>
<li>

 [PHP 使用 passthru 执行 “Composer install” 失败](https://learnku.com/php/t/37720)
 
 </li>
</ul>
