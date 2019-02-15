<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonGradeStudTask extends cAppinfo
{
  protected static $tableName = 'xonGradeStudTask';
  protected static $tableTitle = '学生变更任务';

  public static function add ($grade_stud_id, $stud_status_id, $task_status_id, $has_done, $task_memo) {
    // 当前年度学校学生只能进行一次同类变更
    xonGradeStudTask::existBy(compact('grade_stud_id', 'task_status_id'));
    $uid = x5on::getUid();
    xonGradeStudTask::insert(compact('uid', 'grade_stud_id', 'stud_status_id', 'task_status_id', 'has_done', 'task_memo'));
    return $uid;
  }

}