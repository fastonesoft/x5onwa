<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class cSessionInfo extends cAppinfo
{
  protected static $tableName = 'cSessionInfo';
  protected static $tableTitle = '会话管理用户信息';
}