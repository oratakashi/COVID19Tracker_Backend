<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . '/libraries/REST_Controller.php';

    use Restserver\Libraries\REST_Controller;
    class Hospital extends REST_Controller {
        
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('HospitalModel', 'hospital');
            
        }
        

        public function index_get()
        {
            $message = array(
                "status"    => true,
                "message"   => "Berhasil mendapatkan data rumah sakit!",
                "data"      => $this->hospital->read()
            );

            $this->response($message, REST_Controller::HTTP_OK);
        }

        public function index_post()
        {
            $id = $this->uuid->v4();

            $data = array(
                "id_hospital"       => $id,
                "id_province"       => $this->post("id_province"),
                "name"              => $this->post("name"),
                "address"           => $this->post("address")
            );

            if($this->hospital->insert($data) > 0){
                $message = array(
                    "status"    => true,
                    "message"   => "Berhasil menambah rumah sakit baru!",
                    "data"      => $this->hospital->read_id($id)
                );

                $this->response($message, REST_Controller::HTTP_OK);
            }else{
                $message = array(
                    "status"    => false,
                    "message"   => "Gagal menambah rumah sakit baru",
                    "data"      => null
                );

                $this->response($message, REST_Controller::HTTP_OK);
            }
        }
    
    }
    
    /* End of file Hospital.php */
    
?>