<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class cAppinfo extends vAppinfo
{
  private static $tableName = 'cAppinfo';
  private static $tableTitle = '应用基本信息';

  /**
   * 修改数据，只适用于表操作
   */
  /**
   * @param             $data           compact的数据
   * @return int
   * @throws Exception
   */
  public static function insert ($data) {
    return dbs::insert(static::$tableName, $data);
  }

  /**
   * @param             $columns        compact的数据
   * @param             $conditions     compact的条件
   * @return            number          受影响的数据条数
   * @throws Exception
   */
  public static function update ($columns, $conditions) {
    return dbs::update(static::$tableName, $columns, $conditions);
  }

  public static function setsById ($columns, $id) {
    return static::update($columns, compact('id'));
  }

  public static function setsByUid ($columns, $uid) {
    return static::update($columns, compact('uid'));
  }

  /**
   * @param             $conditions     compact的条件
   * @return            number          受影响的数据条数
   * @throws Exception
   */
  public static function delete ($conditions) {
    return dbs::delete(static::$tableName, $conditions);
  }

  public static function delById ($id) {
    return static::delete(compact('id'));
  }

  public static function delByUid ($uid) {
    return static::delete(compact('uid'));
  }

}
