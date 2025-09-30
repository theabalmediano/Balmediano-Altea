<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentsController extends Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Load necessary libraries
        $this->call->library('pagination'); 
        $this->call->library('auth'); // 🔹 load Auth library

        // Check if user is logged in
        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        // All users can view the student list
        $page = 1;
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $page = $this->io->get('page');
        }

        $q = '';
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $q = trim($this->io->get('q'));
        }

        $records_per_page = 5;

        $all = $this->StudentsModel->page($q, $records_per_page, $page);
        $data['students'] = $all['records'];
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
        $this->pagination->initialize(
            $total_rows,
            $records_per_page,
            $page,
            site_url('/students') . '?q=' . urlencode($q)
        );
        $data['page'] = $this->pagination->paginate();

        $this->call->view('students/index', $data);
    }

    function create(){
        if ($_SESSION['role'] !== 'admin') {
    // redirect regular users to the dashboard
    redirect(site_url('auth/dashboard'));
    exit;
}


        if ($this->io->method() == 'post') {
            $firstname= $this->io->post('first_name');
            $lastname= $this->io->post('last_name');
            $email= $this->io->post('email');

            $data = array(
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $email
            );

            if ($this->StudentsModel->insert($data)) {
                redirect(site_url('/students'));
            } else {
                echo 'Error creating student.';
            }
        } else {
            $this->call->view('students/create');
        }
    }

    function update($id){
        if ($_SESSION['role'] !== 'admin') {
    // redirect regular users to the dashboard
    redirect(site_url('auth/dashboard'));
    exit;
}


        $students = $this->StudentsModel->find($id);
        if(!$students) {
            echo "Student not found.";
            return;
        }

        if ($this->io->method() == 'post') {
            $firstname= $this->io->post('first_name');
            $lastname= $this->io->post('last_name');
            $email= $this->io->post('email');

            $data = array(
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $email
            );

            if ($this->StudentsModel->update($id, $data)) {
                redirect(site_url('/students'));
            } else {
                echo 'Error updating student.';
            }
        } else {
            $data['student'] = $students;
            $this->call->view('students/update', $data);
        }
    }

    function delete($id){
        if ($_SESSION['role'] !== 'admin') {
    // redirect regular users to the dashboard
    redirect(site_url('auth/dashboard'));
    exit;
}


        if($this->StudentsModel->delete($id)){
            redirect(site_url('/users'));
        } else {
            echo 'Error deleting student.';
        }
    }
}
