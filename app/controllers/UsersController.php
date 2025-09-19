<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    function welcome()
    {
        $this->call->view('Welcome');
    }

    public function index()
    {
        $page = $this->io->get('page') ?: 1;
        $q = trim($this->io->get('q') ?? '');
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
        $this->pagination->initialize($total_rows, $records_per_page, $page, site_url() . '?q=' . urlencode($q));
        $data['page'] = $this->pagination->paginate();

        $this->call->view('users/index', $data);
    }

    function create()
    {
        if($this->io->method() == 'post'){
            $data = [
                'first_name'=> $this->io->post('first_name'),
                'last_name' => $this->io->post('last_name'),
                'email'     => $this->io->post('email')
            ];
            if($this->UsersModel->insert($data)) {
                redirect(site_url('users'));
            } else {
                echo 'Error creating user';
            }
        } else {
            $this->call->view('users/create');
        }
    }

    function update($id)
    {
        $data['users'] = $this->UsersModel->find($id);
        if($this->io->method() == 'post'){
            $update_data = [
                'first_name'=> $this->io->post('first_name'),
                'last_name' => $this->io->post('last_name'),
                'email'     => $this->io->post('email')
            ];
            if($this->UsersModel->update($id, $update_data)) {
                redirect(site_url('users'));
            } else {
                echo 'Error updating user';
            }
        }
        $this->call->view('users/update', $data);
    }

    function delete($id)
    {
        if($this->UsersModel->delete($id)) {
            redirect(site_url('users'));
        } else {
            echo 'Error deleting user';
        }
    }

    function soft_delete($id)
    {
        if($this->UsersModel->soft_delete($id)) {
            redirect(site_url('users'));
        } else {
            echo 'Error soft deleting user';
        }
    }

    function restore()
    {
        $page = $this->io->get('page') ?: 1;
        $q = trim($this->io->get('q') ?? '');
        $records_per_page = 5;

        $all = $this->UsersModel->restore_page($q, $records_per_page, $page);
        $data['users'] = $all['records'];
        $total_rows = $all['total_rows'];

        $this->pagination->set_options([
            'first_link'     => '⏮ First',
            'last_link'      => 'Last ⏭',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);
        $this->pagination->set_theme('custom');
        $this->pagination->initialize($total_rows, $records_per_page, $page, site_url('users/restore?q='.$q));
        $data['page'] = $this->pagination->paginate();

        $this->call->view('users/restore', $data);
    }

    function retrieve($id)
    {
        if($this->UsersModel->restore($id)) {
            redirect(site_url('users'));
        } else {
            echo 'Error restoring user';
        }
    }
}
