<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /** LIST + PAGINATION + SEARCH **/
    public function index()
    {
        // current page
        $page = (int) ($this->io->get('page') ?? 1);

        // search query
        $q = trim($this->io->get('q') ?? '');

        $records_per_page = 5;

        $all = $this->UsersModel->page($q, $records_per_page, $page);
        $data['users'] = $all['records'];
        $total_rows    = $all['total_rows'];

        // pagination
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
            site_url() . '?q=' . urlencode($q)
        );
        $data['page'] = $this->pagination->paginate();

        $this->call->view('users/index', $data);
    }

    /** CREATE **/
    public function create()
    {
        if ($this->io->method() === 'post') {
            $data = [
                'fname' => $this->io->post('first_name'),
                'lname' => $this->io->post('lname'),
                'email' => $this->io->post('email')
            ];

            if ($this->UsersModel->insert($data)) {
                redirect();
            } else {
                echo 'Insert Error';
            }
        } else {
            $this->call->view('users/create');
        }
    }

    /** UPDATE **/
    public function update($id)
    {
        $data['user'] = $this->UsersModel->find($id);

        if ($this->io->method() === 'post') {
            $update = [
                'fname' => $this->io->post('fname'),
                'lname' => $this->io->post('lname'),
                'email' => $this->io->post('email')
            ];

            if ($this->UsersModel->update($id, $update)) {
                redirect();
            } else {
                echo 'Update Error';
            }
        }

        $this->call->view('users/update', $data);
    }

    /** HARD DELETE (use POST for security) **/
    public function delete($id)
    {
        if ($this->io->method() !== 'post') {
            show_error('Invalid request method', 405);
            return;
        }

        if ($this->UsersModel->delete($id)) {
            redirect();
        } else {
            echo 'Delete Error';
        }
    }

    /** SOFT DELETE **/
    public function soft_delete($id)
    {
        if ($this->UsersModel->soft_delete($id)) {
            redirect();
        } else {
            echo 'Soft Delete Error';
        }
    }

    /** LIST OF SOFT-DELETED USERS **/
    public function restore()
    {
        $page = (int) ($this->io->get('page') ?? 1);
        $q    = trim($this->io->get('q') ?? '');
        $records_per_page = 5;

        $all = $this->UsersModel->restore_page($q, $records_per_page, $page);
        $data['users'] = $all['records'];
        $total_rows    = $all['total_rows'];

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
            site_url('users/restore?q=' . urlencode($q))
        );
        $data['page'] = $this->pagination->paginate();

        $this->call->view('users/restore', $data);
    }

    /** RESTORE a single user **/
    public function retrieve($id)
    {
        if ($this->UsersModel->restore($id)) {
            redirect('users/restore');
        } else {
            echo 'Restore Error';
        }
    }
}
