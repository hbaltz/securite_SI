<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include(APPPATH.'libraries/password.php');

class Model_user extends CI_Model {

    /**
     * Enregistre un nouvel utilisateur non admin (uniquement pour les commentaires)
     * (Il aura été vérifié au préalable qu'aucun utilisateur avec ce login ou
     *  cet email n'existe déjà)
     */
    public function register($username, $password, $email) {

        $password = $this->password_hash($password);

        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        );

        $this->db->insert('user', $data);
        return true;

    }

    public function send_activation_token($username) {
        // 1) Récupération des infos liées à l'utilisateur
        $this->db->select('id, email')
                 ->from('user')
                 ->where('username', $username)
                 ->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() != 1) {
            return TRUE;
        }
        $userdata = $query->row();

        // 2) Y a t il dejà un token d'envoyer en attente d'activation ?
        $this->db->select('*')
                 ->from('activation_token')
                 ->where('user_id', $userdata->id)
                 ->where('expire <','to_timestamp('.time().')', FALSE)
                 ->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return TRUE;
        }

        // 3) Preparation du token et enregistrement dans la BDD ?
        $token = base64_encode(mcrypt_create_iv($config['activation_token_len'], MCRYPT_DEV_URANDOM)); // Necessite la librairie php5-mcrypt

        $this->db->set('user_id', $userdata->id);
        $this->db->set('token', $token);
        $this->db->set('expire', 'to_timestamp('.(time() +
            $config['activation_token_duration']).')', FALSE);
        $this->db->insert('activation_token');

        // 4) Envoie du token par email
        // Le 5ème paramètre de l'appel mail '-fbounce@stage-gtsi.fr'
        // permet de forcer l'enveloppe FROM du mail et ainsi éviter une
        // potentielle fuite d'information du système
        $message = ("User:" . htmlentities($username) . "\r\n" .
            "Code d'activation : " .
            base_url('activation') .
            "?email=" . urlencode($userdata->email).
            "&token=". urlencode("$token"));

        mail('utilisateur@stage-gtsi.fr', 'Activation', $message,
            null, "-fbounce@stage-gtsi.fr");
        return TRUE;
    }

    public function activate_user($email, $token) {
        // 1) Récupération des infos liées à l'utilisateur
        $this->db->select('id')
                 ->from('user')
                 ->where('email', $email)
                 ->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() != 1) {
            // Aucun compte associé à cet email
            return FALSE;
        }
        $userdata = $query->row();

        // 2) Recherche du token d'activation
        $this->db->select('*')
                 ->from('activation_token')
                 ->where('user_id', $userdata->id)
                 ->where('expire <','to_timestamp('.(time()
                    + $config['activation_token_duration']).')', FALSE)
                 ->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() != 1) {
            // Aucun token trouvé
            return FALSE;
        }

        $data = array ('activated' => '1');
        // 3) Activation du compte
        $this->db->where('id', $userdata->id)
                 ->update('user', $data);
        return TRUE;
    }


    /**
     * Vérifie si le couple username/password existe en base
     */
    public function login($username, $password) {

        $this->db->select('*')
                 ->from('user')
                 ->where('username', $username)
                 ->where('activated', '1')
                 ->limit(1);

        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->row();
            if($this->password_verify($password,$row->password))
                return $row;
            else
                return false;
        } else {
            return false;
        }
    }


    /**
     * Retourne vrai si un utilisateur existe avec ce login
     */
    public function login_exists($username) {
        $this->db->select('id')
                 ->from('user')
                 ->where('username', $username)
                 ->limit(1);

        $query = $this->db->get();

        if($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retourne vrai si un utilisateur existe avec cet email
     */
    public function email_exists($email) {
        $this->db->select('id')
                 ->from('user')
                 ->where('email', $email)
                 ->limit(1);

        $query = $this->db->get();

        if($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }


    public function password_hash($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function password_verify($password,$hash){
        return password_verify($password,$hash);
    }

    /**
     * Retrouve un user à l'aide du nom
     */
    public function userByName($username) {

        $this->db->select('*')
                 ->from('user')
                 ->where('username', $username)
                 ->limit(1);

        return $this->db->get()->row();

    }

     /**
     * Insere un user dans la bd
     */
    public function insertUser($username) {
        return $this->register($username,0,0);
    }

}
