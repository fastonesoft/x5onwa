<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class vAppinfo
{
  private static $tableName = 'vAppinfo';
  private static $tableTitle = '应用基本信息';

  /**
   * 查询多行数据
   * @param array             $columns      查询列名数组
   * @param array             $conditions   查询条件
   * @param string            $suffix       查询后缀 order, limit 等
   * @return array
   * @throws Exception
   */
  public static function select ($columns = ['*'], $conditions, $suffix = '') {
    if ( gettype($columns) !== 'array' || gettype($conditions) !== 'array' ) {
      throw new Exception(Constants::E_CALL_FUNCTION_PARAM);
    }
    return dbs::select(static::$tableName, $columns, $conditions, 'and', $suffix);
  }

  public static function row ($columns = ['*'], $conditions, $suffix = '') {
    if ( gettype($columns) !== 'array' || gettype($conditions) !== 'array' ) {
      throw new Exception(Constants::E_CALL_FUNCTION_PARAM);
    }
    return dbs::row(static::$tableName, $columns, $conditions, 'and', $suffix);
  }

  public static function like ($columns = ['*'], $conditions, $likes, $suffix = '', $opt = 'and', $like_opt = 'or') {
    if ( gettype($columns) !== 'array' || gettype($conditions) !== 'array' || gettype($likes) !== 'array' ) {
      throw new Exception(Constants::E_CALL_FUNCTION_PARAM);
    }
    return dbs::like(static::$tableName, $columns, $conditions, $likes, $suffix, $opt, $like_opt);
  }

  /**
   * 详细的查询功能
   */

  public static function gets () {
    return static::select();
  }

  public static function getsBy ($conditions) {
    return static::select(['*'], $conditions);
  }

  public static function getsColumnsBy ($columns, $conditions) {
    return static::select($columns, $conditions);
  }

  public static function getsByNum ($conditions, $suffix = '') {
    return static::select(['*'], $conditions, $suffix);
  }

  public static function getsColumnsByNum ($columns, $conditions, $suffix = '') {
    return static::select($columns, $conditions, $suffix);
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

  /**
   * 数据查询检测
   */

  public static function checks () {
    $res = static::gets();
    if ( count($res) === 0 ) {
      throw new Exception(static::$tableTitle . '：没有找到数据集合');
    }
    return $res;
  }

  public static function checksBy ($conditions) {
    $res = static::getsBy($conditions);
    if ( count($res) === 0 ) {
      throw new Exception(static::$tableTitle . '：没有找到条件对应数据');
    }
    return $res;
  }

  public static function checksColumnsBy ($columns, $conditions) {
    $res = static::getsColumnsBy($columns, $conditions);
    if ( count($res) === 0 ) {
      throw new Exception(static::$tableTitle . '：没有找到条件对应字段');
    }
    return $res;
  }

  public static function checkById ($id) {
    $res = static::getById($id);
    if ( $res === null ) {
      throw new Exception(static::$tableTitle . '：没有找到编号对应记录');
    }
    return $res;
  }

  public static function checkByUid ($uid) {
    $res = static::getByUid($uid);
    if ( $res === null ) {
      throw new Exception(static::$tableTitle . '：没有找到序列号对应记录');
    }
    return $res;
  }

  public static function checkColumnsById ($columns, $id) {
    $res = static::getColumnsById($columns, $id);
    if ( $res === null ) {
      throw new Exception(static::$tableTitle . '：没有找到编号对应记录字段');
    }
    return $res;
  }

  public static function checkColumnsByUid ($uid) {
    $res = static::getColumnsByUid($columns, $uid);
    if ( $res === null ) {
      throw new Exception(static::$tableTitle . '：没有找到序列号对应记录字段');
    }
    return $res;
  }

}
