<?php

namespace app\index\controller;

use think\Controller;
use app\index\service\imageService;

/**
 * 图片生成管理入口
 * Class User
 * @package app\index\controller
 */
class Image extends Controller
{

  /**
   * 生成图片
   */
  public function createImage()
  {
    //接受参数并验证参数
    $openid = $this->request->get('openid');//用户openid
    $imgSourceUrl = $this->request->get('img_source_url');//原始图片
    $result = $this->validate(
      [
        'openid' => $openid,
        'img_source_url' => $imgSourceUrl

      ],
      [
        'openid' => 'require|max:32',
        'img_source_url' => 'require'

      ],
      [],
      true
    );
    if (true !== $result) {
      // 验证失败 输出错误信息
      return json(['data' => $result, 'code' => STATUS_FAIL, 'message' => STATUS_FAIL_MESSAGE]);
    }
    //生成图片数据
    $imgSaveName = imageService::createImage($openid, $imgSourceUrl);
    //返回数据
    if (empty($imgSaveName)) {
      return json(['data' => $imgSaveName, 'code' => STATUS_FAIL, 'message' => STATUS_FAIL_MESSAGE]);
    } else {
      return json(['data' => $imgSaveName, 'code' => STATUS_SUCCESS, 'message' => STATUS_SUCCESS_MESSAGE]);
    }
  }

  /**
   * 图片添加水印
   */
  public function imageAddWaterMark()
  {
    //接受参数并验证参数
    $openid = $this->request->get('openid');//用户openid
    $imgUrl = $this->request->get('img_url');//原始图片
    $waterMarkImgUrl = $this->request->get('water_mark_img_url');//水印图片

    $result = $this->validate(
      [
        'openid' => $openid,
        'source_img' => $imgUrl,
        'water_mark_img_url' => $waterMarkImgUrl,
      ],
      [
        'openid' => 'require|max:32',
        'source_img' => 'require',
        'water_mark_img_url' => 'require',
      ],
      [],
      true
    );
    if (true !== $result) {
      // 验证失败 输出错误信息
      return json(['data' => $result, 'code' => STATUS_FAIL, 'message' => STATUS_FAIL_MESSAGE]);
    }
    //生成图片数据
    $imgSaveName = imageService::imageAddWaterMark($openid, $imgUrl, $waterMarkImgUrl);
    //返回数据
    if (empty($imgSaveName)) {
      return json(['data' => $imgSaveName, 'code' => STATUS_FAIL, 'message' => STATUS_FAIL_MESSAGE]);
    } else {
      return json(['data' => $imgSaveName, 'code' => STATUS_SUCCESS, 'message' => STATUS_SUCCESS_MESSAGE]);
    }
  }
}
