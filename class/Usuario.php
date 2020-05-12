<?php


class Usuario {

    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function getDeslogin()  {
        return $this->deslogin;
    }

    public function setDeslogin($deslogin) {
        $this->deslogin = $deslogin;
    }

    public function getDessenha() {
        return $this->dessenha;
    }

    public function setDessenha($dessenha) {
        $this->dessenha = $dessenha;
    }

    public function getDtcadastro() {
        return $this->dtcadastro;
    }

    public function setDtcadastro($dtcadastro) {
        $this->dtcadastro = $dtcadastro;
    }

    public function loadbyId($id){

        $sql = new Sql();
        $results = $sql->select("SELECT* FROM tb_usuarios WHERE idusuario = :ID",array(
            ":ID"=>$id
        ));

        if(isset($results[0])){

            $this->setData($results[0]);
        } else {
            $this->setData(null);
        }

    }

    public static function getList(){

        $sql = new Sql();
        return $sql->select("SELECT* FROM tb_usuarios order by deslogin");
    }

    public static function search($login){

        $sql = new Sql();
        return $sql->select("SELECT* FROM tb_usuarios where deslogin LIKE :SEARCH ORDER BY deslogin",array(
            ':SEARCH'=>"%" . $login . "%"
        ));
    }

    public function login($login,$senha){

        $sql = new Sql();

        $results =  $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :SENHA",array(
            ':LOGIN'=>$login,
            ':SENHA'=>$senha,
        ));

        if (count($results)>0){

            $this->setData($results[0]);

        } else{

            throw new Exception("Login e/ou senha inválida");
        }

    }

    public function setData($data){

        $this->setIdusuario($data['idusuario']);
        $this->setDeslogin($data['deslogin']);
        $this->setDessenha($data['dessenha']);
        $this->setDtcadastro(new DateTime($data['dtcadastro']));

    }

    public function insert(){

        $sql = new Sql();
        $results = $sql->select("EXEC sp_usuarios_insert @pdeslogin =:LOGIN, @pdessenha = :SENHA", array(
            ':LOGIN'=>$this->getDeslogin(),
            ':SENHA'=>$this->getDessenha()
        ));



        if (count($results)>0){
            $this->setData($results[0]);

        }

    }

    public function update($login, $senha){

        $this->setDeslogin($login);
        $this->setDessenha($senha);

        $sql = new Sql();
        $sql->query("UPDATE tb_usuarios set deslogin = :LOGIN, dessenha = :SENHA WHERE IDUSUARIO = :ID ", array(
            ':LOGIN'=>$this->getDeslogin(),
            ':SENHA'=>$this->getDessenha(),
            ':ID'=>$this->getIdusuario()
        ));

        $this->loadbyId($this->getIdusuario());

    }

    public function delete(){

        $sql = new Sql();
        $sql->query("DELETE FROM tb_usuarios where idusuario = :ID",array(
            ':ID'=>$this->getIdusuario()
        ));

        $this->loadbyId($this->getIdusuario());

    }

    public function __construct($login="", $senha="") {

        $this->setDeslogin($login);
        $this->setDessenha($senha);
    }

    public function __toString() {

        return json_encode(array(
            "idusuario"=>$this->getIdusuario(),
            "deslogin"=>$this->getDeslogin(),
            "dessenha"=>$this->getDessenha(),
            "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")

        ));
    }


}