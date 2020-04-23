<?php
require_once dirname(__FILE__)."/../../pojo/store.php";
require_once dirname(__FILE__)."/../../util/getParams.php";
require_once dirname(__FILE__)."/../../util/writecsv.php";

    //...
    $store = new store($name,$descr);
    $total = $store->saveTotal();
    outputCSV("店铺粉丝关注数据表",$total);
