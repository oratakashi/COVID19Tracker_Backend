<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . '/libraries/REST_Controller.php';

    use Restserver\Libraries\REST_Controller;
    class Province extends REST_Controller {

        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('ProvinceModel', 'province');
            $this->load->model('HospitalModel', 'hospital');
        }
        
    
        public function index_get()
        {
            if(empty($this->uri->segment(2))){
                $message = array(
                    "status"    => true,
                    "message"   => "Berhasil mendapatkan data provinsi!",
                    "data"      => $this->province->read()
                );

                $this->response($message, REST_Controller::HTTP_OK);
            }else{
                if($this->uri->segment(3) == 'hospital'){
                    $id = $this->uri->segment(2);

                    $message = array(
                        "status"    => true,
                        "message"   => "Berhasil mendapatkan data rumah tangga!",
                        "data"      => $this->hospital->read_province($id)
                    );

                    $this->response($message, REST_Controller::HTTP_OK);
                }
            }
        }

        public function index_post()
        {
            $id = $this->uuid->v4();

            $data = array(
                "id_province" => $id,
                "province" => $this->post('province'),
                "source" => $this->post('source')
            );

            if($this->province->insert($data) > 0){
                $message = array(
                    "status"    => true,
                    "message"   => "Berhasil menambah provinsi baru!",
                    "data"      => $this->province->read_id($id)
                );

                $this->response($message, REST_Controller::HTTP_OK);
            }else{
                $message = array(
                    "status"    => false,
                    "message"   => "Gagal menambah provinsi baru",
                    "data"      => null
                );

                $this->response($message, REST_Controller::HTTP_OK);
            }
        }
    
    }
    
    /* End of file Province.php */
    
?>