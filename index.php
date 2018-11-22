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
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca do Bairro - Login</title>
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
                  <a class="button is-primary is-inverted">
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
          <h1 class="title">Biblioteca do Bairro</h1>
          <h2 class="subtitle">Entrar</h2>
        </div><!--fecha container has-text-centered-->
      </div><!-- fecha hero-body -->
    </section><!-- fecha hero-->

    <section class="section">
      <div class="container">
        <?php
        if(isset($_SESSION['msg'])){
          echo "<h3 class='subtitle is-4'>".$_SESSION['msg']."</h2>";
          unset($_SESSION['msg']);
        }
        ?>

        <?php
        if (isset($_SESSION['privateUser'])) {
          echo "<h3 class='title is-3'>Olá, {$leitor->nome}</h3>";
        ?>

        <form action="" method="post">
          <div class="field">
            <div class="control">
              <input class="button is-success" type="submit" name="deslogar" value="Sair">
            </div>
          </div>
        </form>

        <?php
        if (isset($_POST['deslogar'])) {
          unset($_SESSION['privateUser']);
          header("location:index.php");
        }
        ?>

        <?php
        } else {
        ?>

        <div class="columns">
          <div class="column is-4 is-offset-4">
            <div class="box">

              <form action="" method="post">

                <div class="field">
                  <label class="label">Usuário</label>
                  <div class="control has-icons-left">
                    <input class="input" type="text" name="login" autofocus placeholder="Insira seu usuário">
                    <span class="icon is-small is-left">
                      <i class="fas fa-user"></i>
                    </span>
                  </div><!--fecha control has-icons-left-->
                </div><!--fecha field-->

                <div class="field">
                  <label class="label">Senha</label>
                  <div class="control has-icons-left">
                    <input class="input" type="password" name="loginpass" placeholder="Insira sua senha">
                    <span class="icon is-small is-left">
                      <i class="fas fa-lock"></i>
                    </span>
                  </div><!--fecha control has-icons-left-->
                </div><!--fecha field-->

                <div class="field is-grouped is-grouped-centered">
                  <div class="control">
                    <input class="button is-primary" type="submit" name="submit" value="Entrar">
                  </div><!--fecha control-->
                  <div class="control">
                    <a href="cadastro.php" class="button is-text has-text-info">Cadastrar</a>
                  </div><!--fecha control-->
                </div><!--field is-grouped is-grouped-centered-->

              </form><!--fecha form-->
              <?php
              }
              ?>

              <?php
              if (isset($_POST['submit'])) {
                include 'modelo/login.class.php';
                include 'dao/leitordao.class.php';
                include 'util/utilidade.class.php';

                $login = new Login();
                $login->user = $_POST['login'];
                $login->senha = Utilidade::criptografarSenha($_POST['loginpass']);

                $leitorDAO = new LeitorDAO();
                $leitor = $leitorDAO->verificarLogin($login);

                if ($leitor == null) {
                  $_SESSION['msg'] = "Usuário/senha inválido(s)!";
                  header("location:index.php");
                } else {
                  $_SESSION['privateUser'] = serialize($leitor);
                  header("location:index.php");
                }
              }
              ?>
            </div><!--fecha box-->
          </div><!--fecha column is-offset-4 is-4-->
        </div><!--fecha columns-->
      </div><!--fecha container-->
    </section><!--fecha section-->
  </body><!--fecha body-->
</html>
