<?php
class AuthController extends Controller
{
    public function register()
    {
        $this->call->library('auth');

        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');
            $role = $this->io->post('role') ?? 'user';

            if ($this->auth->register($username, $password, $role)) {
                redirect('/auth/login');
            } else {
                // Optional: Show registration error message here
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
                // Redirect based on role
                if ($this->auth->has_role('admin')) {
                    redirect('/users');  // Full access page
                } else {
                    redirect('auth/dashboard');  // User view-only page
                }
            } else {
                echo 'Login failed!';
            }
        }

        $this->call->view('auth/login');
    }

    public function dashboard()
    {
        $this->call->library('auth');

        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
            exit;
        }

        $role = $_SESSION['role'] ?? 'user';

        // Admins redirect to /users
        if ($role === 'admin') {
            redirect('/users');
            exit;
        }

        // --- USER VIEW (students list with search + pagination) ---
        $this->call->model('UsersModel');

        $page = isset($_GET['page']) ? (int) $this->io->get('page') : 1;
        $q = isset($_GET['q']) ? trim($this->io->get('q')) : '';

        $records_per_page = 5;

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

        // Build base URL for pagination links (matching this dashboard view)
        $base_url = site_url('auth/dashboard');
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

        $this->call->view('auth/dashboard', $data);
    }

    public function logout()
    {
        $this->call->library('auth');
        $this->auth->logout();
        redirect('auth/login');
        exit;
    }
}
?>
