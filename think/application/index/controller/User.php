<?php

namespace app\index\controller;

use think\Controller;
use app\index\service\userService;

/**
 * 用户信息管理入口
 * Class User
 * @package app\index\controller
 */
class User extends Controller
{

  //获取用户openid
  public function getUserOpenid()
  {
    //接受code参数并验证参数
    $code = $this->request->get('code');
    $result = $this->validate(
      ['code' => $code], ['code' => 'require|max:32']
    );
    if (true !== $result) {
      // 验证失败 输出错误信息
      return json(['data'=>$result,'code'=>STATUS_FAIL,'message'=>STATUS_FAIL_MESSAGE]);
    }
    //请求微信接口获取openid
    $loginResult = userService::userLogin($code);
    if(empty($loginResult)){
      return json(['data'=>$loginResult,'code'=>STATUS_FAIL,'message'=>STATUS_FAIL_MESSAGE]);
    }else{
      return json(['data'=>$loginResult,'code'=>STATUS_SUCCESS,'message'=>STATUS_SUCCESS_MESSAGE]);
    }
  }
}
