<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovStudent extends vAppinfo
{
  protected static $tableName = 'xovStudent';
  protected static $tableTitle = '学生查询';

}
