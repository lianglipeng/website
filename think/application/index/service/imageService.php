<?php

namespace app\index\service;

/**
 * 图片生成管理类
 * Class userService
 */
class   imageService
{
  public static $imageSaveName = '';//图片保存名称
  public static $font =FONT_PATH . 'hailang.ttf';//默认字体

  /**
   * 生成图片存储的名称
   * @param $openid
   */
  private static function makeImageSaveName($openid)
  {
    self::$imageSaveName = $openid.time().rand(1,99999);
  }

  /**
   *
   * @param string $imgSourceUrl 来源图片url地址
   */
  /**
   * 生成图片
   * @param $openid               用户opened
   * @param string $imgSourceUrl  图片源地址
   * @param string $text          文字
   * @param int $width            画布宽度
   * @param int $height           画布高度
   * @param int $red              字体颜色
   * @param int $green            字体颜色
   * @param int $blue             字体颜色
   * @return string
   */
  public static function createImage($openid, $imgSourceUrl = '', $text = '', $width = 400, $height = 600, $red = 0, $green = 0, $blue = 0)
  {
    if (empty($imgSourceUrl)) {
      //创建画布方法一：空白的画布
      $myImage = ImageCreate($width, $height); //参数为宽度和高度
    } else {
      //创建画布方法二：选择一张图片
      $myImage = imagecreatefromjpeg($imgSourceUrl);
    }
    if (!empty($text)) {
      //设定文字颜色变量
      $fontColor = ImageColorAllocate($myImage, $red, $green, $blue);
      //设置字体路径
      $font = self::$font;
      //写入文字
      imagettftext($myImage, 12, 0, 5, 20, $fontColor, $font, $text);
    }
    //生成图片存储的名称
    self::makeImageSaveName($openid);
    //生成图片
    list($dst_w, $dst_h, $dst_type) = getimagesize($imgSourceUrl);
    switch ($dst_type) {
      case 1://GIF
        $imgType = '.gif';
        imagegif($myImage, IMG_SAVE_PATH.self::$imageSaveName.'.gif');
        break;
      case 2://JPG
        $imgType = '.jpg';
        imagejpeg($myImage, IMG_SAVE_PATH.self::$imageSaveName.'.jpg');
        break;
      case 3://PNG
        $imgType = '.png';
        imagepng($myImage, IMG_SAVE_PATH.self::$imageSaveName.'.png');
        break;
      default:
        return false;
        break;
    }
    //销毁图片对象
    ImageDestroy($myImage);
    //返回图片名称
    return self::$imageSaveName.$imgType;
  }

  public static function imageAddWaterMark($openid, $imgUrl = '',$waterMarkImgUrl='',$text='', $red = 0, $green = 0, $blue = 0){
    /*
      步骤：
      1.分别创建大小图画布并获取它们的宽高
      2.添加文字水印
      3.执行图片水印处理
      4.输出
      5.销毁画布
    */
    //1.分别创建大小图画布并获取它们的宽高
    //https://www.zhutibaba.com/demo/zimeiti1/wp-content/uploads/sites/3/2018/07/28-6-574x321.jpeg
    //大图
    $bigPath = $imgUrl;
    $big = imagecreatefromjpeg($bigPath);
    $bx = imagesx($big);
    $by = imagesy($big);
    //小图
    $small = imagecreatefrompng($waterMarkImgUrl);
    $sx = imagesx($small);
    $sy = imagesy($small);
    //添加水印文字
    if (!empty($text)) {
      //设定文字颜色变量
      $fontColor = ImageColorAllocate($big, $red, $green, $blue);
      //设置字体路径
      $font = self::$font;
      //写入文字
      imagettftext($big, 12, 0, 5, 20, $fontColor, $font, $text);
    }
    //3.执行图片水印处理
    imagecopymerge($big, $small, $bx - $sx, 0, 0, 0, $sx, $sy, 37);
    imagecopymerge($big, $small, 0, $by - $sy, 0, 0, $sx, $sy, 100);
    //4.生成图片存储的名称
    self::makeImageSaveName($openid);
    list($dst_w, $dst_h, $dst_type) = getimagesize($imgUrl);
    switch ($dst_type) {
      case 1://GIF
        $imgType = '.gif';
        imagegif($big, IMG_SAVE_PATH.self::$imageSaveName.'.gif');
        break;
      case 2://JPG
        $imgType = '.jpg';
        imagejpeg($big, IMG_SAVE_PATH.self::$imageSaveName.'.jpg');
        break;
      case 3://PNG
        $imgType = '.png';
        imagepng($big, IMG_SAVE_PATH.self::$imageSaveName.'.png');
        break;
      default:
        return false;
        break;
    }
    //5.销毁画布
    imagedestroy($big);
    imagedestroy($small);
    //返回图片名称
    return self::$imageSaveName.$imgType;
  }
}
