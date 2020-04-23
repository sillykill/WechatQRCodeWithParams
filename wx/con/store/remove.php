<?php
require_once dirname(__FILE__)."/../../util/getParams.php";
require_once dirname(__FILE__)."/../../pojo/store.php";
header('Content-Type:application/json; charset=utf-8');

$scene = allTypeData('scene');
$store = new store($name,$descr);
if ($store->modifystate($scene))
    echo json_encode(array("state"=>"200","msg"=>"success"));
else
    echo json_encode(array("state"=>"300","msg"=>"error"));
