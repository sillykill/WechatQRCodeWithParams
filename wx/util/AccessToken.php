<?php

require_once dirname(__FILE__)."/Net.php";
//include_once "Log.php";
require_once dirname(__FILE__)."/backMsg.php";

/**
 * Class AccessToken
 * 废弃掉
 */
class AccessToken
{
    /**
     * @var 微信公众号开发请求API所需参数，用于用户校验
     *
     */
    Static $accessToken;

    /**
     * @var 刷新时间，在进行Token刷新的时候标记刷新时间，已对下一次刷新进行校正
     */
    Static $date;


    /**
     * @var int 计时超时
     */
    Static $count = 0;

    /**
     * AccessToken constructor.
     * AccessToken构造函数，用于初始化全局时间，对Token进行自刷新
     */
    function __construct(){
        self::$date = date("Y-m-d H:i:s");
    }

    /**
     * Http get 请求微信API获取Token接口
     * @return mixed 微信公众号开发接口API所需参数 Token
     */
    private function getAccessTokenFromWx(){
        $net = new Net();
        $url = GlobalData::access_token_url;
        $parms = array("grant_type"=>GlobalData::grant_type,"appid"=>GlobalData::appid,"secret"=>GlobalData::secret);

        $wxres =  $net->do_get($url,$parms);
        $access_token = json_decode($wxres);

        if (isset($access_token->errcode)){
            if(self::$count < 5){
                sleep(self::$count++);
                $this->getAccessTokenFromWx();
            }else{
                echo err("获取Token失败。请联系管理员");
                return false;
            }
        }else{
        }
        return $access_token->access_token;
    }

    /**
     * 用于校验Token获取
     * 1. 是否时间超时
     * 2. 是否是为空值
     * @return mixed
     */
    public function durableToken(){
        if ($this->checkTimeOut() || !isset($accessToken)){
            self::$date = date("Y-m-d H:i:s");
            $isget = $this->getAccessTokenFromWx();
            if ($isget){
                self::$accessToken = $isget;
                return self::$accessToken;
            }else{
                return;
            }

        }else{
            return self::$accessToken;
        }
    }

    /**
     * 时间校验，是否是超过一小时
     * @return bool
     */
    private function checkTimeOut(){
        $now = date_create(date("Y-m-d H:i:s"));
        $old = date_create(self::$date);
        $diff = date_diff($old,$now);

        $hour = $diff->h;
        if ($hour == 1 || $hour > 1){
            return true;
        }else{

            return false;
        }
    }
}
