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
  public static function select ($columns = ['*'], $conditions = '', $suffix = '') {
    return dbs::select(static::$tableName, $columns, $conditions, 'and', $suffix);
  }

  public static function row ($columns = ['*'], $conditions = '', $suffix = '') {
    return dbs::row(static::$tableName, $columns, $conditions, 'and', $suffix);
  }

  // max, min
  public static function max ($fieldName, $conditions = '') {
    return dbs::func(static::$tableName, 'max', $fieldName, $conditions);
  }
  public static function min ($fieldName, $conditions = '') {
    return dbs::func(static::$tableName, 'min', $fieldName, $conditions);
  }

  /**
   * 详细的查询功能，不提示
   */

  public static function gets () {
    return static::select();
  }

  public static function getsColumns ($columns) {
    return static::select($columns);
  }

  public static function getsBy ($conditions) {
    return static::select(['*'], $conditions);
  }

  public static function getsColumnsBy ($columns, $conditions) {
    return static::select($columns, $conditions);
  }

  public static function getsBySuff ($conditions, $suffix = '') {
    return static::select(['*'], $conditions, $suffix);
  }

  public static function getsColumnsBySuff ($columns, $conditions, $suffix = '') {
    return static::select($columns, $conditions, $suffix);
  }

  public static function getBy ($conditions) {
    return static::row(['*'], $conditions);
  }

  public static function getById ($id) {
    return static::row(['*'], compact('id'));
  }

  public static function getByUid ($uid) {
    return static::row(['*'], compact('uid'));
  }

  public static function getColumnsBy ($columns, $conditions) {
    return static::row($columns, $conditions);
  }

  public static function getColumnsById ($columns, $id) {
    return static::row($columns, compact('id'));
  }

  public static function getColumnsByUid ($columns, $uid) {
    return static::row($columns, compact('uid'));
  }

  /**
   * 数据查询检测，自定义提示信息
   */

  public static function checksCustom ($message) {
    $res = static::gets();
    if ( count($res) === 0 ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
    return $res;
  }

  public static function checksByCustom ($conditions, $message) {
    $res = static::getsBy($conditions);
    if ( count($res) === 0 ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
    return $res;
  }

  public static function checksColumnsByCustom ($columns, $conditions, $message) {
    $res = static::getsColumnsBy($columns, $conditions);
    if ( count($res) === 0 ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
    return $res;
  }

  public static function checkByCustom ($conditions, $message) {
    $res = static::getBy($conditions);
    if ( $res === null ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
    return $res;
  }

  public static function checkByIdCustom ($id, $message) {
    $res = static::getById($id);
    if ( $res === null ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
    return $res;
  }

  public static function checkByUidCustom ($uid, $message) {
    $res = static::getByUid($uid);
    if ( $res === null ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
    return $res;
  }

  public static function checkColumnsByIdCustom ($columns, $id, $message) {
    $res = static::getColumnsById($columns, $id);
    if ( $res === null ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
    return $res;
  }

  public static function checkColumnsByUidCustom ($columns, $uid, $message) {
    $res = static::getColumnsByUid($columns, $uid);
    if ( $res === null ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
    return $res;
  }

  // 检测数据，默认提示
  public static function checks () {
    return static::checksCustom('没有找到数据集合');
  }
  public static function checksBy ($conditions) {
    return static::checksByCustom($conditions, '没有找到条件对应数据');
  }
  public static function checksColumnsBy ($columns, $conditions) {
    return static::checksColumnsByCustom($columns, $conditions, '没有找到条件对应字段');
  }
  public static function checkBy ($conditions) {
    return static::checkByCustom($conditions, '没有找到条件对应记录');
  }
  public static function checkById ($id) {
    return static::checkByIdCustom($id, '没有找到编号对应记录');
  }
  public static function checkByUid ($uid) {
    return static::checkByUidCustom($uid, '没有找到序列号对应记录');
  }
  public static function checkColumnsById ($columns, $id) {
    return static::checkColumnsByIdCustom($columns, $id, '没有找到编号对应记录字段');
  }
  public static function checkColumnsByUid ($columns, $uid) {
    return static::checkColumnsByUidCustom($columns, $uid, '没有找到序列号对应记录字段');
  }


  /**
   * 数据查询检测，自定义提示信息
   */

  public static function existsCustom ($message) {
    $res = static::gets();
    if ( count($res) !== 0 ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
  }

  public static function existsByCustom ($conditions, $message) {
    $res = static::getsBy($conditions);
    if ( count($res) !== 0 ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
  }

  public static function existsColumnsByCustom ($columns, $conditions, $message) {
    $res = static::getsColumnsBy($columns, $conditions);
    if ( count($res) !== 0 ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
  }

  public static function existByCustom ($conditions, $message) {
    $res = static::getBy($conditions);
    if ( $res !== null ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
  }

  public static function existByIdCustom ($id, $message) {
    $res = static::getById($id);
    if ( $res !== null ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
  }

  public static function existByUidCustom ($uid, $message) {
    $res = static::getByUid($uid);
    if ( $res !== null ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
  }

  public static function existColumnsByIdCustom ($columns, $id, $message) {
    $res = static::getColumnsById($columns, $id);
    if ( $res !== null ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
  }

  public static function existColumnsByUidCustom ($columns, $uid, $message) {
    $res = static::getColumnsByUid($columns, $uid);
    if ( $res !== null ) {
      throw new Exception(static::$tableTitle . '：' . $message);
    }
  }


  // 检测数据，默认提示
  public static function exists () {
    static::existsCustom('数据集合已存在');
  }
  public static function existsBy ($conditions) {
    static::existsByCustom($conditions, '条件对应数据已存在');
  }
  public static function existsColumnsBy ($columns, $conditions) {
    static::existsColumnsByCustom($columns, $conditions, '条件对应字段已存在');
  }
  public static function existBy ($conditions) {
    static::existByCustom($conditions, '条件对应记录已存在');
  }
  public static function existById ($id) {
    static::existByIdCustom($id, '编号对应记录已存在');
  }
  public static function existByUid ($uid) {
    static::existByUidCustom($uid, '序列号对应记录已存在');
  }
  public static function existColumnsById ($columns, $id) {
    static::existColumnsByIdCustom($columns, $id, '编号对应记录字段已存在');
  }
  public static function existColumnsByUid ($columns, $uid) {
    static::existColumnsByUidCustom($columns, $uid, '序列号对应记录字段已存在');
  }

  /**
   * 模糊查询
   */

  public static function like ($columns = ['*'], $conditions = '', $likes, $like_opt = 'or', $suffix = '') {
    return dbs::like(static::$tableName, $columns, $conditions, $likes, $like_opt, $suffix);
  }

  public static function likes ($likes) {
    return static::like(['*'], '', $likes, 'and');
  }

  public static function likesor ($likes) {
    return static::like(['*'], '', $likes, 'or');
  }

  public static function likesBy ($conditions, $likes) {
    return static::like(['*'], $conditions, $likes, 'and');
  }

  public static function likesByor ($conditons, $likes) {
    return static::like(['*'], $conditons, $likes, 'or');
  }

  public static function likesBySuff ($conditions, $likes, $suffix) {
    return static::like(['*'], $conditions, $likes, 'and', $suffix);
  }

  public static function likesBySuffor ($conditions, $likes, $suffix) {
    return static::like(['*'], $conditions, $likes, 'or', $suffix);
  }

  public static function likesColumnsBy ($columns, $conditions, $likes) {
    return static::like($columns, $conditions, $likes, 'and');
  }

  public static function likesColumnsByor ($columns, $conditions, $likes) {
    return static::like($columns, $conditions, $likes, 'or');
  }

  public static function likesColumnsBySuff ($columns, $conditions, $likes, $suffix) {
    return static::like($columns, $conditions, $likes, 'and', $suffix);
  }

  public static function likesColumnsBySuffor ($columns, $conditions, $likes, $suffix) {
    return static::like($columns, $conditions, $likes, 'or', $suffix);
  }

  /**
   * 自定义查询
   */
  public static function custom ($columns = ['*'], $conditions, $customs, $customs_condition, $customs_opt = 'and', $suffix = '') {
    return dbs::custom(static::$tableName, $columns, $conditions, $customs, $customs_condition, $customs_opt, $suffix);
  }

  public static function customs ($customs, $customs_condition) {
    return static::custom(['*'], '', $customs, $customs_condition);
  }

  public static function customsBy ($conditions, $customs, $customs_condition) {
    return static::custom(['*'], $conditions, $customs, $customs_condition);
  }

}
