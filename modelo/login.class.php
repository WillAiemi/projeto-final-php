<?php
class Login{
  private $idLogin;
  private $user;
  private $senha;
  private $tipo;
  private $idLeitor;

  public function __construct(){}
  public function __destruct(){}

  public function __get($a){ return $this->$a; }
  public function __set($a, $v){ $this->$a = $v; }

  public function __toString(){
    if (isset($this->idLeitor)) {
      return nl2br("ID de Login: $this->idLogin
      Login: $this->user
      Senha: $this->senha
      ID do Leitor: $this->idLeitor");
    }
    return nl2br("Login: $this->user
    Senha: $this->senha
    ID do Leitor: $this->idLeitor");
  }
}
