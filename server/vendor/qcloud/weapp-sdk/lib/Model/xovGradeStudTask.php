<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovGradeStudTask extends vAppinfo
{
  protected static $tableName = 'xovGradeStudTask';
  protected static $tableTitle = '学生变更任务视图';
}