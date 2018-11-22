<?php
session_start();
ob_start();
$adm = null;
if(isset($_SESSION['privateUser'])){
  include_once "modelo/login.class.php";
  include_once "modelo/leitor.class.php";
  include_once "dao/leitordao.class.php";
  $login = unserialize($_SESSION['privateUser']);
  if($login->tipo == "adm"){
    $adm = true;
  }
  $leitorDAO = new LeitorDAO();
  $leitor = $leitorDAO->buscarPorID($login->idLeitor);
  $_SESSION['msg'] = "Você já é cadastrado!";
  header("location:index.php");
}
include 'util/utilidade.class.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca do Bairro - Cadastro de Livro</title>
    <link href="node_modules/bulma/css/bulma.css" rel="stylesheet">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.css">
  </head>


  <body>
    <section class="hero is-primary is-bold">

      <div class="hero-head">
        <nav class="navbar">
          <div class="container">
            <div class="navbar-menu">
              <div class="navbar-end">
                <?php
                if($adm == true){
                ?>
                <a href="cadastro-livro.php" class="navbar-item">
                  Cadastrar Livros
                </a>
                <?php
                }
                if (isset($_SESSION['privateUser'])) {
                ?>
                <a href="buscar-livros.php" class="navbar-item">
                  Consultar Livros
                </a>
                <?php
                }
                ?>

                <span class="navbar-item">
                  <a href="index.php" class="button is-primary is-inverted">
                    <span class="icon">
                      <i class="far fa-user-circle"></i>
                    </span>
                    <?php
                    if (isset($_SESSION['privateUser'])) {
                      echo "<span>Logado como: ".$leitor->nome."</span>";
                    } else {
                      echo "<span>Entrar</span>";
                    }
                    ?>
                  </a>
                </span><!--fecha navbar-item-->

              </div><!--fecha navbar-end-->
            </div><!--fecha navbar-menu-->
          </div><!--fecha container-->
        </nav><!--fecha nav-->
      </div><!--fecha hero-head-->

      <div class="hero-body">
        <div class="container has-text-centered">
          <h1 class="title">
            Biblioteca do Bairro
          </h1>
          <h2 class="subtitle">
            Cadastro
          </h2>
        </div>
      </div>
    </section>

    <section class="section">
      <?php
      if (!isset($_SESSION['msg'])) {
      ?>

      <?php
      if (isset($_SESSION['erros'])) {
      ?>
      <div class="container">
        <div class="notification has-text-centered is-danger">
          <h3 class="subtitle is-3">Erro ao cadastrar!</h3>
          <p>
          <?php
          $erros = unserialize($_SESSION['erros']);
          foreach ($erros as $e) {
            echo $e."<br>";
          }
          ?>
          </p>
        </div>
      </div>
      <?php
        $dados = unserialize($_SESSION['post']);
        unset($_SESSION['erros']);
        unset($_SESSION['post']);
      }
      ?>
      <div class="container">
        <form action="" method="post">
          <div class="box">
            <legend class="subtitle is-4 has-text-centered">Dados do Leitor</legend>
            <div class="columns">
              <div class="field column">
                <label class="label">Nome<span class="has-text-danger">*</span></label>
                <div class="control">
                  <input class="input" type="text" value="<?php if (isset($dados)){ echo $dados['txtnome']; } ?>" required name="txtnome" autofocus placeholder="Insira seu nome">
                </div>
              </div>
              <div class="field column">
                <label class="label">CPF<span class="has-text-danger">*</span></label>
                <div class="control">
                  <input class="input" type="text" value="<?php if (isset($dados)){ echo $dados['txtcpf']; } ?>" required name="txtcpf" placeholder="Insira seu CPF">
                </div>
              </div>
            </div>

            <div class="columns">
              <div class="field column">
                <label class="label">Data de Nascimento<span class="has-text-danger">*</span></label>
                <div class="columns">
                  <div class="control column">
                    <div class="select is-fullwidth">
                      <select class="select" name="slcdia">
                        <option disabled selected>Dia</option>
                        <?php
                        if (isset($dados)) {
                          for ($i=1; $i < 10; $i++) {
                            if ($dados['slcdia'] == "0$i") {
                              echo "<option selected value=\"0$i\">0$i</option>";
                            } else {
                              echo "<option value=\"0$i\">0$i</option>";
                            }
                          }
                          for ($i=10; $i < 32; $i++) {
                            if ($dados['slcdia'] == $i) {
                              echo "<option selected value=\"$i\">$i</option>";
                            } else {
                              echo "<option value=\"$i\">$i</option>";
                            }
                          }
                        } else {
                          for ($i=1; $i < 10; $i++) {
                            echo "<option value=\"0$i\">0$i</option>";
                          }
                          for ($i=10; $i < 32; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="control column">
                    <div class="select is-fullwidth">
                      <select name="slcmes">
                        <option disabled selected>Mês</option>
                        <?php
                        if (isset($dados)) {
                          for ($i=1; $i < 10; $i++) {
                            if ($dados['slcmes'] == "0$i") {
                              echo "<option selected value=\"0$i\">0$i</option>";
                            } else {
                              echo "<option value=\"0$i\">0$i</option>";
                            }
                          }
                          for ($i=10; $i < 13; $i++) {
                            if ($dados['slcmes'] == $i) {
                              echo "<option selected value=\"$i\">$i</option>";
                            } else {
                              echo "<option value=\"$i\">$i</option>";
                            }
                          }
                        } else {
                          for ($i=1; $i < 10; $i++) {
                            echo "<option value=\"0$i\">0$i</option>";
                          }
                          for ($i=10; $i < 13; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="control column">
                    <div class="select is-fullwidth">
                      <select name="slcano">
                        <option disabled selected>Ano</option>
                        <?php
                        if (isset($dados)) {
                          for ($i=date("Y"); $i > 1930; $i--) {
                            if ($dados['slcano'] == $i) {
                              echo "<option selected value=\"$i\">$i</option>";
                            } else {
                              echo "<option value=\"$i\">$i</option>";
                            }
                          }
                        } else {
                          for ($i=date("Y"); $i > 1930; $i--) {
                            echo "<option value=\"$i\">$i</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

              </div>

              <div class="field column">
                <label class="label">Sexo<span class="has-text-danger">*</span></label>
                <div class="control">
                  <label>
                    <input type="radio" <?php if (isset($dados)) { echo ($dados['rdsexo'] == "Masculino") ? "checked" : "" ; } ?> name="rdsexo" value="Masculino">
                    Masculino
                  </label>
                  <label>
                    <input type="radio" <?php if (isset($dados)) { echo ($dados['rdsexo'] == "Feminino") ? "checked" : "" ; } ?> name="rdsexo" value="Feminino">
                    Feminino
                  </label>
                  <label>
                    <input type="radio" <?php if (isset($dados)) { echo ($dados['rdsexo'] == "Não-binário") ? "checked" : "" ; } ?> name="rdsexo" value="Não-binário">
                    Não-binário
                  </label>
                </div>
              </div>
            </div>

            <div class="columns">
              <div class="field column">
                <label class="label">CEP<span class="has-text-danger">*</span></label>
                <div class="control">
                  <input class="input" type="number" value="<?php if (isset($dados)){ echo $dados['txtcep']; } ?>" required name="txtcep" placeholder="Insira seu cep(apenas números)">
                </div>
              </div>

              <div class="field column">
                <label class="label">Número</label>
                <div class="control">
                  <input class="input" type="number" value="<?php if (isset($dados)){ echo $dados['txtendnum']; } ?>" name="txtendnum" placeholder="Insira o número da casa">
                </div>
              </div>

              <div class="field column">
                <label class="label">Telefone<span class="has-text-danger">*</span></label>
                <div class="control">
                  <input class="input" type="text" value="<?php if (isset($dados)){ echo $dados['txttel']; } ?>" required name="txttel" placeholder="(51)XXXX-XXXX">
                </div>
              </div>
            </div>
          </div>

          <div class="box has-text-centered">
            <legend class="subtitle is-4">Dados de Login</legend>
            <div class="field columns">
              <div class="column is-4 is-offset-4">
                <div class="control has-icons-left">
                  <input class="input" type="text" value="<?php if (isset($dados)){ echo $dados['txtlogin']; } ?>" name="txtlogin" placeholder="Insira um login">
                  <span class="icon is-small is-left">
                    <i class="fas fa-user"></i>
                  </span>
                </div><!--fecha control-->
              </div>
            </div><!--fecha field columns-->
            <div class="field columns">
              <div class="column is-4 is-offset-4">
                <div class="control has-icons-left">
                  <input class="input" type="password" name="txtsenha" placeholder="Insira a senha">
                  <span class="icon is-small is-left">
                    <i class="fas fa-key"></i>
                  </span>
                </div>
              </div>
            </div>
            <div class="field columns">
              <div class="column is-4 is-offset-4">
                <div class="control has-icons-left">
                  <input class="input" type="password" name="txtsenha2" placeholder="Insira a senha novamente">
                  <span class="icon is-small is-left">
                    <i class="fas fa-key"></i>
                  </span>
                </div>
              </div>
            </div>

            <div class="columns">
              <div class="column is-4 is-offset-4 field is-grouped is-grouped-centered">
                <div class="control">
                  <input class="button is-link" type="submit" name="submit" value="Enviar">
                </div>
                <div class="control">
                  <input class="button is-danger" type="reset" name="reset" value="Limpar">
                </div>
              </div>
              <div class="container column is-4">
                <div class="content has-text-danger is-pulled-left">
                  <p>* campos obrigatórios</p>
                </div>
              </div>
            </div>

          </div> <!--fecha box do form-->
        </form>
      </div><!--fecha container do form-->
      <?php
      } else {
      ?>
      <div class="content">
        <div class="notification is-success">
          <h3 class="title is-3"><?php echo $_SESSION['msg']; ?></h3>
          <h4 class="subtitle is-4">Você foi cadastrado com sucesso!</h4>
        </div>
      </div>
      <?php
      unset($_SESSION['msg']);
      }
      if (isset($_POST['submit'])) {
        $erros = null;
        if (!Utilidade::validarNome(Utilidade::capitalizarPalavras($_POST['txtnome']))) {
          $erros[] = "Nome inválido!";
        }

        if (!Utilidade::validarNumerico($_POST['txtcpf'],"cpf")) {
          $erros[] = "CPF inválido!";
        }

        if (!Utilidade::validarData($_POST['slcdia'],$_POST['slcmes'],$_POST['slcano'])) {
          $erros[] = "Data inválida!";
        }

        if (!Utilidade::validarSexo($_POST['rdsexo'])) {
          $erros[] = "Sexo inválida!";
        }

        if (!Utilidade::validarNumerico($_POST['txtcep'],"cep")) {
          $erros[] = "CEP inválido!";
        } else if (json_decode(file_get_contents("https://viacep.com.br/ws/".$_POST['txtcep']."/json"))->erro == true) {
          $erros[] = "CEP não possui endereço!";
        }

        if (!Utilidade::validarTelefone(Utilidade::padronizarTelefone($_POST['txttel']))) {
          $erros[] = "Telefone inválido!";
        }

        if (!Utilidade::validarUser($_POST['txtlogin'])) {
          $erros[] = "Usuário inválido!";
        }

        if (!Utilidade::validarSenha($_POST['txtsenha'])) {
          $erros[] = "Senha inválida!";
        }

        if ($_POST['txtsenha'] != $_POST['txtsenha2']) {
          $erros[] = "Senhas não correspondem!";
        }

        if (count($erros) == 0) {
          include 'modelo/leitor.class.php';
          include 'modelo/login.class.php';
          include 'dao/leitordao.class.php';

          $leitor = new Leitor();

          $leitor->nome = Utilidade::capitalizarPalavras($_POST['txtnome']);
          $leitor->cpf = Utilidade::padronizarCPF($_POST['txtcpf']);
          $leitor->dataNasc = Utilidade::juntarDataInternacional($_POST['slcdia'],$_POST['slcmes'],$_POST['slcano']);
          $leitor->sexo = $_POST['rdsexo'];
          $leitor->dataCad = date("Y-m-d");
          $end = json_decode(file_get_contents("https://viacep.com.br/ws/".$_POST['txtcep']."/json"));
          $leitor->endereco = $end->logradouro.", ".$_POST['txtendnum']." - ".$end->bairro.", ".$end->localidade."/".$end->uf;
          $leitor->telefone = Utilidade::padronizarTelefone($_POST['txttel']);

          $leitorDAO = new LeitorDAO();
          $leitorDAO->cadastrarLeitor($leitor);

          $login = new Login();

          $login->user = $_POST['txtlogin'];
          $login->senha = Utilidade::criptografarSenha($_POST['txtsenha']);
          $login->idLeitor = $leitorDAO->buscarIDLeitorPorCPF($leitor->cpf);
          $login->tipo = "user";

          $leitorDAO->cadastrarLogin($login);

          $_SESSION['msg'] = "Seja bem-vindo ".$leitor->nome."!";
          unset($_POST['submit']);
          header("location:cadastro.php");
        } else {
          $_SESSION['erros'] = serialize($erros);
          $_SESSION['post'] = serialize($_POST);
          unset($_POST['submit']);
          header("location:cadastro.php");
        }
      }
      ?>
    </section><!--fecha section-->
  </body>
</html>
