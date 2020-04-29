<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class ProvinceModel extends CI_Model {
    
        public function insert($data)
        {
            $this->db->insert('province', $data);
            return $this->db->affected_rows();
        }

        public function read_id($id)
        {
            return $this->db->get_where('province', ["id_province" => $id])->row_array();
            
        }

        public function read()
        {
            return $this->db->get('province')->result_array();
        }
    }
    
    /* End of file ProvinceModel.php */
    