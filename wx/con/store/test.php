<?php
require_once dirname(__FILE__)."/../../util/getParams.php";
header('Content-Type:application/json; charset=utf-8');

$name = allTypeData('name');
$desc = allTypeData('desc');


exit(json_encode(array("name"=>$name,"desc"=>$desc)));

