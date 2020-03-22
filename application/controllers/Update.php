<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;
class Update extends REST_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UpdateModel', 'update');
        
    }
    
    public function index_get()
    {
        $version = $this->get("version");

        $data_server = $this->update->getLast();

        if($version < $data_server['version']){
            $message = array(
                "status"    => false,
                "message"   => "Update baru ditemukan!",
                "data"      => $data_server
            );

            $this->response($message, REST_Controller::HTTP_OK);
        }else{
            $message = array(
                "status"    => true,
                "message"   => "Aplikasi kamu sudah terbaru!",
                "data"      => $data_server
            );

            $this->response($message, REST_Controller::HTTP_OK);
        }
    }

    public function index_post()
    {
        $id = $this->uuid->v4();

        $data = [
            "id_version"        => $id,
            "version"           => $this->post("version"),
            "version_char"      => $this->post("version_char"),
            "changelog"         => $this->post("changelog"),
            "link_official"     => $this->post("link_official"),
            "link_mirror"       => $this->post("link_mirror")
        ];

        if($this->update->insert($data) > 0){
            $message = array(
                "status"    => true,
                "message"   => "Berhasil menambah update baru!",
                "data"      => $this->update->read_id($id)
            );

            $this->response($message, REST_Controller::HTTP_OK);
        }else{
            $message = array(
                "status"    => false,
                "message"   => "Gagal menambah update baru",
                "data"      => null
            );

            $this->response($message, REST_Controller::HTTP_OK);
        }
    }

}

/* End of file Update.php */

?>