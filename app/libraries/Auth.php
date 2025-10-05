<?php
class Auth
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $lava = lava_instance();
        $lava->call->database();
        $lava->call->library('session');

        $this->db = $lava->db;
        $this->session = $lava->session;
    }

    public function register($username, $password, $confirm_password = null, $role = 'user')
    {
        $errors = [];

        // Confirm password check
        if ($confirm_password === null) {
            $errors[] = "Confirm password is required.";
        } elseif ($password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }

        // Password validation (main password only)
        if(strlen($password) < 8){
            $errors[] = "Password must be at least 8 characters.";
        }

        if(!preg_match('/[A-Z]/', $password) || 
           !preg_match('/[a-z]/', $password) || 
           !preg_match('/[0-9]/', $password) || 
           !preg_match('/[\W]/', $password)){
            $errors[] = "Password must include uppercase, lowercase, number, and special character.";
        }

        // Check kung existing na yung username
        $existing = $this->db->table('users')->where('username', $username)->get();
        if($existing){
            $errors[] = "Username already taken.";
        }

        // Kapag may error, ibalik
        if(!empty($errors)){
            $this->session->set_userdata('register_errors', $errors);
            return false;
        }

        // Kung pasado lahat, insert user
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $this->db->table('users')->insert([
            'username' => $username,
            'password' => $hash,
            'role'     => $role,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function login($username, $password)
    {
        $user = $this->db->table('users')->where('username', $username)->get();

        if (!$user){
            $this->session->set_userdata('login_errors', ["Username not found"]);
            return false;
        }

        if (!password_verify($password, $user['password'])){
            $this->session->set_userdata('login_errors', ["Password is incorrect"]);
            return false;
        }

        $this->session->set_userdata([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'logged_in' => true
        ]);
        return true;
    }

    public function is_logged_in()
    {
        return (bool) $this->session->userdata('logged_in');
    }

    public function has_role($role)
    {
        return $this->session->userdata('role') === $role;
    }

    public function logout()
    {
        $this->session->unset_userdata(['user_id','username','role','logged_in']);
    }

    public function get_register_errors()
    {
        $errors = $this->session->userdata('register_errors') ?? [];
        $this->session->unset_userdata('register_errors');
        return $errors;
    }

    public function get_login_errors()
    {
        $errors = $this->session->userdata('login_errors') ?? [];
        $this->session->unset_userdata('login_errors');
        return $errors;
    }
}
?>
