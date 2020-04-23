<?php

require_once dirname(__FILE__)."/../util/Db.php";
require_once dirname(__FILE__)."/../conf/GlobalData.php";
require_once dirname(__FILE__)."/../util/Net.php";

class opendata
{
    private $openid;

    /**
     * opendata constructor.
     * @param $openid
     */
    public function __construct($openid)
    {
        $this->openid = $openid;
        $this->writedown();
    }

    //记得去重
    private function writedown(){
        $res = $this->requestWx();
        $db = new Db();
        $date = date("Y-m-d h:i:s");
        $sql = "INSERT INTO opendate (subscribe,openida,nickname,sex,languagea,city,province,country,headimgurl,subscribe_time,remark,groupid,subscribe_scene,qr_scene,qr_scene_str,ctime) VALUES ('$res->subscribe','$res->openid','$res->nickname','$res->sex','$res->languagea','$res->city','$res->province','$res->country','$res->headimgurl','$res->subscribe_time','$res->remark','$res->groupid','$res->subscribe_scene','$res->qr_scene','$res->qr_scene_str','$date')";
        $db->excuteSql($sql);

    }


    /**
     *  对外的json用户数据
     */
    private function getInfo(){

    }

    private function requestWx(){
        $net = new Net();
        $token = singlonAccessToken::getInstance();
        $wxres = $net->do_get(GlobalData::opendate_url,array("access_token"=>$token,"openid"=>"".$this->openid,"lang"=>"zh_CN"));
        if (isset($wxres->errcode)){
            die();
        }else{
            return json_decode($wxres);
        }
    }

}

//            $row['nickname'];
//        $row['sex'];
//        $row['ctime'];
//        $row['city'];
//        $row['province'];
//        $row['country'];
//        $row['subtime'];
//        $row['unsubtime'];
//        $row['state'];


function getOldSubData(){
    $ares = array();
//    array_push($ares,array("用户名称"=>"用户名称","性别"=>"性别","创建时间"=>"创建时间","国家"=>"国家","省份"=>"省份","城市"=>"城市","关注时间"=>"关注时间","取关时间"=>"取关时间","关注状态"=>"关注状态"));
    $db = new Db();
    $sql = "SELECT o.*,s.*,max(o.ctime) as max_time FROM opendate o RIGHT JOIN (SELECT s.*,max(s.ctime) as max_time,st.touser FROM sub s LEFT JOIN store st ON s.touserid = st.id WHERE st.state = '1' AND s.state = '3'  GROUP BY id) s ON o.openida = s.openid WHERE o.subscribe = '1' GROUP BY s.id";
    $res = $db->excuteSql($sql);
    while ($row = $res->fetch_assoc()){

        $sex = "";
        $state = "老粉丝关注";

        if ( $row['sex'] == "0")
            $sex = "未填写";
        elseif ($row['sex'] == "1")
            $sex = "男";
        else
            $sex = "女";

//        if ($row['state'] == "0")
//            $state = "新粉丝关注";
//        elseif ($row['state'] == "1")
//            $state = "新粉丝取关";
//        elseif ($row['state'] == "3")
//            $state = "老粉丝关注";
//        elseif ($row['state'] == "4")
//            $state = "老粉丝取关";
//        else
//            $state = "粉丝";

        array_push($ares,array("nickname"=>$row['nickname'],"sex"=>$sex, "ctime"=>$row['ctime'],"country"=>$row['country'],"province"=>$row['province'],"city"=>$row['city'],"subtime"=>$row['subtime'],"unsubtime"=>$row['unsubtime'],"state"=>$state,"store"=>$row['touser']));
    }
    return $ares;
}

function getNewSubData(){
    $ares = array();
//    array_push($ares,array("用户名称"=>"用户名称","性别"=>"性别","创建时间"=>"创建时间","国家"=>"国家","省份"=>"省份","城市"=>"城市","关注时间"=>"关注时间","取关时间"=>"取关时间","关注状态"=>"关注状态"));
    $db = new Db();
    $sql = "SELECT o.*,s.*,max(o.ctime) as max_time FROM opendate o RIGHT JOIN (SELECT s.*,max(s.ctime) as max_time,st.touser FROM sub s LEFT JOIN store st ON s.touserid = st.id WHERE st.state = '1' AND s.state = '0'  GROUP BY id) s ON o.openida = s.openid WHERE o.subscribe = '1' GROUP BY s.id";
    $res = $db->excuteSql($sql);
    while ($row = $res->fetch_assoc()){

        $sex = "";
        $state = "新粉丝关注";

        if ( $row['sex'] == "0")
            $sex = "未填写";
        elseif ($row['sex'] == "1")
            $sex = "男";
        else
            $sex = "女";

//        if ($row['state'] == "0")
//            $state = "新粉丝关注";
//        elseif ($row['state'] == "1")
//            $state = "新粉丝取关";
//        elseif ($row['state'] == "3")
//            $state = "老粉丝关注";
//        elseif ($row['state'] == "4")
//            $state = "老粉丝取关";
//        else
//            $state = "粉丝";

        array_push($ares,array("nickname"=>$row['nickname'],"sex"=>$sex, "ctime"=>$row['ctime'],"country"=>$row['country'],"province"=>$row['province'],"city"=>$row['city'],"subtime"=>$row['subtime'],"unsubtime"=>$row['unsubtime'],"state"=>$state,"store"=>$row['touser']));
    }
    return $ares;
}

function getOldUnSubData(){
    $ares = array();
//    array_push($ares,array("用户名称"=>"用户名称","性别"=>"性别","创建时间"=>"创建时间","国家"=>"国家","省份"=>"省份","城市"=>"城市","关注时间"=>"关注时间","取关时间"=>"取关时间","关注状态"=>"关注状态"));
    $db = new Db();
    $sql = "SELECT o.*,s.*,max(o.ctime) as max_time FROM opendate o RIGHT JOIN (SELECT s.*,max(s.ctime) as max_time,st.touser FROM sub s LEFT JOIN store st ON s.touserid = st.id WHERE st.state = '1' AND s.state = '4'  GROUP BY id) s ON o.openida = s.openid WHERE o.subscribe = '1' GROUP BY s.id";
    $res = $db->excuteSql($sql);
    while ($row = $res->fetch_assoc()){

        $sex = "";
        $state = "老粉丝取关";

        if ( $row['sex'] == "0")
            $sex = "未填写";
        elseif ($row['sex'] == "1")
            $sex = "男";
        else
            $sex = "女";

//        if ($row['state'] == "0")
//            $state = "新粉丝关注";
//        elseif ($row['state'] == "1")
//            $state = "新粉丝取关";
//        elseif ($row['state'] == "3")
//            $state = "老粉丝关注";
//        elseif ($row['state'] == "4")
//            $state = "老粉丝取关";
//        else
//            $state = "粉丝";

        array_push($ares,array("nickname"=>$row['nickname'],"sex"=>$sex, "ctime"=>$row['ctime'],"country"=>$row['country'],"province"=>$row['province'],"city"=>$row['city'],"subtime"=>$row['subtime'],"unsubtime"=>$row['unsubtime'],"state"=>$state,"store"=>$row['touser']));
    }
    return $ares;
}

function getNewUnSubData(){
    $ares = array();
//    array_push($ares,array("用户名称"=>"用户名称","性别"=>"性别","创建时间"=>"创建时间","国家"=>"国家","省份"=>"省份","城市"=>"城市","关注时间"=>"关注时间","取关时间"=>"取关时间","关注状态"=>"关注状态"));
    $db = new Db();
    $sql = "SELECT o.*,s.*,max(o.ctime) as max_time FROM opendate o RIGHT JOIN (SELECT s.*,max(s.ctime) as max_time,st.touser FROM sub s LEFT JOIN store st ON s.touserid = st.id WHERE st.state = '1' AND s.state = '1'  GROUP BY id) s ON o.openida = s.openid WHERE o.subscribe = '1' GROUP BY s.id";
    $res = $db->excuteSql($sql);
    while ($row = $res->fetch_assoc()){

        $sex = "";
        $state = "新粉丝取关";

        if ( $row['sex'] == "0")
            $sex = "未填写";
        elseif ($row['sex'] == "1")
            $sex = "男";
        else
            $sex = "女";

//        if ($row['state'] == "0")
//            $state = "新粉丝关注";
//        elseif ($row['state'] == "1")
//            $state = "新粉丝取关";
//        elseif ($row['state'] == "3")
//            $state = "老粉丝关注";
//        elseif ($row['state'] == "4")
//            $state = "老粉丝取关";
//        else
//            $state = "粉丝";

        array_push($ares,array("nickname"=>$row['nickname'],"sex"=>$sex, "ctime"=>$row['ctime'],"country"=>$row['country'],"province"=>$row['province'],"city"=>$row['city'],"subtime"=>$row['subtime'],"unsubtime"=>$row['unsubtime'],"state"=>$state,"store"=>$row['touser']));
    }
    return $ares;
}

function getStroeName(){
    $db = new Db();
    $date = array();
    $sql = "SELECT touser FROM store WHERE state = '1'";
    $res = $db->excuteSql($sql);
    while ($row = $res->fetch_assoc()){
        $arr = array("text"=>$row['touser'],"value"=>$row['touser']);
        array_push($date,$arr);
    }
    return $date;
}
