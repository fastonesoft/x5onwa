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
   * 数据查询检测
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

  public static function checks () {
    return static::checksCustom('没有找到数据集合');
  }
  public static function checksBy ($conditions) {
    return static::checksByCustom($conditions, '没有找到条件对应数据');
  }
  public static function checksColumnsBy ($columns, $conditions) {
    return static::checksColumnsByCustom($columns, $conditions, '没有找到条件对应字段');
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
   * 模糊查询
   */

  public static function like ($columns = ['*'], $conditions = '', $likes = '', $suffix = '', $like_opt = 'or') {
    return dbs::like(static::$tableName, $columns, $conditions, $likes, $suffix, $like_opt);
  }

  public static function likes ($likes) {
    return static::like(['*'], '', $likes);
  }

  public static function likesBy ($conditions, $likes) {
    return static::like(['*'], $conditions, $likes);
  }

  public static function likesByor ($conditons, $likes) {
    return static::like(['*'], $conditons, $likes, '', 'or');
  }

  public static function likesByNum ($conditions, $likes, $suffix) {
    return static::like(['*'], $conditions, $likes, $suffix);
  }

  public static function likesByNumor ($conditions, $likes, $suffix) {
    return static::like(['*'], $conditions, $likes, $suffix, 'or');
  }

  public static function likesColumnsBy ($columns, $conditions, $likes) {
    return static::like($columns, $conditions, $likes);
  }

  public static function likesColumnsByor ($columns, $conditions, $likes) {
    return static::like($columns, $conditions, $likes, '', 'or');
  }

  public static function likesColumnsByNum ($columns, $conditions, $likes, $suffix) {
    return static::like($columns, $conditions, $likes, $suffix);
  }

  public static function likesColumnsByNumor ($columns, $conditions, $likes, $suffix) {
    return static::like($columns, $conditions, $likes, $suffix, 'or');
  }

}
