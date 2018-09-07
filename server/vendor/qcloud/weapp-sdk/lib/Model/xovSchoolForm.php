<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovSchoolForm
{

  public static function getStudRegSchoolForm ($sch_id) {

    // 读取学校报名表格
    $current_year = 1;
    $app_name = 'regstud';

    $sch_reged = true;
    $not_reg = false;
    $not_added = true;
    $forms = dbs::select('xovSchoolForm', ['id', 'name'], compact('sch_id', 'app_name', 'current_year'));
    return compact('not_reg', 'not_added', 'sch_reged', 'forms');
  }



}
