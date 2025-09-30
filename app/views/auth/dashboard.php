<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function register()
    {
        $this->call->library('auth');

        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');
            $role     = 'user'; // all new users default to 'user'

            if ($this->auth->register($username, $password, $role)) {
                redirect('auth/login');
                return;
            } else {
                echo '❌ Registration failed!';
            }
        }

        $this->call->view('auth/register');
    }

    public function login()
    {
        $this->call->library('auth');

        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');

            if ($this->auth->login($username, $password)) {
                redirect('auth/dashboard');
                return;
            } else {
                echo '❌ Login failed!';
            }
        }

        $this->call->view('auth/login');
    }

    public function dashboard()
    {
        $this->call->library('auth');

        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
            return;
        }

        // Admins: redirect to UsersController index
        if ($this->auth->has_role('admin')) {
            redirect('users');
            return;
        }

        // Non-admins: reuse UsersController index
        $usersController = new UsersController();
        $usersController->index();
    }

    public function logout()
    {
        $this->call->library('auth');
        $this->auth->logout();
        redirect('auth/login');
    }
}
