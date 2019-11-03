<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xcon
{
    // 跨域支持，上传的时候要禁用
    const CROS = 1;

    // ERROR-CODE
    const NO_ERROR = 0;
    const ERROR_NOT_LOGIN = -1;
    const ERROR_APP = 1;
    const ERROR_DB = 2;

    // TO-KEN
    const TO_KEN = '#30ca5d5fd85b11e98f5870f395158687#';

    // EXAM-CODE
    const EXAM_DATA = 1;
    const EXAM_DATAED = 2;
    const EXAM_COUNT = 4;
    const EXAM_COUNTED = 8;
    const EXAM_BACK = 16;
    const EXAM_BACKED = 32;


    public static function cros()
    {
        if (self::CROS) {
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Allow-Origin: http://localhost:8080');
        }
    }

    public static function error($code, $message)
    {
        throw new Exception($message, $code);
    }

    protected static function db_error()
    {
        $CI =& get_instance();
        $error = $CI->db->error();
        $message = $error['message'];

        // 有数据库出错信息，就提示
        if ($message) {
            self::error(self::ERROR_DB, $message);
        }
    }

    public static function sess_set($key, $value)
    {
        $CI =& get_instance();
        $CI->session->set_userdata($key, $value);
    }

    public static function sess_unset($key)
    {
        $CI =& get_instance();
        $CI->session->unset_userdata($key);
    }

    public static function sess_destroy()
    {
        $CI =& get_instance();
        $CI->session->sess_destroy();
    }

    public static function errorCheck($success)
    {
        try {
            call_user_func($success);
        } catch (Exception $e) {
            self::json($e->getCode(), $e->getMessage());
        }
    }

    public static function loginCheck($success)
    {
        self::errorCheck(function () use ($success) {
            // 登录检测
            $CI =& get_instance();
            $userinfor = $CI->userinfor;

            if ($userinfor === null) {
                self::error(self::ERROR_NOT_LOGIN, '没有登录，或登录状态已过期！');
            }
            // 权限检测

            // 已登录
            call_user_func($success, $userinfor);
        });
    }

    public static function json($code, $data)
    {
        $CI =& get_instance();
        return $CI->output
            ->set_content_type('application/json')
            ->set_output(
                json_encode(compact('code', 'data'))
            );
    }

    /**
     * @return mixed
     * 这种方式可以解决axios提交的数据无法用$_POST接收的问题
     */
    public static function params()
    {
        $CI =& get_instance();
        return json_decode($CI->input->raw_input_stream, true);
    }

    public static function params_obj()
    {
        $CI =& get_instance();
        return json_decode($CI->input->raw_input_stream);
    }

    public static function array_key($arr, $key)
    {
        if (array_key_exists($key, $arr)) {
            return $arr[$key];
        } else {
            self::error(self::ERROR_APP, '“' . $key . '”对应参数不存在！');
        }
    }

    /**
     * @param $table
     * @return mixed
     * 获取数据库表  array形式 => 每条记录 可以使用 row['name'] 形式访问
     */
    public static function gets($table)
    {
        $CI =& get_instance();
        $query = $CI->db->get($table);
        self::db_error();
        return $query->result();
    }

    public static function gets_array($table)
    {
        $CI =& get_instance();
        $query = $CI->db->get($table);
        self::db_error();
        return $query->result_array();
    }

    /**
     * @param        $table
     * @param        $where  array('name !=' => $name, 'id <' => $id, 'date >' => $date);
     * @param string $orderby
     * @param null $limit
     * @return mixed
     * 条件查询
     */
    public static function wheres_query($table, $where, $orderbyKeys = '', $limit = null, $offset = null)
    {
        $CI =& get_instance();
        $CI->db->order_by($orderbyKeys);
        return $CI->db->get_where($table, $where, $limit, $offset);
    }

    // 统计记录数
    public static function count($table, $where) {
        $CI =& get_instance();
        $CI->db->get_where($table, $where);
        return $CI->db->count_all_results();
    }

    // 多记录查询结果
    public static function getsBy($table, $where, $orderbyKeys = '', $limit = null, $offset = null)
    {
        $query = self::wheres_query($table, $where, $orderbyKeys, $limit, $offset);
        self::db_error();
        return $query->result();
    }

    public static function getsBy_array($table, $where, $orderbyKeys = '', $limit = null, $offset = null)
    {
        $query = self::wheres_query($table, $where, $orderbyKeys, $limit, $offset);
        self::db_error();
        return $query->result_array();
    }

    // 单记录查询
    public static function getBy($table, $where)
    {
        $query = self::wheres_query($table, $where);
        self::db_error();
        return $query->row();
    }

    public static function getBy_array($table, $where)
    {
        $query = self::wheres_query($table, $where);
        self::db_error();
        return $query->row_array();
    }

    public static function getById($table, $id)
    {
        $query = self::wheres_query($table, compact('id'));
        self::db_error();
        return $query->row();
    }

    public static function getById_array($table, $id)
    {
        $query = self::wheres_query($table, compact('id'));
        self::db_error();
        return $query->row_array();
    }

    public static function getByUid($table, $uid)
    {
        $query = self::wheres_query($table, compact('uid'));
        self::db_error();
        return $query->row();
    }

    public static function getByUid_array($table, $uid)
    {
        $query = self::wheres_query($table, compact('uid'));
        self::db_error();
        return $query->row_array();
    }

    /**
     * 获取字段值，不存在，则为空
     */
    public static function getKeyBy($table, $where, $keyName)
    {
        $row = self::getBy_array($table, $where);
        if ($row === null) {
            return null;
        } else {
            return $row[$keyName];
        }
    }

    public static function getKeyById($table, $id, $keyName)
    {
        $row = self::getById_array($table, $id);
        if ($row === null) {
            return null;
        } else {
            return array_key_exists($keyName, $row) ? $row[$keyName] : null;
        }
    }

    public static function getKeyByUid($table, $uid, $keyName)
    {
        $row = self::getByUid_array($table, $uid);
        if ($row === null) {
            return null;
        } else {
            return array_key_exists($keyName, $row) ? $row[$keyName] : null;
        }
    }

    /**
     * 检测数据记录是否不存在
     */
    public static function checkBy($table, $where, $message = '“查询条件”对应记录不存在！')
    {
        $row = self::getBy($table, $where);
        if ($row === null) {
            self::error(self::ERROR_DB, $message);
        }
        return $row;
    }

    public static function checkById($table, $id)
    {
        return self::checkBy($table, compact('id'), '“编号”不存在！');
    }

    public static function checkByUid($table, $uid)
    {
        return self::checkBy($table, compact('uid'), '“系统编号”不存在！');
    }

    /**
     * 返回字段值
     */
    public static function checkKeyBy($table, $where, $keyName)
    {
        $row = self::checkBy($table, $where);
        return $row[$keyName];
    }

    public static function checkKeyById($table, $id, $keyName)
    {
        $row = self::checkById($table, $id);
        return $row[$keyName];
    }

    public static function checkKeyByUid($table, $uid, $keyName)
    {
        $row = self::checkByUid($table, $uid);
        return $row[$keyName];
    }


    /**
     * 检测数据记录是否不存在
     */
    public static function existBy($table, $where, $message = '“查询条件”对应记录已存在！')
    {
        $row = self::getBy($table, $where);
        if ($row !== null) {
            self::error(self::ERROR_DB, $message);
        }
    }

    public static function existById($table, $id)
    {
        self::existBy($table, compact('id'), '“编号”已存在！');
    }

    public static function existByUid($table, $uid)
    {
        self::existBy($table, compact('uid'), '“系统编号”对应记录已存在！');
    }

    /**
     * @param        $table
     * @param        $where
     * @param        $likes
     * @param string $orderby
     * @param null $limit
     * @return mixed
     * 模糊查询
     */
    public static function likes($table, $where, $likes, $orderby = '', $limit = null)
    {
        $CI =& get_instance();
        $CI->db->like($likes);
        $query = self::wheres_query($table, $where, $orderby, $limit);
        self::db_error();
        return $query->result();
    }

    /**
     * @return mixed
     * 获取 uuid
     */
    public static function uid()
    {
        $CI =& get_instance();
        $query = $CI->db->query('SELECT uuid() as uid');
        self::db_error();
        $row = $query->row_array();
        $uid = $row['uid'];
        return str_replace('-', '', $uid);
    }

    /**
     * @param $table
     * @param $values
     * 存储数据记录
     */
    public static function add($table, $values)
    {
        $CI =& get_instance();
        $CI->db->insert($table, $values);
        self::db_error();
        return $CI->db->affected_rows();
    }

    /**
     * @param $table
     * @param $cols
     * @param $by
     * @return mixed
     * 更新数据记录
     */
    public static function setBy($table, $cols, $by)
    {
        $CI =& get_instance();
        $CI->db->update($table, $cols, $by);
        self::db_error();
        return $CI->db->affected_rows();
    }

    public static function setById($table, $cols, $id)
    {
        $CI =& get_instance();
        self::setBy($table, $cols, compact('id'));
        self::db_error();
        return $CI->db->affected_rows();
    }

    public static function setByUid($table, $cols, $uid)
    {
        $CI =& get_instance();
        self::setBy($table, $cols, compact('uid'));
        self::db_error();
        return $CI->db->affected_rows();
    }

    public static function delBy($table, $where)
    {
        $CI =& get_instance();
        $CI->db->delete($table, $where);
        self::db_error();
        return $CI->db->affected_rows();
    }

    public static function delById($table, $id)
    {
        self::checkById($table, $id);
        return self::delBy($table, compact('id'));
    }

    public static function delByUid($table, $uid)
    {
        self::checkByUid($table, $uid);
        return self::delBy($table, compact('uid'));
    }

    /**
     * 分页数据查询
     */

    public static function page($table, $size, $index)
    {

    }

}