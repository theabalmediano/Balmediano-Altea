<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: UsersController
 */
class UsersController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    // Welcome page
    function welcome()
    {
        $this->call->view('Welcome');
    }
    
    // Show users list with pagination and search
    public function index()
    {
        // Current page
        $page = 1;
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $page = $this->io->get('page');
        }

        // Search query
        $q = '';
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $q = trim($this->io->get('q'));
        }

        $records_per_page = 5;

        // Get paginated users
        $all = $this->UsersModel->page($q, $records_per_page, $page);
        $data['users'] = $all['records'];
        $total_rows = $all['total_rows'];

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
            site_url() . '?q=' . urlencode($q)
        );
        $data['page'] = $this->pagination->paginate();

        $this->call->view('users/index', $data);
    }

    // Create a new user
    function create()
    {
        if($this->io->method() == 'post'){
            $fname = $this->io->post('first_name');
            $lname = $this->io->post('last_name');
            $email = $this->io->post('email');
            $data = [
                'first_name'=> $fname,
                'last_name' => $lname,
                'email'     => $email
            ];
            if($this->UsersModel->insert($data)) {
                redirect(site_url('users'));
            } else {
                echo 'Error';
            }
        } else {
            $this->call->view('users/create');
        }
    }

    // Update existing user
    function update($id)
    {
        $data['users'] = $this->UsersModel->find($id);

        if($this->io->method() == 'post'){
            $fname = $this->io->post('first_name');
            $lname = $this->io->post('last_name');
            $email = $this->io->post('email');
            $update_data = [
                'first_name'=> $fname,
                'last_name' => $lname, // fixed
                'email'     => $email
            ];
            if($this->UsersModel->update($id, $update_data)) {
                redirect(site_url('users'));
            } else {
                echo 'Error';
            }
        }

        $this->call->view('users/update', $data);
    }

    // Delete user permanently
    function delete($id)
    {
        if($this->UsersModel->delete($id)) {
            redirect(site_url('users'));
        } else {
            echo 'Error';
        }
    } 

    // Soft delete user
    function soft_delete($id)
    {
        if($this->UsersModel->soft_delete($id)) {
            redirect(site_url('users'));
        } else {
            echo 'Error';
        }
    }

    // Show soft-deleted users for restore
    function restore()
    {
        $page = 1;
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $page = $this->io->get('page');
        }

        $q = '';
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $q = trim($this->io->get('q'));
        }

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
        $this->pagination->set_theme('custom'); // or 'tailwind'
        $this->pagination->initialize(
            $total_rows, 
            $records_per_page, 
            $page, 
            site_url('users/restore?q='.$q)
        );
        $data['page'] = $this->pagination->paginate();

        $this->call->view('restore', $data);
    }

    // Restore soft-deleted user
    function retrieve($id)
    {
        if($this->UsersModel->restore($id)) {
            redirect(site_url('users'));
        } else {
            echo 'Error';
        }
    }
}
