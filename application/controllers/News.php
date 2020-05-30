<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . '/libraries/REST_Controller.php';

    use Restserver\Libraries\REST_Controller;

    class News extends REST_Controller {
        
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('NewsModel', 'news');
            
        }
        

        public function index_get()
        {
            $page = 1;
            if(!empty($this->get('page'))){
                $page = $this->get('page');
            }
            // $message = array(
            //     "status"    => true,
            //     "message"   => "Berhasil mendapatkan data News!",
            //     "data"      => array_merge($this->news->read_detik($page), $this->news->read_kompas($page), $this->news->read_cnn($page))
            // );

            $this->news->read_kompas($page);

            // $this->response($message, REST_Controller::HTTP_OK);
            // echo json_encode();
            // echo json_encode($this->news->read_kompas($page));
        }
    
    }
    
    /* End of file News.php */
