<?php

class ConnectionDB
{

    private $servername;
    private $dbname;
    private $username;
    private $password;

    public static function connection(string $servername = "localhost", string $dbname = "videogames", string $username = "root", string $password = "root")
    {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $conn;
    }

    /**
     * Get the value of servername
     */ 
    public function getServername()
    {
        return $this->servername;
    }

    /**
     * Set the value of servername
     *
     * @return  self
     */ 
    public function setServername($servername)
    {
        $this->servername = $servername;

        return $this;
    }

    /**
     * Get the value of dbname
     */ 
    public function getDbname()
    {
        return $this->dbname;
    }

    /**
     * Set the value of dbname
     *
     * @return  self
     */ 
    public function setDbname($dbname)
    {
        $this->dbname = $dbname;

        return $this;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}