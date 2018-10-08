<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovGradeCurrent extends vAppinfo
{
  protected static $tableName = 'xovGradeCurrent';
  protected static $tableTitle = '当前年级';

  public static function getRows () {
    return dbs::select('xovGradeCurrent', ['id', 'name']);
  }

}
