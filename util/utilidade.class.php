<?php
class Utilidade{
  public static function capitalizarPalavras($str){
    return ucwords(strtolower($str));
  }

  public static function juntarDataInternacional($d,$m,$a){
    return $a."-".$m."-".$d;
  }

  public static function converterDataNtoI($data){
    $dataI = explode("/",$data);
    return $dataI[2]."-".$dataI[1]."-".$dataI[0];
  }

  public static function converterDataItoN($data){
    $dataN = explode("-",$data);
    return $dataN[0]."/".$dataN[1]."/".$dataN[2];
  }

  public static function criptografarSenha($pass){
    return sha1("sEcr3t".$pass."c0dE");
  }

  public static function padronizarCPF($cpf){
    return $cpf[0].$cpf[1].$cpf[2].".".$cpf[3].$cpf[4].$cpf[5].".".$cpf[6].$cpf[7].$cpf[8]."-".$cpf[9].$cpf[10];
  }

  public static function validarNome($v){
    $exp = "/^([A-zÀ-ú]{2,14}){1}( [A-zÀ-ú]{2,14}){1,3}$/";
    return preg_match($exp,$v);
  }

  public static function validarNumerico($v,$n){
    switch ($n) {
      case 'cpf':
        $n = 11;
        break;
      case 'cep':
        $n = 8;
        break;
      case 'isbn':
        $n = 13;
        break;
    }
    $exp = "/^[\d]{".$n."}$/";
    return preg_match($exp,$v);
  }

  public static function validarData($d,$m,$a){
    return checkdate($m,$d,$a);
  }

  public static function validarSexo($v){
    $exp = "/^(Masculino|Feminino|Não-binário)$/";
    return preg_match($exp,$v);
  }

  public static function padronizarTelefone($v){
    return str_replace(" ","",$v);
  }

  public function validarTelefone($v){
    $exp = "/^\([\d]{2}\)[\d]{4}[\d]?-[\d]{4}$/";
    return preg_match($exp,$v);
  }

  public static function validarGeral($v){
    $exp = "/^[.]{2,100}$/";
    return preg_match($exp,$v);
  }

  public static function validarGenero($v){
    $exp = "/^(Comédia|Romance|Terror|Ficção Científica|Ação|Poesia|Mistério|Drama|Auto-Ajuda)$/";
    return preg_match($exp,$v);
  }

  public static function validarAnoLanc($v){
    if (is_numeric($v) & $v >= 1455 & $v <= date("Y")) {
      return true;
    }
    return false;
  }

  public static function validarUser($v){
    $exp = "/^[\w\d]{4,20}$/";
    return preg_match($exp,$v);
  }

  public static function validarSenha($v){
    $exp = "/^[\w\d]{8,}$/";
    return preg_match($exp,$v);
  }
}
