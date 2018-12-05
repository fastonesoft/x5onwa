<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonChild;
use QCloud_WeApp_SDK\Model\xonGrade;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xonStudent;
use QCloud_WeApp_SDK\Model\xonStudStatus;
use QCloud_WeApp_SDK\Model\xonStudType;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStud;
use \Exception;

class mvvGradeStud
{
  public static function grades () {
    return xovGradeCurrent::gets();
  }

  /**
   * 根据年级查询班级列表
   * @param $grade_id           年级编号
   * @return array
   */
  public static function classes ($grade_id) {
    return xovClass::getsBy(compact('grade_id'));
  }

  /**
   * 根据年级、班级查询学生
   * @param $grade_id           年级编号
   * @param $cls_id             班级编号
   * @return array
   */
  public static function studCls ($grade_id, $cls_id) {
    if ($grade_id && $cls_id) {
      return xovGradeStud::getsBy(compact('grade_id', 'cls_id'));
    } else {
      return [];
    }
  }

  /**
   * 根据学生序号查询学生信息
   * @param $uid                学生序号
   * @return array
   */
  public static function studByUid ($uid) {
    if ($uid) {
      return xovGradeStud::getBy(compact('uid'));
    } else {
      return null;
    }
  }

  /**
   * 根据年级、班级、学生姓名部分模糊查询
   * @param $grade_id           年级编号
   * @param $cls_id             班级编号
   * @param $stud_name          学生姓名
   * @return array
   */
  public static function query ($grade_id, $cls_id, $stud_name) {
    if ($grade_id && $cls_id) {
      return xovGradeStud::likesBy(compact('grade_id', 'cls_id'), compact('stud_name'));
    } elseif ($grade_id) {
      return xovGradeStud::likesBy(compact('grade_id'), compact('stud_name'));
    } else {
      $current_year = 1;
      return xovGradeStud::likesBy(compact('current_year'), compact('stud_name'));
    }
  }

  public static function addNoExam ($grade_id, $cls_id, $stud_name, $stud_idc, $stud_type_id, $stud_status_id, $stud_auth, $come_date) {
    // 添加孩子表
    xonChild::add($stud_idc, $stud_name);
    // 通过grade_id找出step_id，并添加录取学生表
    $grade = xonGrade::getById($grade_id);
    $step_id = $grade->step_id;
    $stud_id = xonStudent::add($stud_idc, $step_id, $come_date);
    // 添加年度学生
    $uid = xonGradeStud::add($grade_id, $cls_id, $stud_id, $stud_type_id, $stud_status_id, $stud_auth);
    return xovGradeStud::getsBy(compact('uid'));
  }

  public static function type () {
    return xonStudType::getsColumns(['id', 'name']);
  }

  public static function status ($in_sch) {
    return xonStudStatus::getsColumnsBy(['id', 'name'], compact('in_sch'));
  }

}
