<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function register()
    {
        $this->call->library('auth');

        if ($this->io->method() == 'post') {
            $username = trim($this->io->post('username'));
            $password = $this->io->post('password');
            $confirm_password = $this->io->post('confirm_password');
            $role = $this->io->post('role') ?? 'user';

            if ($this->auth->register($username, $password, $confirm_password, $role)) {
                redirect('/auth/login');
                return;
            } else {
                $data['errors'] = $this->auth->get_register_errors();
                $this->call->view('auth/register', $data);
                return;
            }
        }

        $this->call->view('auth/register');
    }

    public function login()
    {
        $this->call->library('auth');

        if ($this->io->method() == 'post') {
            $username = trim($this->io->post('username'));
            $password = $this->io->post('password');

            if ($this->auth->login($username, $password)) {
                if ($this->auth->has_role('admin')) {
                    redirect('/users'); // Admin dashboard
                } else {
                    redirect('/auth/dashboard'); // User dashboard
                }
                return;
            } else {
                $data['errors'] = $this->auth->get_login_errors();
                $this->call->view('auth/login', $data);
                return;
            }
        }

        $this->call->view('auth/login');
    }

    public function dashboard()
    {
        $this->call->library('auth');

        if (!$this->auth->is_logged_in()) {
            redirect('/auth/login');
        }

        $role = $_SESSION['role'] ?? 'user';

        if ($role === 'admin') {
            redirect('/users');
        }

        // For regular users: load read-only user list
        $this->call->model('UsersModel');

        $page = isset($_GET['page']) ? (int) $this->io->get('page') : 1;
        $q = isset($_GET['q']) ? trim($this->io->get('q')) : '';

        $records_per_page = 5;
        $all = $this->UsersModel->page($q, $records_per_page, $page);
        $data['users'] = $all['records'];
        $total_rows = $all['total_rows'];

        $this->pagination->set_options([
            'first_link'     => '⏮ First',
            'last_link'      => 'Last ⏭',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);

        $this->pagination->set_theme('default');
        $this->pagination->initialize(
            $total_rows,
            $records_per_page,
            $page,
            site_url('/auth/dashboard') . '?q=' . urlencode($q)
        );

        $data['page'] = $this->pagination->paginate();

        $this->call->view('auth/dashboard', $data);
    }

    public function logout()
    {
        $this->call->library('auth');

        // Logout user
        $this->auth->logout();

        // Redirect to login page (not register)
        redirect('/auth/login');
    }
}
