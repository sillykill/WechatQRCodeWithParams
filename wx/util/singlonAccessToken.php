<?php
require_once dirname(__FILE__)."/Net.php";
require_once dirname(__FILE__)."/../conf/GlobalData.php";

class singlonAccessToken
{

    private static $instance;

    /**
     * singlonAccessToken constructor.
     * @param $accessToken
     */
    private function __construct()
    {
        $this->durableToken();
    }

    //单例访问统一入口
    public static function getInstance()
    {
        if(!(self::$instance instanceof self)){
            self::$instance = new self();
        }
        return xcache_get("token");
    }

    /**
     * Http get 请求微信API获取Token接口
     * @return mixed 微信公众号开发接口API所需参数 Token
     */
    private function getAccessTokenFromWx(){
        $net = new Net();
        $url = GlobalData::access_token_url;
        $parms = array("grant_type"=>GlobalData::grant_type,"appid"=>GlobalData::appid,"secret"=>GlobalData::secret);
        $access_token =  json_decode($net->do_get($url,$parms));
        if (isset($access_token->errcode))
            return false;
        return $access_token->access_token;
    }

    /**
     * 用于校验Token获取
     * 1. 是否时间超时
     * 2. 是否是为空值
     * @return mixed
     */
    private function  durableToken(){
        $isavable = $this->checkTimeOut();
        if ($isavable || !xcache_isset("token")){
            $isget = $this->getAccessTokenFromWx();
            if ($isget){
                xcache_set("token",$isget);
                xcache_set("time",date("Y-m-d H:i:s"));
                return $isget;
            }else{
                return;
            }
        }else{
            return xcache_get("token");
        }
    }

    /**
     * 时间校验，是否是超过一小时
     * @return bool
     */
    private function checkTimeOut(){
        error_log("123",3,dirname(__FILE__)."/../log/klj.log");

        $now = date_create(xcache_get("time"));
        $old = date_create(date("Y-m-d H:i:s"));
        $diff = date_diff($old,$now);

        $hour = $diff->h;
        if ($hour == 1 || $hour > 1 || $diff->d != 0 || $diff->m != 0){
            return true;
        }else{
            return false;
        }
    }



}