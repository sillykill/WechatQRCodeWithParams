<?php
require_once dirname(__FILE__)."/../../pojo/store.php";
header('Content-Type:application/json; charset=utf-8');

    $store = new store($name,$descr);
    $total = $store->getTotal();
    echo json_encode(array("state"=>"200","total"=>$total));