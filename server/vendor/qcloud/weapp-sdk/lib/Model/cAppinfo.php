<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class cAppinfo
{
  private static $tableName = 'cAppinfo';

  /**
   * 查询多行数据
   * @param array           $columns      查询列名数组
   * @param string          $conditions   查询条件
   * @param string          $suffix       查询后缀 order, limit 等
   * @return array
   * @throws Exception
   */
  public static function select ($columns = ['*'], $conditions = '', $suffix = '') {
    return dbs::select(static::$tableName, $columns, $conditions, 'and', $suffix);
  }

  public static function row ($columns = ['*'], $conditions = '', $suffix = '') {
    return dbs::row(static::$tableName, $columns, $conditions, 'and', $suffix);
  }

  public static function gets () {
    return static::select();
  }

  public static function getsBy ($conditions) {
    return static::select(['*'], $conditions);
  }

  public static function getsColumnsBy ($columns, $conditions) {
    return static::select($columns, $conditions);
  }

  public static function getById ($id) {
    return static::row(['*'], compact('id'));
  }

  public static function getByUid ($uid) {
    return static::row(['*'], compact('uid'));
  }

  public static function getColumnsById ($columns, $id) {
    return static::row($columns, compact('id'));
  }

  public static function getColumnsByUid ($columns, $uid) {
    return static::row($columns, compact('uid'));
  }

}
