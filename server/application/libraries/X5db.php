<?php defined('BASEPATH') OR exit('No direct script access allowed');

class X5db
{
    protected $x5;

    public function __construct()
    {
        $this->x5 =& get_instance();
    }

    public function x5table_exists($table)
    {
        if (!$this->x5->db->table_exists($table)) {
            throw new Exception('数据表不存在！');
        }
    }

    public function x5gets($table)
    {
        $this->x5table_exists($table);

        $query = $this->x5->db->get($table);
        return $query->result();
    }

    public function x5where($table, $where = null, $limit = NULL, $offset = NULL)
    {
        $this->x5table_exists($table);

        $query = $this->x5->db->get_where($table, $where, $limit, $offset);
        return $query->result();
    }

    public function x5like($field, $match = '', $side = 'both', $escape = NULL) {
        // todo
    }


}