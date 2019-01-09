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
      // 当前年度的在校生
      $in_sch = 1;
      $current_year = 1;
      return xovGradeStud::getsBySuff(compact('grade_id', 'cls_id', 'in_sch', 'current_year'), 'order by grade_id, cls_num, stud_status_id, stud_sex_num, stud_id');
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
   * 根据学生序号更新学生班级，完成调动
   * @param $uid                学生序号
   * @param $cls_id             目标班级
   * @throws Exception
   */
  public static function studMove ($uid, $cls_id) {
    xovGradeStud::checkByUid($uid);
    xonGradeStud::update(compact('cls_id'), compact('uid'));
    return xovGradeStud::getsBy(compact('uid'));
  }

  /**
   * 修改学生信息（身份证号、姓名）
   * @param $uid              学生序号
   * @param $idc              身份证号
   * @param $name             学生姓名
   */
  public static function studModi ($uid, $idc, $name) {
    $stud = xovGradeStud::checkByUid($uid);
    $id = $stud->stud_idc;
    xonChild::update(compact('idc', 'name'), compact('id'));
    return xovGradeStud::getsby(compact('uid'));
  }

  /**
   * 指标生变更
   * @param $uid              学生序号
   * @param $stud_auth        指标标志（只接收0、1）
   */
  public static function studAuth ($uid, $stud_auth) {
    xovGradeStud::checkByUid($uid);
    xonGradeStud::update(compact('stud_auth'), compact('uid'));
    return xovGradeStud::getsBy(compact('uid'));
  }


  /**
   * 根据年级、班级、学生姓名部分模糊查询
   * @param $grade_id           年级编号
   * @param $cls_id             班级编号
   * @param $stud_name          学生姓名
   * @return array
   */
  public static function query ($grade_id, $cls_id, $stud_name) {
    $in_sch = 1;
    $current_year = 1;
    if ($grade_id && $cls_id) {
      return xovGradeStud::likesBySuff(compact('grade_id', 'cls_id', 'in_sch', 'current_year'), compact('stud_name'), 'order by grade_id, cls_num, stud_status_id, stud_sex_num, stud_id');
    } elseif ($grade_id) {
      return xovGradeStud::likesBySuff(compact('grade_id', 'in_sch', 'current_year'), compact('stud_name'), 'order by grade_id, cls_num, stud_status_id, stud_sex_num, stud_id');
    } else {
      return xovGradeStud::likesBySuff(compact('current_year', 'in_sch'), compact('stud_name'), 'order by grade_id, cls_num, stud_status_id, stud_sex_num, stud_id');
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
