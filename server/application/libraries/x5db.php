<?php defined('BASEPATH') OR exit('No direct script access allowed');

class x5db
{
    protected $CI;

    public function __construct()
    {
        $CI =& get_instance();
        $this->CI->load->database();
    }

    protected function x5databases()
    {
        $query = $this->CI->db->query('show databases;');
        $result = $query->result_array();
        return $result;
    }

    protected function x5tables()
    {
        $query = $this->CI->db->query('show tables;');
        $result = $query->result_array();
        return $result;
    }

    protected function x5checkTable($tableName)
    {
        $tables = $this->x5tables();

        $exist = false;
        foreach ($tables as $key => $value) {
            if ($value === $tableName) {
                $exist = true;
                break;
            }
        }
        if (!$exist) throw new Exception('数据表不存在！');
    }

    public function x5gets($tableName)
    {
        $this->x5checkTable($tableName);

        $query = $this->CI->db->get($tableName);
        return $query->result_array();
    }

    public function x5getsByCondition($tableName, )


}