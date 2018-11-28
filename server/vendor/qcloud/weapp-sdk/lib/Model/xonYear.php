<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonYear extends cAppinfo
{
  protected static $tableName = 'xonYear';
  protected static $tableTitle = '年度';
}