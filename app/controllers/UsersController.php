<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: UsersController
 * CRUD + Soft Delete + Restore for Users
 */
class UsersController extends Controller {

    public function __construct()
    {
        parent::__construct();

        // 🔹 Load libraries
        $this->call->library('pagination');  // para sa pagination
        $this->call->library('auth');        // kung may login system ka

        // 🔹 Load model
        $this->call->model('UsersModel');

        // (Optional) Check kung dapat naka-login
        // if (!$this->auth->is_logged_in()) {
        //     redirect('auth/login');
        //     exit();
        // }
    }

    /** 📄 Pakita (List Users) */
    public function index()
    {
        $page = (int) $this->io->get('page', 1);
        $q    = trim($this->io->get('q', ''));

        $records_per_page = 5;

        $all = $this->UsersModel->page($q, $records_per_page, $page);
        $data['users']     = $all['records'];
        $total_rows        = $all['total_rows'];

        // Pagination
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
            site_url('/users') . '?q=' . urlencode($q)
        );

        $data['page'] = $this->pagination->paginate();
        $this->call->view('users/index', $data);
    }

    /** ➕ Pasok (Create User) */
    public function create()
    {
        if ($this->io->method() === 'post') {
            $fname = trim($this->io->post('first_name'));
            $lname = trim($this->io->post('last_name'));
            $email = trim($this->io->post('email'));

            $data = [
                'first_name' => $fname,
                'last_name'  => $lname,
                'email'      => $email
            ];

            if ($this->UsersModel->insert($data)) {
                redirect(site_url('/users'));
                exit();
            } else {
                echo '⚠️ Error creating user.';
            }
        } else {
            $this->call->view('users/create');
        }
    }

    /** ✏️ Edit (Update User) */
    public function update($id)
    {
        $data['user'] = $this->UsersModel->find($id);
        if (!$data['user']) {
            echo '⚠️ User not found.';
            return;
        }

        if ($this->io->method() === 'post') {
            $fname = trim($this->io->post('first_name'));
            $lname = trim($this->io->post('last_name'));
            $email = trim($this->io->post('email'));

            $update_data = [
                'first_name' => $fname,
                'last_name'  => $lname,
                'email'      => $email
            ];

            if ($this->UsersModel->update($id, $update_data)) {
                redirect(site_url('/users'));
                exit();
            } else {
                echo '⚠️ Error updating user.';
            }
        }

        $this->call->view('users/update', $data);
    }

    /** ❌ Hard Delete */
    public function delete($id)
    {
        if ($this->UsersModel->delete($id)) {
            redirect(site_url('/users'));
            exit();
        } else {
            echo '⚠️ Error deleting user.';
        }
    }

    /** 🗑️ Soft Delete */
    public function soft_delete($id)
    {
        if ($this->UsersModel->soft_delete($id)) {
            redirect(site_url('/users'));
            exit();
        } else {
            echo '⚠️ Error soft-deleting user.';
        }
    }

    /** 🔄 Restore Page (List of Soft Deleted Users) */
    public function restore()
    {
        $page = (int) $this->io->get('page', 1);
        $q    = trim($this->io->get('q', ''));

        $records_per_page = 5;
        $all = $this->UsersModel->restore_page($q, $records_per_page, $page);

        $data['users']     = $all['records'];
        $total_rows        = $all['total_rows'];

        $this->pagination->set_options([
            'first_link'     => '⏮ First',
            'last_link'      => 'Last ⏭',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);
        $this->pagination->set_theme('custom'); // or 'tailwind'
        $this->pagination->initialize(
            $total_rows,
            $records_per_page,
            $page,
            site_url('/users/restore') . '?q=' . urlencode($q)
        );

        $data['page'] = $this->pagination->paginate();
        $this->call->view('users/restore', $data);
    }

    /** ♻️ Retrieve (Single Restore) */
    public function retrieve($id)
    {
        if ($this->UsersModel->restore($id)) {
            redirect(site_url('/users/restore'));
            exit();
        } else {
            echo '⚠️ Error restoring user.';
        }
    }
}
