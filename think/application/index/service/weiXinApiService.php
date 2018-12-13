<?php

namespace app\index\service;

use GuzzleHttp\Client;
/**
 * 微信接口api综合管理类
 * Class WeixinAPIService
 */
class   weiXinApiService
{
  /**
   * AppID(小程序ID)
   */
  const MINI_WECHAT_APPID = "wx10fb6b2e3bb86e5c";
  /**
   * AppSecret(小程序密钥)
   */
  const MINI_WECHAT_APPSECRET = "4e5a525e6ef2ce83af17fa1a87a3872f";
  /**
   * 小程序获取openid地址
   * GET
   * https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code
   */
  protected static $CODE2SESSION = 'https://api.weixin.qq.com/sns/jscode2session';
  /**
   * 获取微信用户openid信息
   */
  public static function getUserOpenid($code = '')
  {
    //获取curl对象
    $client = new Client(['base_uri' => self::$CODE2SESSION]);
    //发送远程请求
    $response = $client->request('GET', '', [
      'query' => [
        'grant_type' => 'authorization_code',
        'appid' => self::MINI_WECHAT_APPID,
        'secret' => self::MINI_WECHAT_APPSECRET,
        'js_code' => $code
      ]
    ]);
    //申明结果变量
    $data = [];
    //判断请求结果
    if (200 == $response->getStatusCode()) {
      $body = $response->getBody();
      $data = json_decode($body, 1);
      if(!empty($data['errcode'])){
        return [];
      }
    }
    //返回数据
    return $data;
  }
}
