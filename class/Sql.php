<?php

class Sql extends PDO {

    private $conn;

    public function __construct($db="bolsa_valores") {

        $this->conn = new PDO("sqlsrv:Database=$db;server=DOT191NB\SQLEXPRESS;ConnectionPooling=0","php","master");
    }

    private function setParams($statement, $parameters = array()){

        foreach ($parameters as $key => $value) {
            $this->setParam($statement, $key,$value);
        }

    }

    private function setParam($statement, $key, $value){

        $statement->bindParam($key,$value);

    }

    public function query($rawQuery, $params = array()){

        $stmt = $this ->conn->prepare($rawQuery);

        $this->setParams($stmt, $params);

        $stmt->execute();

        if($stmt->errorInfo()[2] != null) {

            throw new Exception("ERRO: " . $stmt->errorInfo()[2]);
        };

        return $stmt;


    }

    public function select($rawQuery, $params = array()):array {


        $stmt = $this->query($rawQuery,$params);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}