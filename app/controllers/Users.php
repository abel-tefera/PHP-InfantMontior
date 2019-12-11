<?php
class Users extends Controller
{

    public function __construct()
    {
        $this->Model = $this->model('User');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        flash('info', 'You have successfully logged out');
        redirect('pages/index');
    }

    public function login()
    {
        if (!($this->isLoggedIn())) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'username' => trim($_POST['username']),
                    'password' => trim($_POST['password']),
                    'username_err' => '',
                    'password_err' => '',
                ];

                if (empty($data['username'])) {
                    $data['username_err'] = 'Please enter username';
                }

                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter password';
                }

                if ($this->Model->findUserByUsername($data['username']) == false) {
                    $data['username_err'] = 'No user found';
                } else {
                    $role = $this->Model->getUserByUsername($data['username'])->Role;
                    // die($role);
                }
                if (empty($data['username_err']) && empty($data['password_err'])) {
                    // die("HERE");
                    $loggedInUser = $this->Model->login($data['username'], $data['password']);
                    if ($loggedInUser) {
                        // $this->logout();
                        $this->createUserSession($loggedInUser);
                    } else {
                        $data['password_err'] = 'Password incorrect';
                        $this->view('users/login', $data);
                    }
                } else {
                    $this->view('users/login', $data);
                }

            } else {
                $data = [
                    'username' => '',
                    'password' => '',
                    'username_err' => '',
                    'password_err' => '',
                ];
                $this->view('users/login', $data);
            }
        } else {
            redirect('pages/index');
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_username'] = $user->Username;
        $_SESSION['user_name'] = $user->Name;
        $_SESSION['user_role'] = $user->Role;
        redirect('pages/index');
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function register()
    {

        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Admin') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'name' => trim($_POST['name']),
                    'username' => trim($_POST['username']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'role' => trim($_POST['role']),
                    'name_err' => '',
                    'username_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                ];

                if (empty($data['username'])) {
                    $data['username_err'] = 'Please enter a username';
                    if (empty($data['name'])) {
                        $data['name_err'] = 'Please enter a name';
                    }
                } else {
                    if ($this->Model->findUserByUsername($data['username'])) {
                        $data['username_err'] = 'Username is already taken.';
                    }
                }

                if (empty($data['password'])) {
                    $password_err = 'Please enter a password.';
                } elseif (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password must have atleast 6 characters.';
                }

                if (empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please confirm password.';
                } else {
                    if ($data['password'] != $data['confirm_password']) {
                        $data['confirm_password_err'] = 'Password do not match.';
                    }
                }

                if (empty($data['name_err']) && empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {

                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    // $data['role'] = $entity;
                    if ($this->Model->register($data)) {
                        flash('info', 'User is now registered and can log in');
                        redirect('pages/index');
                    } else {
                        die('Something went wrong');
                    }

                } else {
                    $this->view('users/register', $data);
                }
            } else {

                $data = [
                    'name' => '',
                    'username' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'username_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                ];

                $this->view('users/register', $data);
            }
        } else {
            flash('info', 'You do not have permission', 'alert alert-danger');
            redirect('pages/index');
        }
    }

}
