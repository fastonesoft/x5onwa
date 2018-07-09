<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonStudReg
{

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function schools () {
    return dbs::select('xonSchool', ['id', 'name', 'edu_type_id']);
  }

  public static function regStud ($user_id, $child_id, $sch_id, $edu_type_id) {
    $res = dbs::row('xonStudReg', ['*'], compact('child_id', 'edu_type_id'));
    if ( $res !== null ) {
      throw new Exception("已经报名，同类学校只能报一个");
    }
    // 取编号  =>   直接用学生stud_id作主键
//    $id = xonSchoolCode::getSchoolCode($sch_id);
//    $res = dbs::row('xonStudSchool', ['*'], compact('id'));
//    if ( $res !== null ) {
//      throw new Exception("系统繁忙，请稍候重试");
//    }
    // 保存
    $id = $child_id;
    $uid = x5on::getUid();
    dbs::insert('xonStudReg', compact('id', 'uid', 'child_id', 'sch_id', 'user_id', 'edu_type_id'));
    // 读取学校报名表格
    $current_year = 1;
    $app_name = 'regstud';
    return dbs::select('xovSchoolForm', ['id', 'name'], compact('sch_id', 'app_name', 'current_year'));
  }

  // 临时只能报一个
  public static function regCheck ($user_id) {
    $data = dbs::row('xovStudReg', ['sch_id', 'sch_name', 'child_id', 'child_name'], compact('user_id'));
    if ( $data !== null ) {
      $reged = true;
      // 读取学校报名表格
      $sch_id = $data->sch_id;
      $current_year = 1;
      $app_name = 'regstud';
      $forms = dbs::select('xovSchoolForm', ['id', 'name'], compact('sch_id', 'app_name', 'current_year'));
      $form_setted = xonSchoolFormSet::checkSchoolFormSet($user_id);
      if ( $form_setted === null || $form_setted !== null && ! $form_setted->checked ) {
        $infor_added = false;
        return compact('reged', 'infor_added', 'data', 'forms');
      }
      $form_id = $form_setted->form_id;
      $infor_added = $form_setted->checked;
      // 取得form_name
      $form_name = xonSchoolForm::getFormNameById($form_id);
      // 查询用户已提交的表格数据
      $user_forms = xonSchoolFormKey::listKeysByFormId($user_id, $form_id);
      return compact('reged', 'infor_added', 'data', 'form_name', 'forms', 'user_forms');
    } else {
      $reged = false;
      $infor_added = false;
      return compact('reged', 'infor_added');
    }
  }

  // 取消报名
  public static function regCancel ($user_id, $sch_id, $child_id) {
    $res = dbs::row('xonStudReg', ['*'], compact('user_id', 'sch_id', 'child_id'));
    if ( $res !== null ) {
      $id = $res->id;
      return dbs::delete('xonStudReg', compact('id'));
    } else {
      throw new Exception("传入参数有误，没有找到相关报名数据");
    }
  }
}
