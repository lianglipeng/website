<?php

namespace app\index\service;
use app\index\model\User as userModel;

/**
 * 用户信息管理类
 * Class userService
 */
class   userService
{
  /**
   * 用户登陆/注册
   * @param string $code 微信小程序code
   */
  public static function userLogin($code = '')
  {
    //请求微信接口获取openid
    $openidData = weiXinApiService::getUserOpenid($code);
    //判断用户是否存在
    if(empty($openidData)){
      return false;
    }
    //记录数据
    $userInfo = userModel::getUserInfoByOpenid($openidData['openid']);
    if(empty($userInfo)){
      $user = userModel::createUser($openidData['openid'], $openidData['session_key'], $openidData['expires_in']);
    }else{
      $user = userModel::updateUser($openidData['openid'], $openidData['session_key'], $openidData['expires_in']);
    }
    //返回数据
    if(empty($user)){
      return false;
    }else{
      return $openidData['openid'];
    }
  }
}
