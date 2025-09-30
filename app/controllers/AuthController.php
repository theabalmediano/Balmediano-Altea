<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        $this->call->library('Auth');
        $this->call->model('UsersModel');
    }

    public function register()
    {
        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');
            $role     = $this->io->post('role') ?? 'user';

            if ($this->auth->register($username, $password, $role)) {
                redirect(site_url('Auth/login'));
            } else {
                echo "❌ Registration failed!";
            }
        }

        // lowercase 'auth' since your views are in views/auth/
        $this->call->view('auth/register');
    }

    public function login()
    {
        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');

            if ($this->auth->login($username, $password)) {
                $role = $_SESSION['role'] ?? 'user';

                if ($role === 'admin') {
                    redirect(site_url('users')); // admin full access
                } else {
                    redirect(site_url('Auth/dashboard')); // normal user
                }
            } else {
                echo "❌ Login failed!";
            }
        }

        $this->call->view('auth/login');
    }

    public function dashboard()
    {
        if (!$this->auth->is_logged_in()) {
            redirect(site_url('Auth/login'));
        }

        $role = $_SESSION['role'] ?? 'user';
        if ($role === 'admin') {
            redirect(site_url('users'));
        }

        // search + pagination
        $page = $this->io->get('page') ?? 1;
        $q    = trim($this->io->get('q') ?? '');
        $records_per_page = 5;

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
            site_url('Auth/dashboard') . '?q=' . urlencode($q)
        );
        $data['page'] = $this->pagination->paginate();

        // use your own dashboard view for normal users
        $this->call->view('auth/dashboard', $data);
    }

    public function logout()
    {
        $this->auth->logout();
        redirect(site_url('Auth/login'));
    }
}
