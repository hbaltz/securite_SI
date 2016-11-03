<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_blog extends CI_Model {


    /********** CATEGORY **************/

    /**
     * Retourne toutes les catégories
     * TODO : REMOVE
     */
    public function get_all_categories() {
        $this->db->select('id, titre, description, slug')
                 ->from('categorie')
                 ->order_by('id', 'DESC');

        $query = $this->db->get();
        return $query;
    }

    /**
     * Retourne l'ensemble des catégories
     */
    public function get_categories() {
        $this->db->select('id, titre, description, slug')
                 ->from('categorie')
                 ->order_by('id', 'DESC');

        $query = $this->db->get();
        return $query;
    }

    /**
     * Retourne une catégorie selon son id
     */
    public function get_category($id) {
        $this->db->select('id, titre, description, slug')
                 ->from('categorie')
                 ->where('id', $id)
                 ->limit(1);

        $query = $this->db->get();
        return $query;
    }

    /**
     * Créé une nouvelle catégorie
     */
    public function create_category($titre, $description, $slug) {
        $data = array(
            'titre' => $titre,
            'description' => $description,
            'slug' => $slug
        );
        $this->db->insert('categorie', $data);
    }

    /**
     * Met à jour une catégorie existante
     */
    public function update_category($titre, $description, $id) {
        $data = array(
            'titre' => $titre,
            'description' => $description
        );

        $this->db->where('id', $id)
                 ->update('categorie', $data);
    }

    /**
     * Supprime une catégorie
     */
    public function delete_category($id) {
        $this->db->where('id', $id)
                 ->delete('categorie');
    }


    /********** ARTICLE **************/

    /**
     * Retourne un article selon son id
     */
    public function get_article($id) {
        $this->db->select('id, rubrique_id, titre, contenu, slug, image')
                 ->from('article')
                 ->where('id', $id)
                 ->limit(1);

        $query = $this->db->get();
        return $query;
    }

    /**
     * Retourne un article basé sur son slug et celui de sa catégorie
     */
    public function get_article_by_slug($c_slug, $a_slug) {
        $this->db->select('article.id as art_id, article.titre as atitre, article.contenu, article.cdate, article.slug as aslug, article.image as image, categorie.titre as ctitre, categorie.slug as cslug, user.username as username')
                 ->from('article')
                 ->join('categorie', 'article.rubrique_id = categorie.id')
                 ->join('user', 'user.id = article.user_id')
                 ->where('article.slug', $a_slug)
                 ->where('categorie.slug', $c_slug);

        $query = $this->db->get();
        return $query;
    }


    /**
     * Retourne la liste des articles pour une catégorie donnée
     */
    function get_articles_by_category($c_slug, $num_page = false, $per_page = false)
    {
        $this->db->select('article.titre, article.contenu, article.cdate, article.slug as aslug, article.image as image, categorie.titre as ctitre, categorie.description as cdescription, categorie.slug as cslug, user.username as username')
                 ->from('article')
                 ->join('categorie', 'categorie.id = article.rubrique_id')
                 ->join('user', 'user.id = article.user_id')
                 ->where('categorie.slug', $c_slug)
                 ->order_by('article.id', 'DESC');

        if($num_page and $per_page):
            $this->db->limit($per_page, ($num_page-1) * $per_page);
        elseif($per_page):
            $this->db->limit($per_page);
        endif;

        $query = $this->db->get();
        return $query;
    }


    /**
     * Retourne l'ensemble des articles associés à leur catégorie
     */
    public function get_all_articles() {

        $this->db->select('article.id, article.titre, article.contenu, article.cdate, article.udate, article.slug as aslug, article.image as image, categorie.titre as ctitre, categorie.slug as cslug')
                 ->from('article')
                 ->join('categorie', 'categorie.id = article.rubrique_id')
                 ->order_by('article.id', 'DESC');

        $query = $this->db->get();
        return $query;

    }

    /**
     * Retourne les articles en mode pagination
     *
     * @param type $num_page
     * @param type $per_page
     */
    public function get_articles_by_page($num_page, $per_page) {
        $this->db->select('article.titre, article.contenu, article.cdate, article.slug as aslug, article.image as image, categorie.titre as ctitre, categorie.slug as cslug, user.username as username')
                 ->from('article')
                 ->join('categorie', 'categorie.id = article.rubrique_id')
                 ->join('user', 'user.id = article.user_id')
                 ->order_by('article.id', 'DESC');

        if($num_page) {
            $this->db->limit($per_page, ($num_page - 1) * $per_page);
        } else {
            $this->db->limit($per_page);
        }

        $query = $this->db->get();
        return $query;
    }

    /**
     * Effectue une recherche dans la table article
     */
    public function search($terms) {
        $terms_array = explode(' ', $terms);

        $this->db->select('article.titre, article.slug as aslug, categorie.slug as cslug')
                 ->from('article')
                 ->join('categorie', 'categorie.id = article.rubrique_id');

        $this->db->like('LOWER(article.titre)', strtolower($terms))
                 ->or_like('LOWER(contenu)', strtolower($terms));

        if(count($terms_array) > 1) :
            foreach($terms_array as $term) {
                $this->db->or_like('LOWER(article.titre)', strtolower($term))
                         ->or_like('LOWER(contenu)', strtolower($term));
            }
        endif;

        $query = $this->db->get();
        return $query;
    }



    /**
     * Créé un article
     */
    public function create_article($cat_id, $titre, $contenu, $slug, $image) {
        $date = new DateTime(null, new DateTimeZone('Europe/Paris'));

        $userdata = $this->session->userdata('logged_in');
        if (! $userdata['is_admin'])
            return;

        $data = array(
            'rubrique_id' => $cat_id,
            'user_id' => $userdata['id'],
            'titre' => $titre, // Pas htmlentities(() car reprise code existant
            'contenu' => $contenu, // Pas htmlentities(() car reprise code existant
            'cdate' => $date->format('Y-m-d H:i:s'),
            'udate' => $date->format('Y-m-d H:i:s'),
            'slug' => $slug,
            'image' => $image
        );

        $this->db->insert('article', $data);
    }

    /**
     * Met à jour un article existant
     */
    public function update_article($cat_id, $titre, $contenu, $id, $image = FALSE) {
        $date = new DateTime(null, new DateTimeZone('Europe/Paris'));

        $userdata = $this->session->userdata('logged_in');
        if (! $userdata['is_admin'])
            return;

        $data = array(
            'rubrique_id' => $cat_id,
            'titre' => $titre,
            'contenu' => $contenu,
            'udate' => $date->format('Y-m-d H:i:s')
        );

        // On modifie également l'image si une nouvelle a été envoyée
        if($image !== FALSE) {
            $data['image'] = $image;
        }

        $this->db->where('id', $id)
                 ->update('article', $data);
    }

    /**
     * Supprime un article
     */
    public function delete_article($id) {
        $userdata = $this->session->userdata('logged_in');
        if (! $userdata['is_admin'])
            return;

        $this->db->where('id', $id)
                 ->delete('article');
    }

    /********** COMMENTS **************/

    /**
     * Retourne la liste des articles pour une catégorie donnée
     */
    function get_comment_for_article($art_id)
    {
        $this->db->select('comment.contenu, comment.cdate, user.username as username')
                 ->from('comment')
                 ->join('user', 'user.id = comment.user_id')
                 ->where('comment.article_id', $art_id)
                 ->order_by('comment.id', 'DESC');

        $query = $this->db->get();
        return $query;
    }

    /**
     * Ajoute un commentaire sur un article
     */
    public function new_comment($art_id, $contenu) {
        $userdata = $this->session->userdata('logged_in');

        $data = array(
            'article_id' => $art_id,
            'user_id' => $userdata['id'],
            'contenu' => $contenu,
            'cdate' => $date->format('Y-m-d H:i:s'),
            'udate' => $date->format('Y-m-d H:i:s'),
        );

        $this->db->insert('comment', $data);
    }

    /**
     * Met à jour un commentaire existant
     */
    public function update_comment($com_id, $contenu) {
        $userdata = $this->session->userdata('logged_in');

        $date = new DateTime(null, new DateTimeZone('Europe/Paris'));
        $data = array(
            'contenu' => $contenu,
            'udate' => $date->format('Y-m-d H:i:s')
        );

        $this->db->where('id', $id)
                 ->where('user_id', $userdata['id'])
                 ->update('comment', $data);
    }

    /**
     * Supprime un commentaire
     */
    public function delete_comment($id) {
        $userdata = $this->session->userdata('logged_in');

        $this->db->where('id', $id)
                 ->where('user_id', $userdata['id'])
                 ->delete('comment');
    }


}
