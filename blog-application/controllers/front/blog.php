<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Blog extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // On charge les ressources utiles pour toutes les actions
        $this->load->model('model_blog');
        $this->load->library('pagination');
        $this->load->helper(array('functions', 'text'));

        // Retourne toutes les catégories (sidebar)
        $this->categories = $this->model_blog->get_all_categories();
    }

    public function index($num_page = 1) {
        $data['page'] = 'home';

        if($num_page > 1) {
            $data['num_page'] = $num_page;
        }

        // Recherche de toutes les catégories (visibles en sidebar)
        $data['categories'] = $this->categories;

        // Recherche de tous les articles
        $articles = $this->model_blog->get_all_articles();

        // Pagination
        $pagination = pagination_custom();
        $pagination['base_url'] = base_url('page');
        $pagination['first_url'] = base_url();
        $pagination['total_rows'] = $articles->num_rows();
        $pagination['num_links'] = round($pagination['total_rows'] / $pagination['per_page'] + 1);
        $pagination['uri_segment'] = 2;
        $this->pagination->initialize($pagination);

        if($num_page > $pagination['num_links']) {
            redirect(base_url());
        } else {
            $data['articles'] = $this->model_blog->get_articles_by_page($num_page, $pagination['per_page']);
            $data['pagination'] = $this->pagination->create_links();
        }

        // Chargement de la vue
        $this->load->view('front/view_layout', $data);
    }


    public function view($c_slug = '', $a_slug = '', $num_page = 1) {

        // Retourne toutes les catégories (sidebar)
        $data['categories'] = $this->categories;

        // Dans le cas d'une catégorie
        if($this->uri->total_segments() == 1 or $this->uri->total_segments() == 3) :

            // Pagination
            $pagination = pagination_custom();
            $pagination['base_url'] = base_url($c_slug . '/page');
            $pagination['first_url'] = base_url($this->uri->segment(1));
            $pagination['total_rows'] = $this->model_blog->get_articles_by_category($c_slug)->num_rows();
            $pagination['num_links'] = round($pagination['total_rows'] / $pagination['per_page'] + 1);
            $pagination['uri_segment'] = 3; // ex : 'categorie-1/page/2'
            $this->pagination->initialize($pagination);

            if($num_page > $pagination['num_links']) {
                redirect(base_url());
            } else {
                // Récupération des articles par catégorie et avec pagination
                $data['articles'] = $this->model_blog->get_articles_by_category($c_slug, $num_page, $pagination['per_page']);
                if($data['articles']->num_rows() == 0) {
                    redirect(base_url());
                }

                // Génération de la pagination
                $data['pagination'] = $this->pagination->create_links();

                $row = $data['articles']->row();
                $data['page'] = 'categorie';
                $data['title'] = $row->ctitre;

                if($num_page > 1) {
                    $data['num_page'] = $num_page;
                }

            }

        // Dans le cas d'un article
        elseif($this->uri->total_segments() == 2):

            // Récupération de l'article
            $data['article'] = $this->model_blog->get_article_by_slug($c_slug, $a_slug);

            if($data['article']->num_rows() == 1) {
                $data['page'] = 'content';
                $row = $data['article']->row();
                $data['title'] = $data['a_titre'] = $row->atitre;
                $data['a_content'] = $row->contenu;
                $data['a_cdate'] = $row->cdate;
                $data['image'] = $row->image;
                $data['c_titre'] = $row->ctitre;
                $data['c_slug'] = $row->cslug;
                $data['username'] = $row->username;
                $comments = $this->model_blog->get_comment_for_article($row->art_id);
                $data['comments'] = [];
                if ($comments) {
                    foreach ($comments->result() as $comment) {
                        $data['comments'].append($comment);
                    }
                }
            } else {
                redirect(base_url());
            }

        else :
            redirect(base_url());
        endif;

        // On charge finalement la vue
        $this->load->view('front/view_layout', $data);
    }

    /**
     * Effectue une recherche multi-termes
     */
    public function search() {
        $terms = $this->input->get('terms', TRUE);
        $data['page'] = 'search';
        $data['categories'] = $this->categories;
        $data['terms'] = $terms;

        // Recherche des termes dans les articles
        $data['articles'] = $this->model_blog->search($terms);

        $this->load->view('front/view_layout', $data);
    }

    public function get_uploaded_picture($filename){
        $this->load->helper('upload');

        if( ! get_uploaded_picture($filename)){
            header("HTTP/1.1 404 Not found");
        }
    }
}

