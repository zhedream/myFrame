<?php

return [
    // 全局中间件
    'middleware'=>[
        \core\Middlewares\VerifyCsrfToken::class,
        \core\Middlewares\After::class,
    ],
    // 路由中间件
    'routeMiddleware'=>[
        'CheckLogin'=>\app\Middlewares\CheckLogin::class,

    ],
    'middlewareGroups'=>[
        'web'=>[

        ],
        'api'=>[
            
        ]
    ],
    'middlewareMethods'=>[
        'get'=>[

        ],
        'post'=>[

        ]
    ]


];