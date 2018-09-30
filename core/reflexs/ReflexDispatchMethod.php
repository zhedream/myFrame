<?php

namespace core\reflexs;

use core\ReflexMethod;

class ReflexDispatchMethod extends ReflexMethod
{

    /**
     * 传入路由参数 与 依赖注入
     * @param $args
     */
    protected function _before_invokeArgs(&$args) {

        $routeVars = \core\Request::getRouteVar();
        $args = array_merge_recursive($args, $routeVars);
        $data = [];
        foreach ($this->paramNames as $key => $val) {
            if ($val['typeName']) {
                $data[] = new $val['typeName'];
            } else {
                $data[] = current($args);
                next($args);
            }
        }
        $args = $data;
    }


}