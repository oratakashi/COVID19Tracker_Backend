<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/Scraper.php';

class NewsModel extends CI_Model
{

    public function read_detik($page)
    {
        // persiapkan curl for Detik dot com
        $ch = curl_init();

        // set url for Detik Dot Com
        curl_setopt($ch, CURLOPT_URL, "https://www.detik.com/tag/virus-corona/?sortby=time&page=" . $page);

        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');

        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // $output contains the output string 
        $output = curl_exec($ch);

        // tutup curl 
        curl_close($ch);

        $html  = str_get_html($output);

        if (isset($html)) {
            $bahan = $html->find('div[class=list list--feed media_rows middle mb15 pb15 an_4_3]');

            $output_detik = array();

            foreach ($bahan as $index => $value) {
                $index_title = 0;
                $index_date = 0;
                $index_desc = 0;
                $index_image = 0;
                $index_link = 0;
                /**
                 * Get Data Title
                 */
                $title = $value->find('h2[class=title]');
                foreach ($title as $row) {
                    $output_detik[$index_title]['title'] = $row->innertext;
                    $index_title++;
                }

                /**
                 * Get Data Date
                 */
                $date = $value->find('span[class=date]');
                foreach ($date as $row) {
                    $dates = substr($row->innertext, 0, strlen($row->innertext) - 4);
                    $dates = explode(",", $dates);
                    $dates = explode(" ", substr($dates[1], 1));
                    switch ($dates[1]) {
                        case 'Januari':
                            $dates[1] = 1;
                            break;
                        case 'Februari':
                            $dates[1] = 2;
                            break;
                        case 'Maret':
                            $dates[1] = 3;
                            break;
                        case 'April':
                            $dates[1] = 4;
                            break;
                        case 'Mei':
                            $dates[1] = 5;
                            break;
                        case 'Juni':
                            $dates[1] = 6;
                            break;
                        case 'Juli':
                            $dates[1] = 7;
                            break;
                        case 'Agustus':
                            $dates[1] = 8;
                            break;
                        case 'September':
                            $dates[1] = 9;
                            break;
                        case 'Oktober':
                            $dates[1] = 10;
                            break;
                        case 'November':
                            $dates[1] = 11;
                            break;
                        case 'Desember':
                            $dates[1] = 12;
                            break;

                        default:
                            # code...
                            break;
                    }
                    $dates = $dates[2] . "-" . $dates[1] . "-" . $dates[0] . " " . $dates[3];
                    $output_detik[$index_date]['date'] = date("Y-m-d H:i:s", strtotime($dates));
                    $index_date++;
                }

                /**
                 * Get Data Description
                 */
                $description = $value->find('p');
                foreach ($description as $row) {
                    $output_detik[$index_desc]['description'] = $row->innertext;
                    $index_desc++;
                }

                /**
                 * Get Data Image
                 */
                $image = $value->find('img');

                foreach ($image as $row) {
                    $output_detik[$index_image]['image'] = $row->src;
                    $index_image++;
                }

                /**
                 * Get Article Link
                 */
                $link = $value->find('a');

                foreach ($link as $row) {
                    $output_detik[$index_link]['link'] = $row->href;
                    $output_detik[$index_link]['source'] = "Detik.com";
                    $index_link++;
                }
            }
        }

        return $output_detik;
    }

    public function read_kompas($page)
    {
        /**
         * Get Data For Kompas Dot Com
         * Source Url : https://www.kompas.com/covid-19?page=1
         */

        // persiapkan curl for Kompas Dot Com
        $ch = curl_init();

        // set url for Kompas Dot Com
        curl_setopt($ch, CURLOPT_URL, "https://www.kompas.com/covid-19?page=" . $page);

        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');

        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_VERBOSE, true);

        // $output contains the output string 
        $output = curl_exec($ch);

        $curl_error = curl_error($ch);
        echo "<script>console.log($curl_error);</script>";

        // tutup curl 
        curl_close($ch);

        $html = str_get_html($output); //Convert html to object

        /**
         * Find Data, Find div class from Source 
         */

        $output_kompas = array();

        echo $output;
        // if (isset($html)) {
        //     $bahan = $html->find('div[class=latest ga--latest mt2 clearfix]');

        //     foreach ($bahan as $index => $value) {
        //         $index_title = 0;
        //         $index_date = 0;
        //         $index_image = 0;
        //         /**
        //          * Get Article Title
        //          */

        //         $title = $value->find('a[class=article__link]');

        //         foreach ($title as $row) {
        //             $output_kompas[$index_title]['title'] = $row->innertext;
        //             $output_kompas[$index_title]['link'] = $row->href;
        //             $output_kompas[$index_title]['source'] = "Kompas.com";
        //             $output_kompas[$index_title]['description'] = "null";

        //             $index_title++;
        //         }

        //         /**
        //          * Get Article Date
        //          */
        //         $date = $value->find('div[class=article__date]');

        //         foreach ($date as $row) {
        //             $dates = explode(" ", $row->innertext);
        //             $dates = substr($dates[0], 0, strlen($dates[0]) - 1) . " " . $dates[1];

        //             $output_kompas[$index_date]['date'] = date("Y-m-d H:i:s", strtotime($dates));
        //             $index_date++;
        //         }

        //         /**
        //          * Get Article Images
        //          */
        //         $image = $value->find('img');

        //         foreach ($image as $row) {
        //             $output_kompas[$index_image]['image'] = $row->src;
        //             $index_image++;
        //         }
        //     }
        // }

        return $output_kompas;
    }

    public function read_cnn($page)
    {
        /**
         * Get Data For CNN Dot Com
         * Source Url : https://www.cnnindonesia.com/tag/covid_19
         */

        // persiapkan curl for Kompas Dot Com
        $ch = curl_init();

        // set url for Kompas Dot Com
        curl_setopt($ch, CURLOPT_URL, "https://www.cnnindonesia.com/tag/covid_19/" . $page);

        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');

        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // $output contains the output string 
        $output = curl_exec($ch);

        // tutup curl 
        curl_close($ch);

        $output_cnn = array();

        /**
         * Parsing to Object
         */
        $html = str_get_html($output);

        if (isset($html)) {
            $bahan = $html->find('div[class=list media_rows middle]');

            foreach ($bahan as $index => $value) {
                $index_title = 0;
                $index_date = 0;
                $index_image = 0;
                $index_link = 0;

                /**
                 * Get CNN Title
                 */
                $title = $value->find('h2[class=title]');

                foreach ($title as $row) {
                    $output_cnn[$index_title]['title'] = $row->innertext;
                    $index_title++;
                }

                /**
                 * Get CNN Date
                 */
                $date = $value->find('span[class=date]');
                foreach ($date as $row) {
                    $val = $row->innertext;
                    $val = explode("lalu", $val);
                    $val = str_replace("<!--", "", $val[1]);
                    $val = str_replace("-->", "", $val);

                    $output_cnn[$index_date]['date'] = $val;

                    $index_date++;
                }

                /**
                 * Get CNN Image
                 */
                $image = $value->find('img');

                foreach ($image as $row) {
                    $output_cnn[$index_image]['image'] = $row->src;
                    $index_image++;
                }

                /**
                 * Get CNN Link
                 */
                $link = $value->find('a');
                foreach ($link as $row) {
                    $output_cnn[$index_link]['link'] = $row->href;
                    $output_cnn[$index_link]['source'] = "CNN.com";
                    $output_cnn[$index_link]['description'] = "null";

                    $index_link++;
                }
            }
        }

        return $output_cnn;
    }
}
    
    /* End of file NewsModel.php */
