<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
  /**
   * 首页
   * @return mixed
   */
  public function index()
  {
    return $this->fetch('index');
  }
  /**
   * 测试页面
   */
  public function llp()
  {
    try {
      $con = new PDO('mysql:host=127.0.0.1;dbname=wechat_online', 'root', 'llpywy$880502');
      $con->query('SET NAMES UTF8');
      $res = $con->query('select * from user limit 100');
      while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        echo "id:{$row['id']} name:{$row['name']}<br>";
      }
    } catch (PDOException $e) {
      var_dump($e);
      die;
      echo '错误原因：' . $e->getMessage();
    }
    $redis = new redis();
    $redis->connect('127.0.0.1');
    $llp = $redis->get('llp');
    var_dump($llp);
    $redis->set('llp', 435);
    $llp = $redis->get('llp');
    var_dump($llp);
    phpinfo();
  }


}
