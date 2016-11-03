<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('custom_upload') )
{
    function custom_upload()
    {
        // Récupération de l'instance de CI
        $CI=& get_instance();

        // Configuration pour l'upload de l'image
        $config['image_library'] = 'gd2';
        $config['upload_path'] = '../blog-ufiles/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        //$config['encrypt_name'] = 'TRUE'; // On le refait à la main en dessous
        $config['max_filename'] = '21';
        $config['max_size'] = '2048';
        $config['max_width'] = '1300';
        $config['max_height'] = '1300';

        // On encrypte le nom de l'image
        $ext = end(explode(".",$_FILES['image']['name']));
        $CI->load->helper('string');
        $config['file_name'] = $data['file_name'] = random_string('alnum',20).".".$ext;

        $CI->load->library('upload', $config);
        $data['error'] = FALSE;

        // Si l'upload a échoué, on l'affiche
        if ( ! $CI->upload->do_upload('image')) :
            $data['error'] = $CI->upload->display_errors('', '');
        else:
            //$data['file_name'] = $_FILES['image']['name'];

            // On redimensionne l'image : 
            /*

            $CI->load->library('image_lib');
            $config['source_image'] = $CI->upload->upload_path.$config['file_name'];

            $sizes = array(array(270, 220), array(770,300));
            foreach ($sizes as $size) {
                $config['maintain_ratio'] = false;
                $config['width'] = $size[0];
                $config['height'] = $size[1];
                $config['new_image'] = $config['upload_path'].$size[0]."_".$size[1]."_".$config['file_name'];

                $CI->image_lib->clear();
                $CI->image_lib->initialize($config);
                $CI->image_lib->resize();

                if( ! $CI->image_lib->resize()){
                    $data['error'] = $CI->image_lib->display_errors('', '');
                }
            }
            
            */

        endif;

        return $data;
    }
}

if ( !function_exists('get_uploaded_picture') )
{
    function get_uploaded_picture($filename){

        $ext = end(explode(".",$filename));
        $path = "../blog-ufiles/" . $filename;

        if($ext == "jpg"){
            header('Content-Type: image/jpeg');
            readfile($path);
            return TRUE;
        }else if($ext == "png"){
            header('Content-Type: image/png');
            readfile($path);
            return TRUE;
        } else if($ext == "gif"){
            header('Content-Type: image/gif');
            readfile($path);
            return TRUE;
        }

        return FALSE;
    }

}