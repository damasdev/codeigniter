<?php

class MY_Form_validation extends CI_Form_validation
{
    public $CI;

    public function is_unique($string, $field)
    {
        sscanf($field, '%[^.].%[^.]', $table, $field);

        return is_object($this->CI->db)
            ? ($this->CI->db->limit(1)->from($table)->where([$field => $string])->count_all_results() === 0)
            : false;
    }
}
