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
                return;
            } else {
                $data['errors'] = $this->auth->get_register_errors();
                $this->call->view('auth/register', $data);
                return;
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
                if ($this->auth->has_role('admin')) {
                    redirect('/users');
                } else {
                    redirect('auth/dashboard');
                }
                return;
            } else {
                $data['errors'] = $this->auth->get_login_errors();
                $this->call->view('auth/login', $data);
                return;
            }
        }

        $this->call->view('auth/login');
    }

    public function logout()
    {
        $this->call->library('auth');
        $this->auth->logout();
        redirect('auth/login');
        return;
    }
}
?>
