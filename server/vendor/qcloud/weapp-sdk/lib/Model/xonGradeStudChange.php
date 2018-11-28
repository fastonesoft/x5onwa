<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonGradeStudChange extends cAppinfo
{
  protected static $tableName = 'xonGradeStudChange';
  protected static $tableTitle = '年度学生调动';

  public static function add ($grade_id, $cls_id, $stud_id, $stud_status_id, $change_date, $memo) {
    $has_done = 0;
    $year_id =

  }

}