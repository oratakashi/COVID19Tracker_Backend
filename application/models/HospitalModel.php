<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class HospitalModel extends CI_Model {
    
        public function insert($data)
        {
            $this->db->insert('hospitals', $data);
            return $this->db->affected_rows();
        }

        public function read_id($id)
        {
            return $this->db->get_where('hospitals', ["id_hospital" => $id])->row_array();
        }

        public function read_province($id)
        {
            $this->db->join('province', 'province.id_province = hospitals.id_province', 'left');
            $this->db->where('hospitals.id_province', $id);
            
            return $this->db->get('hospitals')->result_array();
        }

        public function read()
        {
            $this->db->join('province', 'province.id_province = hospitals.id_province', 'left');
            return $this->db->get('hospitals')->result_array();
        }
    }
    
    /* End of file HospitalModel.php */
    