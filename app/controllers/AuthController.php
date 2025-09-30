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

            // All new users default to 'user'
            $role = 'user';

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

        // Redirect admin to /users list
        if ($this->auth->has_role('admin')) {
            redirect('users');
            return;
        }

        // Non-admin users: show users table with pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $q    = trim($this->io->get('q') ?? '');
        $records_per_page = 5;

        $this->call->model('UsersModel');
        $all = $this->UsersModel->page($q, $records_per_page, $page);

        $data['users'] = $all['records'];
        $total_rows = $all['total_rows'];

        $this->call->library('pagination');
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
            site_url('users') . '?q=' . urlencode($q)
        );
        $data['page'] = $this->pagination->paginate();

        // Use the correct view
        $this->call->view('users/index', $data);
    }

    public function logout()
    {
        $this->call->library('auth');
        $this->auth->logout();
        redirect('auth/login');
    }
}
