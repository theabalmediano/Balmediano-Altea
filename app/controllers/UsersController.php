<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->call->model('UsersModel');
    }

    public function index()
    {
        // Current page, default to 1
        $page = 1;
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $page = (int) $this->io->get('page');
            if ($page < 1) $page = 1; // Ensure page number >= 1
        }

        // Search query
        $q = '';
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $q = trim($this->io->get('q'));
        }

        $records_per_page = 5;

        // Get paginated data
        $all = $this->UsersModel->page($q, $records_per_page, $page);
        $data['users'] = $all['records'];
        $total_rows = $all['total_rows'];

        // Pagination setup
        $this->pagination->set_options([
            'first_link'     => '⏮ First',
            'last_link'      => 'Last ⏭',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);

        $this->pagination->set_theme('default');

        // Build base URL for pagination links
        $base_url = site_url('/users');
        if (!empty($q)) {
            $base_url .= '?q=' . urlencode($q);
        }

        $this->pagination->initialize(
            $total_rows,
            $records_per_page,
            $page,
            $base_url
        );
        $data['page'] = $this->pagination->paginate();

        $this->call->view('users/index', $data);
    }

    public function create()
    {
        // Only admin allowed
        if ($_SESSION['role'] !== 'admin') {
            redirect(site_url('auth/dashboard'));
            exit;
        }

        if ($this->io->method() == 'post') {
            $firstname = $this->io->post('first_name');
            $lastname = $this->io->post('last_name');
            $email = $this->io->post('email');

            $data = [
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $email
            ];

            if ($this->UsersModel->insert($data)) {
                redirect(site_url('/users'));
            } else {
                echo 'Error creating student.';
            }
        } else {
            $this->call->view('users/create');
        }
    }

    public function update($id)
    {
        // Only admin allowed
        if ($_SESSION['role'] !== 'admin') {
            redirect(site_url('auth/dashboard'));
            exit;
        }

        $user = $this->UsersModel->find($id);
        if (!$user) {
            echo "User not found.";
            return;
        }

        if ($this->io->method() == 'post') {
            $firstname = $this->io->post('first_name');
            $lastname = $this->io->post('last_name');
            $email = $this->io->post('email');

            $data = [
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $email
            ];

            if ($this->UsersModel->update($id, $data)) {
                redirect(site_url('/users'));
            } else {
                echo 'Error updating student.';
            }
        } else {
            $data['user'] = $user;
            $this->call->view('users/update', $data);
        }
    }

    public function delete($id)
    {
        // Only admin allowed
        if ($_SESSION['role'] !== 'admin') {
            redirect(site_url('auth/dashboard'));
            exit;
        }

        if ($this->UsersModel->delete($id)) {
            redirect(site_url('/users'));
        } else {
            echo 'Error deleting users.';
        }
    }
}
