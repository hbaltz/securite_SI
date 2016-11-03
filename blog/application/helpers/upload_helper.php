<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('custom_upload') )
{
    function custom_upload()
    {
        // Récupération de l'instance de CI
        $CI=& get_instance();

        // Configuration pour l'upload de l'image
        $config['upload_path'] = 'uploaded_files/';
        $config['allowed_types'] = 'gif|jpg|png';
        //$config['encrypt_name'] = 'TRUE'; // On le re fait à la main en dessous
        $config['max_filename'] = '21';
        $config['max_size'] = '2048';
        $config['max_width'] = '1300';
        $config['max_height'] = '800';

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
        endif;

        return $data;
    }
}

