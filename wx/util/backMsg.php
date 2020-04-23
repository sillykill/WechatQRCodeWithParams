<?php

function success($msg = null){
    $e = new backMsg(200,isset($msg)?$msg:"success");
    return $e->getCode();
}

function err($msg = null){
    $e = new backMsg(400,isset($msg)?$msg:"success");
    return $e->getCode();
}
class backMsg
{
    var $state;
    var $detail;

    function __construct($par1,$par2){
        $this->state = $par1;
        $this->detail = $par2;
    }

    function getCode(){
        return json_encode($this);
    }
}
