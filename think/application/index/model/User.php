<?php

namespace app\index\model;

use think\Model;

/**
 * 用户数据管理类
 */
class User Extends Model
{
  // 数据表名称
  protected $tableName = 'user';
  /**
   * 记录用户信息
   * @param $openId         用户openid
   * @param $sessionKey     会话密钥
   * @param $expiresIn      会话密钥过期时间
   */
  public static function createUser($openId, $sessionKey, $expiresIn)
  {
    //判断用户是否存在
    $user = self::get(['openid' => $openId]);
    if ($user) {
      //返回数据
      return false;
    } else {
      //新增用户信息
      $userId = self::insertGetId(
        [
          'openid' => $openId,
          'session_key' => $sessionKey,
          'expires_in' => $expiresIn + time(),
          'create_time' => time()
        ]);
    }
    //返回数据
    return $userId;
  }

  /**
   * 更新用户信息
   * @param int $userId 会员ID
   */
  public static function updateUser($openId, $sessionKey, $expiresIn)
  {
    //判断用户是否存在
    $user = self::get(['openid' => $openId]);
    $res=false;
    if ($user) {
      //更新用户信息
      $res = User::update(
        [
          'session_key' => $sessionKey,
          'expires_in' => $expiresIn + time(),
          'update_time' => time()
        ],
        [
          'openid' => $openId
        ]
      );
    }
    //返回数据
    return $res;
  }

  /**
   * 获取用户信息
   * @param int $openId 会员openid
   */
  public static function getUserInfoByOpenid($openId)
  {
    //定义结果集变量
    $data = [];
    // 使用数组查询
    $user = self::get(['openid' => $openId]);
    if($user){
      $data = $user->toArray();
    }
    return $data;
  }
}
