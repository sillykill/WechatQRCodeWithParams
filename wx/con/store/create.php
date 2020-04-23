<?php

require_once dirname(__FILE__)."/../../util/getParams.php";
require_once dirname(__FILE__)."/../../pojo/store.php";
header('Content-Type:application/json; charset=utf-8');

    $name = allTypeData("name");
    $descr = allTypeData("descr");

    $store = new store($name,$descr);
    $ticket = $store->wirte();
    if ($ticket){
        echo json_encode(array("state"=>"200","ticket"=>$ticket));
    }else{
        echo json_encode(array("state"=>"400"));
    }
