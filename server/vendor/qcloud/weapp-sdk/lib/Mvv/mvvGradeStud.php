<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonChild;
use QCloud_WeApp_SDK\Model\xonGrade;
use QCloud_WeApp_SDK\Model\xonGradeStud;
use QCloud_WeApp_SDK\Model\xonGradeStudTask;
use QCloud_WeApp_SDK\Model\xonStudent;
use QCloud_WeApp_SDK\Model\xonStudStatus;
use QCloud_WeApp_SDK\Model\xonStudType;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStud;
use \Exception;
use QCloud_WeApp_SDK\Model\xovGradeStudTask;

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
      // 当前年度的在校生（往届生用别的方法查询）
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
  public static function studModi ($uid, $idc, $name, $stud_type_id, $stud_status_id) {
    $stud = xovGradeStud::checkByUid($uid);
    $id = $stud->stud_idc;
    xonChild::update(compact('idc', 'name'), compact('id'));
    xonGradeStud::update(compact('stud_type_id', 'stud_status_id'), compact('uid'));
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

  /**
   * 作为任务管理的统一添加方法
   * @param $grade_stud_id
   * @param $task_status_id
   * @param $has_done
   * @param $task_memo
   * @return array
   * @throws Exception
   */

  public static function taskDown ($grade_stud_id, $task_status_id, $task_memo) {
    $has_done = 0;
    // 添加任务记录
    xonGradeStudTask::add($grade_stud_id, $task_status_id, $has_done, $task_memo);
    // 变更学生信息
    $id = $grade_stud_id;
    $stud_status_id = $task_status_id;
    xonGradeStud::update(compact('stud_status_id'), compact('id'));
    return xovGradeStud::getsBy(compact('id'));
  }

  public static function taskTemp ($id, $uid, $task_memo) {
    // 临时离校记录
    $res = xonGradeStud::checkBy(compact('id', 'uid'));
    // 记录
    $has_done = 0;
    $task_status_id = $res->stud_status_id;  // 原始学籍状态
    // 添加记录
    xonGradeStudTask::add($id, $task_status_id, $has_done, $task_memo);
    // 变更
    $stud_status_id = x5on::STATUS_TEMP;
    xonGradeStud::update(compact('stud_status_id'), compact('id'));
    return xovGradeStud::getsBy(compact('id'));
  }

  public static function taskOutLeave ($id, $uid, $task_memo) {
    // 转出、离校记录
    $res = xonGradeStud::checkBy(compact('id', 'uid'));
    // 记录
    $has_done = 1;
    $task_status_id = $res->stud_status_id;  // 原始学籍状态
    // 添加记录
    xonGradeStudTask::add($id, $task_status_id, $has_done, $task_memo);
    // 变更
    $stud_status_id = x5on::STATUS_TEMP;
    xonGradeStud::update(compact('stud_status_id'), compact('id'));
    return xovGradeStud::getsBy(compact('id'));
  }

  public static function gradesDown ($id) {
    // 休学年级查询
    return xovGradeCurrent::customsSuff(compact('id'), '>', 'limit 1');
  }

  public static function studReturn ($uid, $grade_id, $cls_id) {
    // 复学设置
    $has_done = 1;
    $task = xovGradeStudTask::checkByUid($uid);
    xonGradeStudTask::update(compact('has_done'), compact('uid'));

    $stud_id = $task->stud_id;
    $stud_type_id = $task->stud_type_id;
    $stud_status_id = x5on::STATUS_RETURN;
    $stud_auth = $task->stud_auth;
    $same_group = 0;
    $stud_code = $task->stud_code;
    $stud_diploma = $task->stud_diploma;

    $id = xonGradeStud::add($grade_id, $cls_id, $stud_id, $stud_type_id, $stud_status_id, $stud_auth, $stud_code, $stud_diploma);
    return xovGradeStud::getsBy(compact('id'));
  }

  public static function studBack ($uid, $cls_id) {
    // 查询、变更
    $has_done = 1;
    $task = xovGradeStudTask::checkByUid($uid);
    xonGradeStudTask::update(compact('has_done'), compact('uid'));

    $id = $task->grade_stud_id;
    $stud_status_id = $task->task_status_id;
    xonGradeStud::update(compact('cls_id', 'stud_status_id'), compact('id'));
    return xovGradeStud::getsBy(compact('id'));
  }

  public static function type () {
    return xonStudType::getsColumns(['id', 'name']);
  }

  public static function status ($in_sch) {
    return xonStudStatus::getsColumnsBy(['id', 'name'], compact('in_sch'));
  }

}
