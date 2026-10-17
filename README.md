# myFrame
我的一个简单的MVC框架
## 自动加载

## 核心类

## DB类

## Route 类
2018年8月31日 v0.1.1

2018年9月9日 v1.0.0
    注册路由->链式 命名路由->生产URL

## 核心控制器
    MockController 用于模拟数据
    QueueController 处理消息队列
    StaticController 处理静态化
# 目录结构
    app/
        controllers/ -> 存放控制器
            --核心控制器
            Controller.php              -> 被 所有控制器 继承
            TempController.php      -> 控制器模板
            
        models/ 存放模型
            --核心控制器
            Model.php              -> 被 所有模型 继承
            Temp.php    -> 模型模板
    Config/
        config.php      -> 配置文件
    core/ 核心代码
        Controller.php  -> 核心控制器
        App.php         -> 入口文件整合
        corefn.php      -> 全局核心辅助函数
        DB.php          -> 数据库类 单例
        Loader.php      -> 自动加载类
        Model.php       -> 核心模型
        RD.php          -> redis类 队列/缓存
        Request.php     -> 处理请求类  待完善 目前没卵用
        Response.php    -> 相应类 待完善 目前 没什么用
        Route.php       -> 路由
    libs/ 拓展类
        Log.php         -> 日志类
        Mail.php        -> 邮件类
        Snowflake.php   -> 生成雪花编号
        Upload.php      -> 上传类
    logs/ 日志文件夹
    public/ 
        入口文件&前端页面&资源
        css/            -> 样式文件
        images/         -> 图片文件
        js/             -> JS文件
        index.php       -> 入口文件
        .htaccess       -> 路由重写文件
    route/
        web.php         -> 注册路由
    tests/ 存放一些PHP测试文件 与 实例 代码
        MockController.php      -> 用于模拟数据
        QueueController.php     -> 处理消息队列
        StaticController.php    -> 处理静态化
        AlipayController.php    -> 支付宝支付
        ... 
    uploads/ 用户上传资源
    verdor/ composer
    views/ 视图资源

    composer.json       -> 使用的包
    .gitignore          -> git 忽略文件
    artisna.php         -> 命令行指令文件
    env.php             -> 开发配置

## Exception 异常 与 捕获定位


## 数据格式输出

## 框架优化 
1. 路由优化 注册路由

##  myFrame v1.0

2018年9月25日 10点08分

## project-shop 
2018年9月25日 BEGING











## END

## PHP 8 开发环境

需要 PHP 8.2+、Composer、Redis，以及 PHP Redis 扩展（会话）、mbstring、XML 和 PDO MySQL 扩展（数据库功能）。

```sh
composer install
# 首次运行时复制配置；已有 env.php 时请保留
cp -n env.php.example env.php
# 先启动本地 Redis，再启动 PHP 开发服务器
php -S 127.0.0.1:9999 -t public public/index.php
```

首页应显示 `welcome to myFrame`。入口使用 `Asia/Shanghai` 时区；Linux 路径区分大小写。
日志目录会在首次写日志时创建，请确保项目目录可写。

兼容性验证（需要本地 Redis）：

```sh
php tests/runtime_smoke.php
```

依赖已更新为 Predis 3、Smarty 5 和新版 HTMLPurifier，并通过锁文件固定版本。
Smarty 5 的类名为 `Smarty\Smarty`，自定义控制器若要启用模板引擎，请使用
`new \Smarty\Smarty()`，并通过 setter 方法配置模板目录等选项。
默认首页使用框架自己的 PHP 视图，不依赖 Smarty。
