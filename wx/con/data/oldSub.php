<?php
require_once dirname(__FILE__)."/../../pojo/opendata.php";
header('Content-Type:application/json; charset=utf-8');

    echo json_encode(array("state"=>"200","total"=>getOldSubData()));