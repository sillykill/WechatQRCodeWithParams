<?php
class Db
{
    private $conn;
    private $stmt;
    private $result;

    function __construct(){
        $conn = new mysqli(GlobalData::servername,GlobalData::username,GlobalData::password,GlobalData::dbname);
        if ($conn->connect_error){
            die("conn error:".$conn->connect_error);
        }
        mysqli_query($conn,"set names utf8");
        $this->conn = $conn;
    }

    public function getconn(){
        return $this->conn;
    }

    public function excuteSql($sql){
        return $this->conn->query($sql);
    }

    public function querySql($sql){
        $this->result = $this->conn->query($sql);
        return $this->result;
    }

    //success
    public function excutePreSql($sql,$type,...$parms){
        try {
            $this->stmt = $this->conn->prepare($sql);
            $this->stmt->bind_param($type,...$parms);
            return $this->stmt->execute();
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }


    public function closeconn(){
        $this->conn->close();
    }

    function getIdByScene($scene){
        $db = new Db();
        $sql = "SELECT id FROM store WHERE scene = '$scene' LIMIT 1";
        $res = $db->querySql($sql);
        while ($row = $res->fetch_assoc()){
            return $row['id'];
        }
    }
}