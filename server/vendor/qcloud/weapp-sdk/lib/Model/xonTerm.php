<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonTerm extends cAppinfo {
  protected static $tableName = 'xonTerm';
  protected static $tableTitle = '学期设置';
}