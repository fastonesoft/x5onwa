<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonRole;
use QCloud_WeApp_SDK\Model\xonType;
use QCloud_WeApp_SDK\Model\xovUserRole;
use QCloud_WeApp_SDK\Model\xovUserRoleSchool;
use QCloud_WeApp_SDK\Model\xovUserSchoolAll;

class mvvAppmenu
{

    public static function roles($roles, $myroles, $myroleschs)
    {
        // 按照权限列表，逐一检测是否有权限：
        // 有，则标志为1，没有标志为0
        $result = [];
        foreach ($roles as $k => $v) {
            $has_role = 0;
            foreach ($myroles as $value) {
                if ($v->id === $value->role_id) {
                    $has_role = 1;
                    break;
                }
            }
            foreach ($myroleschs as $value) {
                if ($v->id === $value->role_id) {
                    $has_role = 1;
                    break;
                }
            }
            $roles[$k]->has_role = $has_role;
            // 有权限 且 可显示
            if ($roles[$k]->has_role && $roles[$k]->can_show) {
                array_push($result, $roles[$k]);
            }
        }
        return $result;
    }

    // 构造用户、学校权限列表
    public static function menus($user_id) {
        $roles = xonRole::gets();
        $myroles = xovUserRole::getsBy(compact('user_id'));
        // 查询用户学校
        $is_current = 1;
        $userschool = xovUserSchoolAll::getBy(compact('user_id', 'is_current'));
        $sch_id = $userschool ? $userschool->sch_id : null;
        // 用户学校对应权限
        $myroleschs = xovUserRoleSchool::getsBy(compact('user_id', 'sch_id'));

        $result = self::roles($roles, $myroles, $myroleschs);

        return $result;
    }

}
