<?php

/**
 * 接受GET POST的请求方式并且校验请求值进行一些过滤
 * 1. 是否为NULL
 * 2. 获取GET POST类型请求
 * 3. 对参数进行校验
 * @param $name 所需要获取的请求值
 * @return string 返回请求值
 */
function allTypeData($name){
    return isset($_REQUEST[$name])? htmlspecialchars($_REQUEST[$name]) : '';
}