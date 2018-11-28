<?php
namespace QCloud_WeApp_SDK\Mvv;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonChild;
use QCloud_WeApp_SDK\Model\xonGrade;
use QCloud_WeApp_SDK\Model\xonGradeStudChange;
use QCloud_WeApp_SDK\Model\xonStudent;
use QCloud_WeApp_SDK\Model\xonStudStatus;
use QCloud_WeApp_SDK\Model\xonStudType;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStud;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class mvvChild
{
  public static function add ($idc, $name) {
    $id = $idc;
    // 检测身份证
    x5on::checkIdc($idc, 7, 18);
    $res = self::getById($id);
    if ( $res === null ) {
      // 添加孩子
      $uid = x5on::getUid();
      self::insert(compact('id', 'uid', 'idc', 'name'));
    }
  }
}
