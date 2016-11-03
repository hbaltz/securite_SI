<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('css_url') )
{
    function css_url($nom)
    {
        return '<link rel="stylesheet" href="'. base_url('assets/css') . "/$nom" . '.css" />';
    }
}

if ( ! function_exists('js_url'))
{
   function js_url($nom)
   {
       return '<script src="' . base_url('assets/js') . "/$nom" . '.js"></script>';
   }
}

if ( ! function_exists('content_url'))
{
    function content_url($categorie, $content, $titre, $link = true)
    {
        return '<a href="' . base_url($categorie . '/' . $content) . '">' . $titre . '</a>';
    }
}

if ( ! function_exists('content_url_button'))
{
    function content_url_button($categorie, $article)
    {
        return '<a href="' . base_url($categorie . '/' . $article) . '" class="btn btn-primary">Lire la suite</a>';
    }
}

if ( ! function_exists('categorie_url'))
    {
    function categorie_url($categorie, $titre)
    {
        return '<a href="' . base_url($categorie) . '">' . $titre . '</a>';
    }
}

if ( ! function_exists('pagination_custom'))
{
    function pagination_custom()
    {
        // Paramètres de configuration
        # Nombre d'articles par page
        $config['per_page']         = 3;
        # Lister les pages par numéro (page 1, page 2, etc...)
        $config['use_page_numbers'] = TRUE;

        # HTML entre les digits
        $config['full_tag_open']    = '<div class="pagination"><ul>';
        $config['full_tag_close']   = '</ul></div>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="active"><span>';
        $config['cur_tag_close']    = '</span></li>';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']   = '</li>';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tag_close']   = '</li>';
        $config['first_tag_open']   = '<li style="display: none;">';
        $config['first_tag_close']  = '</li>';
        $config['last_tag_open']    = '<li style="display: none;">';
        $config['last_tag_close']   = '</li>';

        return $config;
    }
}

if ( ! function_exists('is_logged_in'))
{
    function is_logged_in()
    {
        $CI = get_instance();
        $CI->load->library('session');
        
        if(!$CI->session->userdata('logged_in')) {
            return FALSE;
        }
        
        return TRUE;
    }
}
