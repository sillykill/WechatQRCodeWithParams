<?php

class GlobalData
{
    /**
     * globalData 说明.
     * <ul>
     *    <li>servername：SQl服务器所在IP地址</li>
     *    <li>username：SQL服务登入账号</li>
     *    <li>password：SQL服务登入密码</li>
     *    <li>dbname：SQL服务 应用所在数据库</li>
     *
     *    <li>appid：微信公众号appid</li>
     *    <li>secret：微信公众号秘钥</li>
     *
     *    <li>access_token_url：微信平台API -- 获取token</li>
     *    <li>grant_type：获取token所需参数</li>
     * </ul>
     */

    const servername = "47.106.147.209";
    const username = "root";
    const password = "123456";
    const dbname = "wx";


    const appid = "wx2f0d38c79d3b2976";
    const secret = "d3848058a3228ec4d6781853e01e65ce";


    const access_token_url = "https://api.weixin.qq.com/cgi-bin/token";
    const grant_type = "client_credential";


    const qrcode_url = "https://api.weixin.qq.com/cgi-bin/qrcode/create";
    const qrcode_ticket = "https://mp.weixin.qq.com/cgi-bin/showqrcode";
    const opendate_url = "https://api.weixin.qq.com/cgi-bin/user/info";

}


