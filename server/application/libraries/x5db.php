<?php defined('BASEPATH') OR exit('No direct script access allowed');

class X5db
{
    protected $x5;

    public function __construct()
    {
        $this->x5 =& get_instance();
    }

    public function x5tables()
    {
        return $this->x5->db->list_tables();
    }

    public function x5table_exists($tableName)
    {
        if (!$this->x5->db->table_exists($tableName)) {
            throw new Exception('数据表不存在！');
        }
    }

    public function x5gets($tableName)
    {
        $this->x5table_exists($tableName);

        $query = $this->x5->db->get($tableName);
        return $query->result_array();
    }

    public function x5getsByCondition($tableName, $condition) {

    }


}