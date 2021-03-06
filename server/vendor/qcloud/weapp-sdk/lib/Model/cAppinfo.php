<?php

namespace QCloud_WeApp_SDK\Model;

use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
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
  public static function insert($data)
  {
    return dbs::insert(static::$tableName, $data);
  }

  public static function setsBy($columns, $conditions)
  {
    return dbs::update(static::$tableName, $columns, $conditions);
  }

  public static function setsById($columns, $id)
  {
    return static::setsBy($columns, compact('id'));
  }

  public static function setsByUid($columns, $uid)
  {
    return static::setsBy($columns, compact('uid'));
  }

  /**
   * @param             $conditions     compact的条件
   * @return            number          受影响的数据条数
   * @throws Exception
   */
  public static function delBy($conditions)
  {
    return dbs::delete(static::$tableName, $conditions);
  }

  public static function delById($id)
  {
    return static::delBy(compact('id'));
  }

  public static function delByUid($uid)
  {
    return static::delBy(compact('uid'));
  }

  public static function delByIdCustom($id)
  {
    try {
      return static::delBy(compact('id'));
    } catch (Exception $e) {
      throw new Exception('无法删除，请确认是否存在外键约束');
    }
  }

  public static function delByUidCustom($uid)
  {
    try {
      return static::delBy(compact('uid'));
    } catch (Exception $e) {
      throw new Exception('无法删除，请确认是否存在外键约束');
    }
  }

}
