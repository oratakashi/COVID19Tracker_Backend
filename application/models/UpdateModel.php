<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class UpdateModel extends CI_Model {
    
        public function insert($data)
        {
            $this->db->insert('version', $data);
            return $this->db->affected_rows();
        }

        public function read_id($id)
        {
            return $this->db->get_where('version',["id_version" => $id])->row_array();            
        }

        public function getLast()
        {
            $this->db->order_by('updated_at', 'desc');
            return $this->db->get('version', 1)->row_array();
            
        }
    
    }
    
    /* End of file UpdateModel.php */
    
?>