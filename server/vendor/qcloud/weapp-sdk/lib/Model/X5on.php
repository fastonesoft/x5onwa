<?php
namespace QCloud_WeApp_SDK\Model;


class x5on {
  // 系统管理员组编号
  const GROUP_ADMIN_VALUE = 99;
  // 学校管理员
  const GROUP_SCHOOL_ADMIN_VALUE = 8;
  // 教师组编号
  const GROUP_TEACH_VALUE = 2;
  // 临时用户组编号
  const GROUP_TEMP_USER = 1;

  public static function addIndex($arr) {
    $index = 0;
    foreach ($arr as $value) {
      $value->index = $index++;
    }
    return $arr;
  }
}