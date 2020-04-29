<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . '/libraries/REST_Controller.php';

    use Restserver\Libraries\REST_Controller;
    use Phpfastcache\Helper\Psr16Adapter;
    class Instagram extends REST_Controller {
    
        public function index_get()
        {
            $instagram = \InstagramScraper\Instagram::withCredentials('amandahasna5', 'dhinie', new Psr16Adapter('Files'));
            $instagram->login();
            $medias = $instagram->getMedias('bnpb_indonesia', 5);
            $account = $instagram->getAccount('bnpb_indonesia');

            $output = array();

            foreach ($medias as $index => $value) {
                $media = (array) $value;
                $output[$index]["link"] = $value->getLink();
                $output[$index]["thumbs"] = $value->getImageThumbnailUrl();
                $output[$index]["date"] = $value->getCreatedTime();
                $output[$index]["caption"] = $value->getCaption();
                $output[$index]["likes"] = $value->getLikesCount();
                $output[$index]["comments"] = $value->getCommentsCount();
                $output[$index]["username"] = $account->getUsername();
                $output[$index]["user_photo"] = $account->getProfilePicUrl();
            }

            $data = array(
                "username"      => $account->getUsername(),
                "user_photo"    => $account->getProfilePicUrl(),
                "user_followers"    => $account->getFollowedByCount(),
                "user_media"    => $output
            );

            $message = array(
                "status"    => true,
                "message"   => "Berhasil mendapatkan data Instagram!",
                "data"      => $data
            );

            $this->response($message, REST_Controller::HTTP_OK);

            
        }
    
    }
    
    /* End of file Instagram.php */
    
?>