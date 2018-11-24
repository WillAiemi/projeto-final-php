<?php
require_once "config/conexaobanco.class.php";

class LivroDAO{

  private $conexao = null;

  public function __construct(){
    $this->conexao = ConexaoBanco::getInstance();
  }
  public function __destruct(){}

  public function cadastrarLivro($liv){
    try {
      $stat = $this->conexao->prepare("insert into livro(idLivro,titulo,autor,editora,genero,anoLanc,isbn) values(null,?,?,?,?,?,?);");

      $stat->bindValue(1, $liv->titulo);
      $stat->bindValue(2, $liv->autor);
      $stat->bindValue(3, $liv->editora);
      $stat->bindValue(4, $liv->genero);
      $stat->bindValue(5, $liv->anoLanc);
      $stat->bindValue(6, $liv->isbn);

      $stat->execute();
    } catch (PDOException $e) {
      echo "Erro ao cadastrar livro!".$e;
    }
  }

  public function buscarLivros(){
    try {
      $stat = $this->conexao->query("select * from livro;");
      $array = $stat->fetchAll(PDO::FETCH_CLASS, "Livro");
      return $array;
    } catch (PDOException $e) {
      echo "Erro ao buscar livros!".$e;
    }

  }

  public function buscarLivrosPorFiltro($f,$q){
    try {
      $sql = "select * from livro where ".$f." like '%".$q."%' ORDER BY ".$f.";";
      $stat = $this->conexao->query($sql);
      $array = $stat->fetchAll(PDO::FETCH_CLASS, "Livro");
      return $array;
    } catch (PDOException $e) {
      echo "Erro ao buscar livros!".$e;
    }
  }

  public function excluirLivro($id){
    try {
      $stat = $this->conexao->prepare("delete from livro where idLivro = ?;");
      $stat->bindValue(1, $id);
      $stat->execute();
    } catch (PDOException $e) {
      echo "Erro ao excluir livro!".$e;
    }
  }

  public function alterarLivro($liv){
    try {
      $stat = $this->conexao->prepare("update livro set titulo=?,autor=?,editora=?,genero=?,anoLanc=?,isbn=? where idLivro=?;");

      $stat->bindValue(1, $liv->titulo);
      $stat->bindValue(2, $liv->autor);
      $stat->bindValue(3, $liv->editora);
      $stat->bindValue(4, $liv->genero);
      $stat->bindValue(5, $liv->anoLanc);
      $stat->bindValue(6, $liv->isbn);
      $stat->bindValue(7, $liv->idLivro);

      $stat->execute();
    } catch (PDOException $e) {
      echo "Erro ao alterar livro!".$e;
    }
  }
}
