<?php
class Content
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getIncubatorById($id)
    {
        $this->db->query("SELECT * FROM incubators WHERE id = :id");
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function getInfantById($id)
    {
        $this->db->query("SELECT * FROM infants WHERE id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function findIncubatorByNumber($number)
    {
        $this->db->query("SELECT * FROM incubators WHERE Number = :number");
        $this->db->bind(':number', $number);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function fetch_users()
    {
        $this->db->query('SELECT * FROM users');
        $result = $this->db->resultSet('users');
        return $result;
    }

    public function fetch_incubators()
    {
        // $this->db->query('SELECT * FROM incubators EXCEPT SELECT Incubator from infants');
        $this->db->query('SELECT * FROM incubators');
        $result = $this->db->resultSet('incubators');
        return $result;
    }

    public function fetch_infants()
    {
        $this->db->query('SELECT * FROM infants');
        $result = $this->db->resultSet('infants');
        return $result;
    }

    public function addInfant($data)
    {
        // $this->db->query('INSERT INTO infants (Name, DateofBirth, Mother\'s name, Sex) VALUES(:name, :dateofbirth, :mother_name, :sex)');
        $this->db->query('INSERT INTO infants (Name, DateofBirth, MotherName, Sex, Incubator) VALUES(:name, :dateofbirth, :mother_name, :sex, :incubators)');

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':dateofbirth', $data['dateofbirth']);
        $this->db->bind(':mother_name', $data['mother_name']);
        $this->db->bind(':sex', $data['sex']);
        $this->db->bind(':incubators', $data['incubators']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function sensorData_Temperature($id){
        $this->db->query('SELECT data_temperature,
        UNIX_TIMESTAMP(CONCAT_WS(" ", date_data, time_data)) AS datetime
        FROM sensors_data WHERE infant = :id
        ORDER BY date_data DESC, time_data DESC');
  
          $this->db->bind(':id', $id);
          $result = $this->db->resultSet('sensors_data');
          return $result;
    }

    public function sensorData_Breathing($id){
        $this->db->query('SELECT data_breathing
        UNIX_TIMESTAMP(CONCAT_WS(" ", date_data, time_data)) AS datetime
        FROM sensors_data WHERE infant = :id
        ORDER BY date_data DESC, time_data DESC');
  
          $this->db->bind(':id', $id);
          $result = $this->db->resultSet('sensors_data');
          return $result;
    }

    public function sensorData_Humidity($id){
        $this->db->query('SELECT data_humidity
        UNIX_TIMESTAMP(CONCAT_WS(" ", date_data, time_data)) AS datetime
        FROM sensors_data WHERE infant = :id
        ORDER BY date_data DESC, time_data DESC');
  
          $this->db->bind(':id', $id);
          $result = $this->db->resultSet('sensors_data');
          return $result;
    }

    public function sensorData($id)
    {
        $this->db->query('SELECT data_temperature, data_breathing, data_humidity,
      UNIX_TIMESTAMP(CONCAT_WS(" ", date_data, time_data)) AS datetime
      FROM sensors_data WHERE infant = :id
      ORDER BY date_data DESC, time_data DESC LIMIT 50');

        $this->db->bind(':id', $id);
        $result = $this->db->resultSet('sensors_data');
        return $result;
    }

    public function downloadData($id){
        $this->db->query('SELECT * from sensors_data WHERE infant = :id ORDER BY date_data DESC, time_data DESC');
        
        $this->db->bind(':id', $id);
        $result = $this->db->resultSet('sensors_data');
        return $result;

    }

    public function deleteData($id){
        $this->db->query('DELETE FROM sensors_data WHERE infant = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function addIncubator($data)
    {
        $this->db->query('INSERT INTO incubators (Number) VALUE (:num)');

        $this->db->bind(':num', $data['num']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function editInfant($data)
    {
        $this->db->query('UPDATE infants SET Name = :name, MotherName = :mother_name, Sex = :sex, DateofBirth = :dateofbirth, Incubator = :incubators WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':dateofbirth', $data['dateofbirth']);
        $this->db->bind(':mother_name', $data['mother_name']);
        $this->db->bind(':sex', $data['sex']);
        $this->db->bind(':incubators', $data['incubators']);

        return $this->db->execute();
    }

    public function editIncubator($data)
    {
        $this->db->query('UPDATE incubators SET Number = :num WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':num', $data['num']);

        return $this->db->execute();
    }

}
