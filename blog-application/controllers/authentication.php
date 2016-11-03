<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper(array('functions'));
        $this->load->model(array('model_user'));
    }

    /**
     * Formulaire d'enregistrement
     */
    public function register() {
        if(!$this->session->userdata('logged_in')) :

            // Mise en place des règles de validation
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Nom d\'utilisateur', 'trim|required|callback_check_user_not_exists');
            $this->form_validation->set_rules('email', 'Adresse email', 'trim|required|callback_check_email_not_exists');
            $this->form_validation->set_rules('password1', 'Confirmation mot de passe', 'trim|required|callback_check_password_confirmation');
            $this->form_validation->set_rules('password', 'Mot de passe', 'trim|required');

            // Si le formulaire est invalide
            if($this->form_validation->run() == FALSE) {
                $this->load->view('admin/view_form_register');
            } else {
                $username = $this->input->post('username');
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $this->model_user->register($username, $password, $email);
                $this->model_user->send_activation_token($username);

                $this->session->set_flashdata('success', 'Vous êtes désormais enregistré.');
                redirect(base_url('dashboard'));
            }

        else :
            redirect(base_url('dashboard'));
        endif;
    }

    /**
     * Callback Vérifie la confirmation de mot de passe.
     */
    public function check_password_confirmation($password1) {
        $password = $this->input->post('password');
        if ($password !== $password1)
        {
            $this->form_validation->set_message('check_password_confirmation', 'Erreur dans la confirmation de mot de passe');
            return FALSE;
        }
        else
            return TRUE;
    }

    /**
     * Callback Vérifie que l'utilisateur n'existe pas déjà
     */
    public function check_user_not_exists($username) {
        if ($this->model_user->login_exists($username))
        {
            $this->form_validation->set_message('check_user_not_exists', 'Ce login est déjà pris.');
            return FALSE;
        }
        else
            return TRUE;
    }

    /**
     * Callback Vérifie que l'adresse email n'est pas déjà utilisée
     */
    public function check_email_not_exists($email) {
        if ($this->model_user->email_exists($email))
        {
            $this->form_validation->set_message('check_email_not_exists', 'Un utilisateur est déjà enregistré avec cette adresse email.');
            return FALSE;
        }
        else
            return TRUE;
    }

    public function activation() {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $this->load->library('form_validation');


        if ((!$email) or (!$token))
            return FALSE;
        else
        {
            if ($this->model_user->activate_user($email, $token))
                $this->session->set_flashdata('success', 'Votre compte est désormais activé.');
        }
        $this->load->view('admin/view_form_login');
    }


    /**
     * Formulaire d'authentification
     */
    public function login() {
        if(!$this->session->userdata('logged_in')) :

            // Mise en place des règles de validation
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Nom d\'utilisateur', 'trim|required');
            $this->form_validation->set_rules('password', 'Mot de passe', 'trim|required|callback_check_credentials');

            // Si le formulaire est invalide
            if($this->form_validation->run() == FALSE) {
                $this->load->view('admin/view_form_login');
            } else {
                $this->session->set_flashdata('success', 'Vous êtes désormais authentifié.');
                redirect(base_url('dashboard'));
            }

        else :
            redirect(base_url('dashboard'));
        endif;
    }


    /**
     * Callback vérifiant si le couple username/password existe en base
     */
    public function check_credentials($password) {
        $username = $this->input->post('username');
        $user = $this->model_user->login($username, $password);

        if($user) :
            $sess = array(
                'id' => $user->id,
                'username' => $user->username,
                'is_admin' => ($user->is_admin == 't')
            );

            // Création de la session
            $this->session->set_userdata('logged_in', $sess);
            return TRUE;

        else:
            $this->form_validation->set_message('check_credentials', 'Login ou mot de passe incorrect');
            return FALSE;

        endif;
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Vous êtes désormais déconnecté.');
        redirect(base_url());
    }

}
