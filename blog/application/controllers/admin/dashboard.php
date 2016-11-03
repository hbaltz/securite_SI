<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Seuls les utilisateurs authentifiés sont acceptés
        if(!$this->session->userdata('logged_in')) {
            redirect(base_url());
        }

        // Seuls les utilisateurs admin sont acceptés
        if(!$this->session->userdata('logged_in')['is_admin']) {
            redirect(base_url());
        }

        $this->load->model(array(
            'model_blog'
        ));
        $this->load->library(array('form_validation'));
        $this->load->helper(array('functions', 'text'));

        define('URL_LAYOUT', 'admin/view_dashboard_layout');
    }

    public function get_login() {
        $data = $this->session->userdata('logged_in');
        return $data['username'];
    }

    public function index() {
        $data['page'] = 'home';
        $this->load->view(URL_LAYOUT, $data);
    }

    public function articles() {
        $data['page'] = 'articles';
        $data['adminPage'] = 'Liste des articles';
        $data['articles'] = $this->model_blog->get_all_articles();

        $this->load->view(URL_LAYOUT, $data);
    }

    /**
     * Controleur ajoutant ou modifiant un article
     */
    public function manage_article($id = '') {

        // Récupération des catégories (liste déroulante)
        $data['categories'] = $this->model_blog->get_categories();

        // Mise en place du formulaire
        $this->form_validation->set_rules('titre', 'Titre', 'trim|required');
        $this->form_validation->set_rules('contenu', 'Contenu', 'trim|required');
        $this->form_validation->set_rules('categorie', 'Catégorie', 'required');

        $titre = $this->input->post('titre');
        $contenu = $this->input->post('contenu');
        $categorie = $this->input->post('categorie');

        // Récupération du helper d'upload
        $this->load->helper('upload');

        // Ajout d'un nouvel article
        if ($this->uri->total_segments() == 3) :
            $data['page'] = 'add_article';
            $data['adminPage'] = 'Nouvel article';
            $slug = url_title(convert_accented_characters($titre), '-', TRUE);

            if($this->form_validation->run() !== FALSE) :

                    // On upload et on resize l'image
                    $upload = custom_upload();

                    // Si tout s'est bien passé, on enregistre l'article en base
                    if($upload['error'] === FALSE) {
                        $this->model_blog->create_article($categorie, $titre, $contenu, $slug, $upload['file_name']);
                        $this->session->set_flashdata('success', 'Article "' . htmlentities($titre) . '" a bien été ajouté.');
                        redirect(base_url('dashboard/articles'));
                    } else {
                        $data['error'] = $upload['error'];
                    }

            endif;

        // Edition d'un article existant
        else:
            $data['page'] = 'edit_article';
            $data['adminPage'] = 'Edition';
            $row = $this->model_blog->get_article($id)->row();
            $data['titre'] = $row->titre;
            $data['contenu'] = $row->contenu;
            $data['cat_id'] = $row->rubrique_id;
            $data['image'] = $row->image;

            if($this->form_validation->run() !== FALSE) :

                // On modifie l'image si l'utilisateur en a envoyé une nouvelle
                $fileName = FALSE;
                if( ! empty($_FILES['image']['name'])) {
                    $upload = custom_upload();
                    $fileName = $upload['file_name'];
                }

                // On édite l'article si l'upload n'a pas renvoyé d'erreur
                if(($fileName === FALSE) OR ($fileName !== FALSE && $upload['error'] === FALSE)) {
                    $this->model_blog->update_article($categorie, $titre, $contenu, $id, $fileName);
                    $this->session->set_flashdata('success', 'Article "'. htmlentities($titre) .'" modifié.');
                    redirect(base_url('dashboard/articles'));
                } else {
                    $data['error'] = $upload['error'];
                }

            endif;

        endif;

        $this->load->view(URL_LAYOUT, $data);
    }


    /**
     * Supprime un article
     */
    public function delete_article($id) {

        if($this->model_blog->get_article($id)->num_rows() == 1) {
            $this->model_blog->delete_article($id);
            $this->session->set_flashdata('success', 'L\'article a bien été supprimé.');
        } else {
            $this->session->set_flashdata('error', 'Cet article n\'existe pas.');
        }

        redirect(base_url('dashboard/articles'));
    }

    /**
     * Affiche toutes les catégories
     */
    public function categories() {
        $data['page'] = 'categories';
        $data['adminPage'] = 'Liste des catégories';
        $data['categories'] = $this->model_blog->get_all_categories();

        $this->load->view(URL_LAYOUT, $data);
    }

    /**
     * Ajoute ou modifie une catégorie
     */
    public function manage_categorie($id = '') {

        // Contraintes du formulaire
        $this->form_validation->set_rules('titre', 'Titre', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');

        // Récupération des valeurs
        $titre = $this->input->post('titre');
        $description = $this->input->post('description');

        // Ajout d'une nouvelle catégorie
        if($this->uri->total_segments() == 3):
            $data['page'] = 'add_category';
            $data['adminPage'] = 'Nouvelle catégorie';

            $slug = url_title(convert_accented_characters($titre), '-', TRUE);

            if($this->form_validation->run() !== FALSE):
                $this->model_blog->create_category($titre, $description, $slug);
                $this->session->set_flashdata('success', 'Catégorie "'. htmlentities($titre) .'" créée.');
                redirect(base_url('dashboard/categories'));
            endif;

        // Modification d'une catégorie existante
        else:
            $data['page'] = 'edit_category';
            $data['adminPage'] = 'Edition';
            $row = $this->model_blog->get_category($id)->row();
            $data['titre'] = $row->titre;
            $data['description'] = $row->description;

            if($this->form_validation->run() !== FALSE) :
                $this->model_blog->update_category($titre, $description, $id);
                $this->session->set_flashdata('success', 'Catégorie "'. htmlentities($titre) .'" mise à jour.');
                redirect(base_url('dashboard/categories'));
            endif;

        endif;

        $this->load->view(URL_LAYOUT, $data);
    }

    /**
     * Supprime une catégorie
     */
    public function delete_categorie($id) {

        if($this->model_blog->get_category($id)->num_rows() == 1) {
            $this->model_blog->delete_category($id);
            $this->session->set_flashdata('success', 'La catégorie a bien été supprimée.');
        } else {
            $this->session->set_flashdata('error', 'Cette catégorie n\'existe pas.');
        }

        redirect(base_url('dashboard/categories'));
    }

}
