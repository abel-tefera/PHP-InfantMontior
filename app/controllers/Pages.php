<?php
class Pages extends Controller
{

    public function __construct()
    {
        $this->Model = $this->model('Content');
    }

    public function index()
    {
        $data = [
            'title' => 'Home',
            'description' => 'Infant Incubator System',
        ];
        $this->view('pages/index', $data);
    }

    public function history($id){
        $temp = array();
        $brea = array();
        $hum = array();
        $result = $this->Model->downloadData($id);
        foreach($result[1] as $row){
            $sub_array = array();
            $sub_array2 = array();
            $sub_array3 = array();

            $datetime = explode(".", $row['date_data']);
            $sub_array[] = array(
                "y" => $row['data_temperature'], "label" => $datetime[0]
            );
            $sub_array2[] = array(
                "y" => $row['data_breathing'], "label" => $datetime[0]
            );
            $sub_array3[] = array(
                "y" => $row['data_humidity'], "label" => $datetime[0]
            );
            $temp = array_merge($temp, $sub_array);
            $brea = array_merge($brea, $sub_array2);
            $hum = array_merge($hum, $sub_array3);

        }
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Doctor') {
            $data = [
                'id' => $id,
                'name' => $this->Model->getInfantById($id)->Name,
                'Temperature' => $temp,
                'Breathing' => $brea,
                'Humidity' => $hum
            ];
            $this->view('pages/history', $data);
        }else{
            flash('info', 'You do not have permission', 'alert alert-danger');
            redirect('pages/index');
        }
    }

    public function download($id)
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Doctor') {
            $name = $this->Model->getInfantById($id)->Name;
            // die($name);
            $result = $this->Model->downloadData($id);
            if (sizeof($result[1]) == 0){
                flash('info', 'Nothing to download', 'alert alert-danger');
                redirect('pages/chart/$id');
                return;

            }
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename= $name-$id history.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $sep = "\t";
            foreach ($result[0] as $field) {
                echo ($field) . "\t";
            }
            print("\n");
            foreach ($result[1] as $row) {
                $schema_insert = "";
                foreach ($row as $singlerow) {
                    $schema_insert .= "$singlerow" . $sep;
                }
                $schema_insert = str_replace($sep . "$", "", $schema_insert);
                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                $schema_insert .= "\t";
                print(trim($schema_insert));
                print "\n";
            }
        } else {
            flash('info', 'You do not have permission', 'alert alert-danger');
            redirect('pages/index');
        }

    }

    public function about()
    {
        $data = [
            'title' => 'Infant Incubator',
            'description' => 'Tool to monitor infants',
        ];

        $this->view('pages/about', $data);
    }

    public function chart($id)
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Doctor') {
            $data = [
                'id' => $id,
            ];
            $this->view('pages/chart', $data);
        } else {
            flash('info', 'You do not have permission', 'alert alert-danger');
            redirect('pages/index');
        }
    }

    public function fetch_chart($id)
    {
        $result = $this->Model->sensorData($id);

        $rows = array();
        $table = array();

        $table['cols'] = array(
            array(
                'label' => 'Date Time',
                'type' => 'datetime',
            ),
            array(
                'label' => 'Temperature (°C)',
                'type' => 'number',
            ),
            array(
                'label' => 'Breathing rate',
                'type' => 'number',
            ),
            array(
                'label' => 'Humidity',
                'type' => 'number',
            ),
        );

        foreach ($result[1] as $row) {
            $sub_array = array();
            $datetime = explode(".", $row['datetime']);
            $sub_array[] = array(
                "v" => 'Date(' . $datetime[0] . '000)',
            );
            $sub_array[] = array(
                "v" => $row['data_temperature'],
            );
            $sub_array[] = array(
                "v" => $row['data_breathing'],
            );
            $sub_array[] = array(
                "v" => $row['data_humidity'],
            );
            $rows[] = array(
                "c" => $sub_array,
            );
        }
        $table['rows'] = $rows;
        $jsonTable = json_encode($table);
        echo $jsonTable;

    }

    public function viewUsers()
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Admin') {

            $result = $this->Model->fetch_users();
            $this->generateTable($result, 'Users');
        } else {
            flash('info', 'You do not have permission', 'alert alert-danger');
            redirect('pages/index');
        }
    }

    public function viewIncubators()
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Nurse') {

            $result = $this->Model->fetch_incubators();
            $this->generateTable($result, 'Incubators');
        } else {
            flash('info', 'You do not have permission', 'alert alert-danger');
            redirect('pages/index');
        }
    }

    public function viewInfants()
    {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role'] == 'Nurse' || $_SESSION['user_role'] == 'Doctor')) {

            $result = $this->Model->fetch_infants();
            $this->generateTable($result, 'Infants');
        } else {
            flash('info', 'You do not have permission', 'alert alert-danger');
            redirect('pages/index');
        }
    }

    private function generateTable($result, $header)
    {
        $data = [
            'header' => $header,
            'fields' => $result[0],
            'rows' => $result[1],
        ];
        $this->view('pages/tables', $data);
    }

    public function addInfant()
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Nurse') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'name' => trim($_POST['name']),
                    'dateofbirth' => trim($_POST['dateofbirth']),
                    'sex' => trim($_POST['sex']),
                    'mother_name' => trim($_POST['mother_name']),
                    'incubators' => trim($_POST['incubator']),
                    'inc' => $this->Model->fetch_incubators(),
                    'name_err' => '',
                    'date_of_birth_err' => '',
                    'sex_err' => '',
                    'mother_name_err' => '',
                ];

                if (empty($data['name'])) {
                    $data['name_err'] = 'Please enter name of the infant';
                }

                if (empty($data['dateofbirth'])) {
                    $data['date_of_birth_err'] = 'Please enter the infant\'s date of birth';
                }

                if (empty($data['sex'])) {
                    $data['sex_err'] = 'Please enter the infant\'s sex';
                }

                if (empty($data['mother_name'])) {
                    $data['mother_name_err'] = 'Please enter the infant\'s mother\'s name';
                }

                if (empty($data['name_err']) && empty($data['date_of_birth_err']) && empty($data['sex_err']) && empty($data['mother_name_err'])) {
                    if ($this->Model->addInfant($data)) {
                        flash('info', 'You have successfully registered the infant.');
                        redirect('pages/index');
                    } else {
                        flash('info', 'Something went wrong', 'alert alert-danger');
                        redirect('pages/index');}
                } else {
                    $this->view('pages/addInfant', $data);
                }

            } else {
                $data = [
                    'name' => '',
                    'dateofbirth' => '',
                    'sex' => '',
                    'mother_name' => '',
                    'inc' => $this->Model->fetch_incubators(),
                    'name_err' => '',
                    'date_of_birth_err' => '',
                    'sex_err' => '',
                    'mother_name_err' => '',
                ];
                // foreach($data['incubator'][1] as $incubator){
                //     die($incubator['Number']);
                // }
                $this->view('pages/addInfant', $data);
            }
        } else {
            flash('info', 'You do not have permission', 'alert alert-danger');
            redirect('pages/index');
        }
    }

    public function addIncubator()
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Nurse') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'num' => trim($_POST['num']),
                    'num_err' => '',
                ];

                if (empty($data['num'])) {
                    $data['num_err'] = 'Please enter the incubator\'s number';
                } else {
                    if ($this->Model->findIncubatorByNumber($data['num'])) {
                        $data['num_err'] = 'Incubator number is already taken.';
                    }}

                if (empty($data['num_err'])) {
                    if ($this->Model->addIncubator($data)) {
                        flash('info', 'You have successfully registered the incubator.');
                        redirect('pages/index');
                    } else {
                        flash('info', 'Something went wrong', 'alert alert-danger');
                        redirect('pages/index');}
                } else {
                    $this->view('pages/addIncubator', $data);
                }

            } else {
                $data = [
                    'num' => '',
                    'num_err' => '',
                ];

                $this->view('pages/addIncubator', $data);
            }
        } else {
            flash('info', 'You do not have permission', 'alert alert-danger');
            redirect('pages/index');
        }
    }

}
