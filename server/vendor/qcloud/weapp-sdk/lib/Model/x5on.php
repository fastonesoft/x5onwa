<?php
namespace QCloud_WeApp_SDK\Model;


class x5on {
  // 系统管理员组编号
  const GROUP_ADMIN_VALUE = 99;
  // 学校管理员
  const GROUP_SCHOOL_ADMIN_VALUE = 8;
  // 学生家长
  const GROUP_STUDENT_PARENT = 2;
  // 临时用户组编号
  const GROUP_TEMP_USER = 1;

  // 用户信息设置
  const USER_SET_MYSELF = 'user-set-myself';

  // 给数组元素添加编号
  public static function addIndex($arr) {
    $index = 0;
    foreach ($arr as $value) {
      $value->index = $index++;
    }
    return $arr;
  }

  public static function checkIdc($idc) {

    // 只能是18位
    if(strlen($idc)!=18){
      return false;
    }

    // 取出本体码
    $idcard_base = substr($idc, 0, 17);

    // 取出校验码
    $verify_code = substr($idc, 17, 1);

    // 加权因子
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

    // 校验码对应值
    $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

    // 根据前17位计算校验码
    $total = 0;
    for($i=0; $i<17; $i++){
      $total += substr($idcard_base, $i, 1)*$factor[$i];
    }

    // 取模
    $mod = $total % 11;

    // 比较校验码
    if($verify_code == $verify_code_list[$mod]){
      return true;
    }else{
      return false;
    }
  }
}