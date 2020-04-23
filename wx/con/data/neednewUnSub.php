<?php
require_once dirname(__FILE__)."/../../util/writecsv.php";
require_once dirname(__FILE__)."/../../pojo/opendata.php";
$total = getNewUnSubData();
array_unshift($total,array("用户名称"=>"用户名称","性别"=>"性别","创建时间"=>"创建时间","国家"=>"国家","省份"=>"省份","城市"=>"城市","关注时间"=>"关注时间","取关时间"=>"取关时间","关注状态"=>"关注状态"));
outputCSV("店铺粉丝关注数据表",$total);
