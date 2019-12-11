<?php
class Updates extends Controller
{
    public function __construct()
    {
        $this->Model = $this->model('User');
        $this->contentModel = $this->model('Content');
    }

    public function editUser($id)
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Admin') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'id' => $id,
                    'name' => trim($_POST['name']),
                    'username' => trim($_POST['username']),
                    'role' => trim($_POST['role']),
                    'name_err' => '',
                    'username_err' => '',
                ];

                if (empty($data['username'])) {
                    $data['username_err'] = 'Please enter username';
                } else {
                    if ($this->Model->findUserByUsername($data['username'])) {
                        if ($data['username'] != ($this->Model->getUserById($id))->Username) {
                            $data['username_err'] = 'Username is already taken';
                        }
                    }
                }

                if (empty($data['name'])) {
                    $data['name_err'] = 'Please enter name';
                }

                if (empty($data['username_err']) && empty($data['name_err'])) {
                    if ($this->Model->editUser($data)) {
                        if (($_SESSION['user_id'] != $id)) {
                            flash('info', 'You have successfully updated the user\'s data');
                            redirect('pages/viewUsers');
                        } else {
                            logoutAdmin();
                            flash('register_success', 'You have successfully updated your own account. Please log in again.');
                            redirect('users/login');
                        }
                    } else {
                        die('Something went wrong');
                    }

                } else {
                    $this->view('users/editUser', $data);
                }

            } else {
                $user = $this->Model->getUserById($id);
                $data = [
                    'id' => $id,
                    'name' => $user->Name,
                    'username' => $user->Username,
                    'role' => $user->Role,
                    'name_err' => '',
                    'username_err' => '',
                ];

                $this->view('users/editUser', $data);

            }} else {flash('info', 'You do not have permission', 'alert alert-danger');
            redirect('pages/index');
        }
    }

    public function editIncubator($id)
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Nurse') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'id' => $id,
                    'num' => trim($_POST['num']),
                    'num_err' => '',
                ];

                if (empty($data['num'])) {
                    $data['num_err'] = 'Please enter the incubator\'s number';
                } else {
                    if ($this->contentModel->findIncubatorByNumber($data['num'])) {
                        if ($data['num'] != ($this->contentModel->getIncubatorById($id))->Number) {
                            $data['num_err'] = 'Incubator number is already taken';
                        }
                    }
                }

                if (empty($data['num_err'])) {
                    if ($this->contentModel->editIncubator($data)) {
                        flash('info', 'You have successfully updated the incubator\'s data');
                        redirect('pages/viewIncubators');
                    } else {
                        die('Something went wrong');
                    }

                } else {
                    $this->view('pages/editIncubator', $data);
                }

            } else {
                $incubator = $this->contentModel->getIncubatorById($id);
                $data = [
                    'id' => $id,
                    'num' => $incubator->Number,
                    'num_err' => '',
                ];

                $this->view('pages/editIncubator', $data);

            }} else {flash('info', 'You do not have permission', 'alert alert-danger');
            redirect('pages/index');
        }
    }

    public function editInfant($id)
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Nurse') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'id' => $id,
                    'name' => trim($_POST['name']),
                    'dateofbirth' => trim($_POST['dateofbirth']),
                    'sex' => trim($_POST['sex']),
                    'mother_name' => trim($_POST['mother_name']),
                    'incubators' => trim($_POST['incubator']),
                    'inc' => $this->contentModel->fetch_incubators(),
                    'incu' => $this->contentModel->getInfantById($id)->Incubator,
                    'name_err' => '',
                    // 'date_of_birth_err' => '',
                    // 'sex_err' => '',
                    'mother_name_err' => '',
                ];

                if (empty($data['name'])) {
                    $data['name_err'] = 'Please enter name';
                }

                // if (empty($data['dateofbirth'])) {
                //     $data['date_of_birth_err'] = 'Please enter the infant\'s date of birth';
                // }

                if (empty($data['mother_name'])) {
                    $data['mother_name_err'] = 'Please enter the infant\'s mother\'s name';
                }

                if (empty($data['mother_name_err']) && empty($data['name_err'])) {
                    if ($this->contentModel->editInfant($data)) {
                        flash('info', 'You have successfully updated the infant\'s data');
                        redirect('pages/viewInfants');
                    } else {
                        die('Something went wrong');
                    }

                } else {
                    $this->view('pages/editInfant', $data);
                }

            } else {
                $infant = $this->contentModel->getInfantById($id);
                $data = [
                    'id' => $id,
                    'name' => $infant->Name,
                    'mother_name' => $infant->MotherName,
                    'sex' => $infant->Sex,
                    'dateofbirth' => $infant->DateofBirth,
                    'inc' => $this->contentModel->fetch_incubators(),
                    'incu' => $infant->Incubator,
                    'name_err' => '',
                    'mother_name_err' => '',
                    'sex_err',
                ];

                $this->view('pages/editInfant', $data);

            }} else {flash('info', 'You do not have permission', 'alert alert-danger');
            redirect('pages/index');
        }
    }

    public function delete($id, $entity = null)
    {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['user_role'] == 'Admin') {
                if ($_SESSION['user_id'] != $id) {
                    $this->remove('User', $id);
                    redirect('pages/viewUsers');
                } else {
                    flash('info', 'You cannot delete your own account', 'alert alert-danger');
                    redirect('pages/index');
                }
            } else if ($_SESSION['user_role'] == 'Nurse') {
                $this->remove($entity, $id);
                if($entity == "Infant"){
                    $this->contentModel->deleteData($id);
                }
                redirect('pages/view' . $entity . 's');
            } else {
                flash('info', 'You do not have permission', 'alert alert-danger');
                redirect('pages/index');
            }
        }
    }

    private function remove($entity, $id)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->Model->delete($entity, $id)) {
                flash('info', $entity . " removed");
            } else {
                die("Something went wrong");
            }
        }
    }
}
