<?php


class RegistroImportacao {

    private $sql;

    public function __construct(){

        $this->sql = new Sql();
    }

    public function getUltimaImportacao(){

        $ultimoregistro = $this->sql->select("SELECT HORARIO FROM IMPORTACOES ORDER BY HORARIO DESC");

        $date = new DateTime($ultimoregistro[0]["HORARIO"]);

        $ultimoregistro = $date->format("d/m/Y H:i:s");

        return $ultimoregistro;
    }

}