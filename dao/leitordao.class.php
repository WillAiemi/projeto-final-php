<?php
require_once "config/conexaobanco.class.php";

class LeitorDAO{

  private $conexao = null;

  public function __construct(){
    $this->conexao = ConexaoBanco::getInstance();
  }
  public function __destruct(){}

  public function cadastrarLeitor($leitor){
    try {
      $stat = $this->conexao->prepare("insert into leitor(idLeitor,nome,cpf,dataNasc,sexo,dataCad,endereco,telefone) values(null,?,?,?,?,?,?,?);");

      $stat->bindValue(1, $leitor->nome);
      $stat->bindValue(2, $leitor->cpf);
      $stat->bindValue(3, $leitor->dataNasc);
      $stat->bindValue(4, $leitor->sexo);
      $stat->bindValue(5, $leitor->dataCad);
      $stat->bindValue(6, $leitor->endereco);
      $stat->bindValue(7, $leitor->telefone);

      $stat->execute();
    } catch (PDOException $e) {
      echo "Erro ao cadastrar leitor!".$e;
    }
  }

  public function buscarIDLeitorPorCPF($cpf){
    try {
      $stat = $this->conexao->query("select * from leitor where cpf = '".$cpf."';");
      $leitor = $stat->fetchAll(PDO::FETCH_CLASS, "Leitor");
      return $leitor[0]->idLeitor;
    } catch (PDOException $e) {
      echo "Erro ao cadastrar login do leitor!".$e;
    }
  }

  public function cadastrarLogin($login){
    try {
      $stat = $this->conexao->prepare("insert into login(idLogin,user,senha,tipo,idLeitor) values(null,?,?,?,?);");

      $stat->bindValue(1, $login->user);
      $stat->bindValue(2, $login->senha);
      $stat->bindValue(3, $login->tipo);
      $stat->bindValue(4, $login->idLeitor);

      $stat->execute();
    } catch (PDOException $e) {
      echo "Erro ao cadastrar login do leitor!".$e;
    }
  }

  public function verificarLogin($login){
    try {
      $stat = $this->conexao->prepare("select * from login where user = ? and senha = ?;");

      $stat->bindValue(1,$login->user);
      $stat->bindValue(2,$login->senha);

      $stat->execute();

      $leitor = null;
      $leitor = $stat->fetchObject('Login');
      return $leitor;
    } catch (PDOException $e) {
      echo "Erro ao logar!".$e;
    }

  }

  public function buscarPorID($id){
    try {
      $stat = $this->conexao->prepare("select * from leitor where idLeitor = ?;");

      $stat->bindValue(1,$id);

      $stat->execute();
      $leitor = null;
      $leitor = $stat->fetchObject('Leitor');
      return $leitor;
    } catch (PDOException $e) {
      echo "Erro ao buscar!".$e;
    }
  }
}
