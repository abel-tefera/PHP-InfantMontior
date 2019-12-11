<?php
class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function register($data)
    {
        $this->db->query('INSERT INTO users (Name, Username, password, Role)
      VALUES (:name, :username, :password, :role)');

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':role', $data['role']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function findUserByUsername($username)
    {
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $password)
    {
        $this->db->query("SELECT * FROM users WHERE Username = :username");
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        $hashed_password = $row->password;
        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }

    public function getUserById($id)
    {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function getUserByUsername($username)
    {
        $this->db->query("SELECT * FROM users WHERE Username = :username");
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        return $row;
    }

    public function editUser($data)
    {
        $this->db->query('UPDATE users SET Name = :name, Username = :username, Role = :role WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':role', $data['role']);

        return $this->db->execute();
    }

    public function delete($entity, $id)
    {
        if ($entity == 'User') {
            $this->db->query('DELETE FROM users WHERE id = :id');
        } else if ($entity == 'Infant') {
            $this->db->query('DELETE FROM infants WHERE id = :id');
        } else if ($entity == 'Incubator') {
            $this->db->query('DELETE FROM incubators WHERE id = :id');
        }

        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

}
