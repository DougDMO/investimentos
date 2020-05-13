<?php


class Papeis {

    private $sql;

    public function __construct(){

        $this->sql = new Sql();
    }

    public function getPapeis(){

        $papeis = $this->sql->select("SELECT* FROM papeis order by papel");

        return $papeis;
    }

}