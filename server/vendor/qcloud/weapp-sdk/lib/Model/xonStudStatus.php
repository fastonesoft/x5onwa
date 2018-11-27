<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonStudStatus extends cAppinfo
{
  protected static $tableName = 'xonStudStatus';
  protected static $tableTitle = '学籍状态';
}