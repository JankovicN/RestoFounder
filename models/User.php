<?php

class User
{
    public $id;
    public $email;
    public $username;
    public $password;
    public $nationality;

    public function __construct(
        $id,
        $email,
        $username,
        $password,
        $nationality
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->nationality = $nationality;
    }

    public function createUser()
    {
        $host = 'localhost';
        $user = 'janko';
        $password = '00000';
        $database = 'restaurants';
        $conn = mysqli_connect($host, $user, $password, $database);

        $query = "INSERT INTO user(email, username, password, nationality) 
            VALUES('$this->email', '$this->username', '$this->password',
            '$this->nationality')";

        if (mysqli_query($conn, $query)) {
            header('Location: login.php');
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    }
}
