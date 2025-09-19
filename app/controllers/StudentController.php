<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentsController extends Controller {

    public function __construct()
    {
        parent::__construct();
         $this->call->library('pagination'); 
    }

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

        
        $all = $this->StudentsModel->page($q, $records_per_page, $page);
        $data['students'] = $all['records'];
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

        $this->call->view('students/index', $data);
    }


    function create(){
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
           redirect(site_url());
        }else{
            echo 'Error creating student.';
        }
    }else{
        $this->call->view('students/create');
    }
    }

    function update($id){
    $students = $this->StudentsModel->find($id);
    if(!$students) {
        echo "Students not found.";
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
           redirect(uri: site_url());
        }else{
            echo 'Error updating student.';
        }
    }else{
        $data['student'] = $students;
        $this->call->view('students/update', $data);
    }
   
    }

    function delete($id){
        if($this->StudentsModel->delete($id)){
        redirect(uri: site_url());
    }else{
        echo 'Error deleting student.';
    }
    }
}