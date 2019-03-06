<?php
namespace QCloud_WeApp_SDK\Model;

class xonUserChilds extends cAppinfo
{
  protected static $tableName = 'xonUserChilds';
  protected static $tableTitle = '家长孩子';

  public static function add ($user_id, $child_id, $relation_id) {
    $user_child = self::existByCustom(compact('user_id', 'child_id'), '无需重复添加孩子记录');
    $child_relation = self::existByCustom(compact('child_id', 'relation_id'), '同一孩子不能注册多个相同关系');

    $uid = x5on::getUid();
    self::insert(compact('uid', 'user_id', 'child_id', 'relation_id'));
  }
}
