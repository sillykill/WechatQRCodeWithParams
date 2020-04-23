<?php
require_once dirname(__FILE__)."/../../pojo/store.php";
require_once dirname(__FILE__)."/../../util/getParams.php";
header('Content-Type:application/json; charset=utf-8');


    $id = allTypeData('id');
    $cname = allTypeData('cname');
    if (isset($cname))
        modifyName($id,$cname);
    else
        return;