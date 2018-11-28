<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonChild extends cAppinfo
{
  protected static $tableName = 'xonChild';
  protected static $tableTitle = '孩子表';
}
