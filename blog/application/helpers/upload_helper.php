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

        $CI->load->library('upload', $config);
        $data['error'] = FALSE;

        // Si l'upload a échoué, on l'affiche
        if ( ! $CI->upload->do_upload('image')) :
            $data['error'] = $CI->upload->display_errors('', '');
        else:
            $data['file_name'] = $_FILES['image']['name'];
        endif;

        return $data;
    }
}

