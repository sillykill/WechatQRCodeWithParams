<?php

require_once dirname(__FILE__)."/../util/Qrcode.php";
require_once dirname(__FILE__)."/../util/Db.php";
require_once dirname(__FILE__)."/../conf/GlobalData.php";

class sub
{
    private $touserid;
    private $openid;
    private $date;

    /**
     * sub constructor.
     * @param $touserid
     * @param $openid
     * @param $date
     */
    public function __construct($scene, $openid)
    {
        if (isset($scene))
            $this->touserid = $this->getIdByScene($scene);
        $this->date = date("Y-m-d h:i:s");
        $this->openid = $openid;
    }

    public function appeend(){
        //查询里面用户状态
        //决定插入的state
        $state = $this->inquireState();
        $id = $state['id'];
        $db = new Db();
        if(isset($state['id'])){
            $sql = "UPDATE sub SET state = '3',subtime = '$this->date' WHERE id = '{$state['id']}'";
            $res = $db->excuteSql($sql);
            if ($res){

            }else{

            }
        }else{
            $sql = "INSERT INTO sub(touserid,openid,subtime,state,ctime) VALUES ('$this->touserid','$this->openid','$this->date','0','$this->date')";
            $res = $db->excuteSql($sql);
            if ($res){

            }else{

            }
        }
    }

    public function down(){
        $state = $this->getstatebyopenid();
        if (!$state)
            return;
        $db = new Db();
        if($state['state'] == 0){
            $sql = "UPDATE sub SET state = '1',unsubtime = '$this->date' WHERE id = '{$state['id']}'";
            $res = $db->excuteSql($sql);
            if ($res){

            }else{

            }
        }else{
            $sql = "UPDATE sub SET state = '4',unsubtime = '$this->date' WHERE id = '{$state['id']}'";
            $res = $db->excuteSql($sql);
            if ($res){

            }else{

            }
        }
    }

    //查询里面用户状态 只有在扫二维码的时候才会有
    private function inquireState(){
        $db = new Db();
        $sql = "SELECT * FROM sub WHERE touserid = '$this->touserid' AND openid='$this->openid' LIMIT 1";
        $res = $db->querySql($sql);
        if ($res->num_rows == 0){
            return false;
        }else{
            while ($row = $res->fetch_assoc()){
                return (array("id"=>$row['id'],"state"=>$row['state']));
            }
        }

    }

    private function getstatebyopenid(){
        $db = new Db();
        $sql = "SELECT * FROM sub WHERE openid='$this->openid' AND (state = '0' OR state = '3') LIMIT 1";
        $res = $db->querySql($sql);
        if ($res->num_rows == 0){
            return false;
        }else{
            while ($row = $res->fetch_assoc()){
                return (array("id"=>$row['id'],"state"=>$row['state']));
            }
        }
    }

    private function getIdByScene($scene){
        $db = new Db();
        $sql = "SELECT * FROM store WHERE scene='$scene' LIMIT 1";
        $res = $db->querySql($sql);
        while ($row = $res->fetch_assoc()){
            return $row['id'];
        }
    }

}