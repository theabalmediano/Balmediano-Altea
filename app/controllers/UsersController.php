<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    // List users with pagination
    public function index() {
        $page = $this->io->get('page') ?? 1;
        $q = trim($this->io->get('q')) ?? '';
        $recordsPerPage = 5;

        $all = $this->UsersModel->getPaginated($q, $recordsPerPage, $page);
        $data['users'] = $all['records'];
        $totalRows = $all['total_rows'];

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
            $totalRows,
            $recordsPerPage,
            $page,
            site_url() . '?q=' . urlencode($q)
        );
        $data['page'] = $this->pagination->paginate();

        $this->call->view('users/index', $data);
    }

    // Create user
    public function create() {
        if ($this->io->method() == 'post') {
            $data = [
                'first_name' => $this->io->post('first_name'),
                'last_name'  => $this->io->post('last_name'),
                'email'      => $this->io->post('email')
            ];

            if ($this->UsersModel->insert($data)) {
                redirect('users'); // ensures consistent pagination
            } else {
                echo 'Error adding user';
            }
        } else {
            $this->call->view('users/create');
        }
    }

    // Update user
    public function update($id) {
        $data['user'] = $this->UsersModel->find($id);

        if ($this->io->method() == 'post') {
            $dataUpdate = [
                'first_name' => $this->io->post('first_name'),
                'last_name'  => $this->io->post('last_name'),
                'email'      => $this->io->post('email')
            ];

            if ($this->UsersModel->update($id, $dataUpdate)) {
                redirect('users');
            } else {
                echo 'Error updating user';
            }
        } else {
            $this->call->view('users/update', $data);
        }
    }

    // Delete user
    public function delete($id) {
        if ($this->UsersModel->delete($id)) {
            redirect('users');
        } else {
            echo 'Error deleting user';
        }
    }

    // Soft delete
    public function softDelete($id) {
        if ($this->UsersModel->softDelete($id)) {
            redirect('users');
        } else {
            echo 'Error soft deleting user';
        }
    }

    // Restore deleted users page
    public function restore() {
        $page = $this->io->get('page') ?? 1;
        $q = trim($this->io->get('q')) ?? '';
        $recordsPerPage = 5;

        $all = $this->UsersModel->restorePage($q, $recordsPerPage, $page);
        $data['users'] = $all['records'];
        $totalRows = $all['total_rows'];

        $this->pagination->set_options([
            'first_link'     => '⏮ First',
            'last_link'      => 'Last ⏭',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);
        $this->pagination->set_theme('default');
        $this->pagination->initialize($totalRows, $recordsPerPage, $page, site_url('users/restore?q=' . urlencode($q)));
        $data['page'] = $this->pagination->paginate();

        $this->call->view('users/restore', $data);
    }

    // Restore single user
    public function retrieve($id) {
        if ($this->UsersModel->restore($id)) {
            redirect('users/restore');
        } else {
            echo 'Error restoring user';
        }
    }
}
