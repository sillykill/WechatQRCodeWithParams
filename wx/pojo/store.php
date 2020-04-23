<?php

require_once dirname(__FILE__)."/../util/Qrcode.php";
require_once dirname(__FILE__)."/../util/Db.php";
require_once dirname(__FILE__)."/../conf/GlobalData.php";

class store
{
    private $name;
    private $desc;
    private $state;



    /**
     * store constructor.
     * @param $name
     * @param $desc
     * @param $state
     */
    public function __construct($name, $desc){
        $this->name = $name;
        $this->desc = $desc;
        $this->state = "1";
    }

    public function wirte(){
        $db = new Db();
        $sql = "SELECT ticket FROM store WHERE touser = '$this->name' AND state = '1' LIMIT 1";
        $res = $db->querySql($sql);
        if($res->num_rows){
            while ($row = $res->fetch_assoc())
                return $row['ticket'];
        }else{
            $date = date("Y-m-d h:i:s");
            $scene = date("Ymd").rand(1,1000000);
            $qr = new Qrcode("limitStr",$scene);
            $ticket = $qr->durableTicket();
            $jpgname = $qr->savejpg($ticket,$scene);
            $sql = "INSERT INTO store (touser,ticket,qrl,descr,scene,state,ctime) VALUES('$this->name','$ticket','$jpgname','$this->desc','$scene','$this->state','$date')";
            if($db->excuteSql($sql)){
                return $ticket;
            }else{
                return false;
            }
        }
    }

    public function getTicket($name){
        $db = new Db();
        $sql = "SELECT ticket FROM store WHERE touser = '$name' LIMIT 1";
        $res = $db->querySql($sql);
        if($res->num_rows){
            while ($row = $res->fetch_assoc())
                return $row['ticket'];
        }else{
            return false;
        }
    }


    public function editStoreName($name){

    }

    public function getTotal(){
        $resdate = array();
        $db = new Db();
        $sql = "SELECT * FROM store WHERE state = '1'";
        $res = $db->querySql($sql);
        while ($row = $res->fetch_assoc()){
            $date = array("id"=>$row['id'],"touser"=>$row['touser'],"ticket"=>$row['ticket'],"descr"=>$row['descr'],"scene"=>$row['scene']);
            $sqlsub="SELECT state,COUNT(state) as num FROM sub WHERE touserid = '{$row['id']}' GROUP BY state";
            $ressub = $db->querySql($sqlsub);
            while ($rowsub = $ressub->fetch_assoc()){
                $date = array_merge($date,$this->changeState($rowsub));
            }
            if (isset($date['newnetsub'])|isset($date['newunsub'])|isset($date['oldnetsub'])|isset($date['oldunsub'])){
                $date = isset($date['newnetsub'])?$date:array_merge($date,array("newnetsub"=>'0'));
                $date = isset($date['newunsub'])?$date:array_merge($date,array("newunsub"=>'0'));
                $date = isset($date['oldnetsub'])?$date:array_merge($date,array("oldnetsub"=>'0'));
                $date = isset($date['oldunsub'])?$date:array_merge($date,array("oldunsub"=>'0'));
                $date = array_merge($date,array("newsub"=>($date['newnetsub']+$date['newunsub'])."","oldsub"=>($date['oldnetsub']+$date['oldunsub']).""));
            }else{

                $date = array_merge($date,array("newnetsub"=>'0',"newunsub"=>'0',"oldnetsub"=>'0',"oldunsub"=>'0',"newsub"=>'0',"oldsub"=>'0'));
            }
            array_push($resdate,$date);
        }

        return $resdate;

    }


    public function saveTotal(){
        $resdate = array();
        array_push($resdate, array("店铺名称"=>"店铺名称","店铺描述"=>"店铺描述","新粉丝净关注"=>"新粉丝净关注","新粉丝取消关注"=>"新粉丝取消关注","老粉丝净关注"=>"老粉丝净关注","老粉丝取消关注"=>"老粉丝取消关注","新粉丝关注"=>"新粉丝关注","老粉丝关注"=>"老粉丝关注"));
        $db = new Db();
        $sql = "SELECT * FROM store WHERE state = '1'";
        $res = $db->querySql($sql);
        while ($row = $res->fetch_assoc()){
            $date = array("touser"=>$row['touser'],"descr"=>$row['descr']);
            $sqlsub="SELECT state,COUNT(state) as num FROM sub WHERE touserid = '{$row['id']}' GROUP BY state";
            $ressub = $db->querySql($sqlsub);
            while ($rowsub = $ressub->fetch_assoc()){
                $date = array_merge($date,$this->changeState($rowsub));
            }
            if (isset($date['newnetsub'])|isset($date['newunsub'])|isset($date['oldnetsub'])|isset($date['oldunsub'])){
                $date = isset($date['newnetsub'])?$date:array_merge($date,array("newnetsub"=>'0'));
                $date = isset($date['newunsub'])?$date:array_merge($date,array("newunsub"=>'0'));
                $date = isset($date['oldnetsub'])?$date:array_merge($date,array("oldnetsub"=>'0'));
                $date = isset($date['oldunsub'])?$date:array_merge($date,array("oldunsub"=>'0'));
                $date = array_merge($date,array("newsub"=>($date['newnetsub']+$date['newunsub'])."","oldsub"=>($date['oldnetsub']+$date['oldunsub']).""));
            }else{

                $date = array_merge($date,array("newnetsub"=>'0',"newunsub"=>'0',"oldnetsub"=>'0',"oldunsub"=>'0',"newsub"=>'0',"oldsub"=>'0'));
            }
            array_push($resdate,$date);
        }

        return $resdate;

    }

    private function changeState($row){
        switch ($row['state']){
            case 0:
                return array("newnetsub"=>isset($row['num'])?$row['num']:'0');
                break;
            case 1;
                return array("newunsub"=>isset($row['num'])?$row['num']:'0');
                break;
            case 3;
                return array("oldnetsub"=>isset($row['num'])?$row['num']:'0');
                break;
            case 4;
                return array("oldunsub"=>isset($row['num'])?$row['num']:'0');
                break;
        }
    }

    public function modifystate($scene){
        $db = new Db();
        $sql = "UPDATE store SET state = '0' WHERE scene = '$scene'";
        return $db->excuteSql($sql);

    }

    public function modifystateAC($scene){
        $db = new Db();
        $sql = "UPDATE store SET state = '1' WHERE scene = '$scene'";
        return $db->excuteSql($sql);

    }

}

    function modifyName($id,$cname){
        $db  = new Db();
        $sql = "UPDATE store SET touser = '$cname' WHERE id = '$id'";
        return $db->excuteSql($sql);
    }
