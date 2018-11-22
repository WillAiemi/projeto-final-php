<?php
class Leitor{
  private $idLeitor;
  private $nome;
  private $cpf;
  private $dataNasc;
  private $sexo;
  private $dataCad;
  private $endereco;
  private $telefone;

  public function __construct(){}
  public function __destruct(){}

  public function __get($a){ return $this->$a; }
  public function __set($a, $v){ $this->$a = $v; }

  public function __toString(){
    if (isset($this->idLeitor)) {
      return nl2br("ID do Leitor: $this->idLeitor
      Nome: $this->nome
      CPF: $this->cpf
      Sexo: $this->sexo
      Data de Nascimento: $this->dataNasc
      Data de Cadastro: $this->dataCad
      Endereço: $this->endereco
      Telefone: $this->telefone");
    }
    return nl2br("Nome: $this->nome
    CPF: $this->cpf
    Sexo: $this->sexo
    Data de Nascimento: $this->dataNasc
    Data de Cadastro: $this->dataCad
    Endereço: $this->endereco
    Telefone: $this->telefone");
  }
}
