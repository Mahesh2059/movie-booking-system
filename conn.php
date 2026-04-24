<?php

class connec{
    public $username="root";
    public $password="";
    public $server_name="localhost";
    public $db_name="movie_ticket_booking";

    public $conn;

    function __construct()
    {
        $this->conn=new mysqli($this->server_name,$this->username,$this->password,$this->db_name);
        if($this->conn->connect_error)
        {
            die("connection Failed");

        }
      //  else
        //{
          //  echo"connected";
        //}
    }
    function select_all($table_name)
    {
       

        $sql = "SELECT * FROM $table_name";
        $result=$this->conn->query($sql);

        return $result;
        
    }
    function select_by_query($query)
    {
        $result=$this->conn->query($query);
        return $result;
    }

    public function select_movie($table_name, $type)
{
    if ($type == "commingsoon") {
        $sql = "SELECT * FROM $table_name WHERE rel_date > NOW()";
    } elseif ($type == "nowshowing") {
        $sql = "SELECT * FROM $table_name WHERE rel_date <= NOW()";
    } else {
        // Invalid type fallback or return empty result
        return false;
    }

    $result = $this->conn->query($sql);
    return $result;
}

     function select($table_name,$id)
    {
       

        $sql = "SELECT * FROM $table_name where id=$id";
        $result=$this->conn->query($sql);

        return $result;


    }
    public function insert($sql, $successMsg = "") {
    if ($this->conn->query($sql)) {
        if ($successMsg != "") {
            echo "<script>alert('$successMsg');</script>";
        }
        return true;  // Return TRUE on success
    } else {
        echo "Error: " . $this->conn->error;
        return false; // Return FALSE on failure
    }
}

        
    function insert_user($username, $email, $password, $number) {
    $password = md5($password); // Secure the password (you can use bcrypt in real apps)
    $sql = "INSERT INTO user (username, email, password, number) VALUES ('$username', '$email', '$password', '$number')";
    if($this->conn->query($sql) === TRUE) {
        echo '<script>alert("Registration successful. Please login.");</script>';
    } else {
        echo '<script>alert("Error: '.$this->conn->error.'");</script>';
    }
}

function validate_login($email, $password) {
    $password = md5($password);
    $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    $result = $this->conn->query($sql);
    return $result;
}



 
}





?>