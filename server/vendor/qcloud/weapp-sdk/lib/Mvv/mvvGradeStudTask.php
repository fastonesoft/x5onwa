<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xovGradeStudTask;

class mvvGradeStudTask
{

  public static function query ($grade_id, $task_status_id, $has_done) {
    return xovGradeStudTask::getsBy(compact('grade_id', 'task_status_id', 'has_done'));
  }

}
