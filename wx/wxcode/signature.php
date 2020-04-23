<?php

require_once dirname(__FILE__)."/../pojo/sub.php";
require_once dirname(__FILE__)."/../pojo/opendata.php";

$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = "TOKEN";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $RX_TYPE = trim($postObj->MsgType);
            switch ($RX_TYPE)
            {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
            }
            echo $result;
        }else {
            echo "";
            exit;
        }
    }

    private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event)
        {
            case "subscribe":   //关注事件 一个需要查看是那种入口 二个是需要跟踪链路
                $content = "欢迎关注精为科技";
                $this->checkTicket($object);
                break;
            case "unsubscribe": //取消关注事件
                $content = "取消关注事件";
                $this->unsubIt($object);
                // 取关的时候记录是否是二维码扫描进入关注以及进行数据更新
                //
                break;
            case "SCAN":
                $content = "用户已关注时的事件推送 代参二维码入口";
                break;
            default:
                break;
        }

        $result = $this->transmitText($object, $content);

        return $result;
    }

    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        </xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    private function checkTicket($object){
        //看看是不是已经关注过了的
        //然后再进行Date插入
        if (isset($object->EventKey)){
            $key = substr($object->EventKey,8);
            $openid = $object->FromUserName;
            $sub = new sub($key,$openid);
            $sub->appeend();
//            xcache_set("openida",$openid);
//            error_log("".$openid,3,dirname(__FILE__)."/../log/openid.log");
            new opendata($openid);

            //进行业务处理
        }else{

        }
    }

    private function unsubIt($object){
        $sub = new sub(null,$object->FromUserName);
        $sub->down();
        new opendata($object->FromUserName);
    }
}
?>