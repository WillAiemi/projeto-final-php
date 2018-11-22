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
  } else {
    $_SESSION['msg'] = "Você não pode acessar esse conteúdo.";
    header("location:index.php");
    die();
  }
  $leitorDAO = new LeitorDAO();
  $leitor = $leitorDAO->buscarPorID($login->idLeitor);
}

include 'modelo/livro.class.php';
include 'dao/livrodao.class.php';

$livroDAO = new LivroDAO();
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca do Bairro - Alteração de Livro</title>
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
            Alteração de Livro
          </h2>
        </div>
      </div>
    </section>

    <section class="section columns">
      <div class="container column">
        <div class="box">

          <?php
          if (isset($_GET['id'])) {
            $array = $livroDAO->buscarLivrosPorFiltro("idLivro",$_GET['id']);
            if (count($array) == 0) {
              echo "<h3 class='subtitle has-text-danger'>ID não encontrado.</h3>";
              return;
            }
            $dados = $array[0];
            unset($array);
          } else {
            echo "<h3 class='subtitle has-text-danger'>ID não encontrado.</h3>";
            return;
          }
          ?>

          <form action="" method="post">
            <div class="columns">
              <div class="field column">
                <label class="label">Título<span class="has-text-danger">*</span></label>
                <div class="control">
                  <input class="input" type="text" <?php if (isset($_SESSION['msg'])) { echo "disabled"; } ?> value="<?php echo $dados->titulo; ?>" required name="txttitulo" autofocus placeholder="Insira o título">
                </div>
              </div>
              <div class="field column">
                <label class="label">Autor(a)<span class="has-text-danger">*</span></label>
                <div class="control">
                  <input class="input" type="text" <?php if (isset($_SESSION['msg'])) { echo "disabled"; } ?> value="<?php echo $dados->autor; ?>" required name="txtautor" placeholder="Insira o(a) autor(a)">
                </div>
              </div>
            </div>

            <div class="columns">
              <div class="field column">
                <label class="label">Editora<span class="has-text-danger">*</span></label>
                <div class="control">
                  <input class="input" type="text" <?php if (isset($_SESSION['msg'])) { echo "disabled"; } ?> value="<?php echo $dados->editora; ?>" required name="txteditora" placeholder="Insira a editora">
                </div>
              </div>
              <div class="field column">
                <label class="label">Gênero<span class="has-text-danger">*</span></label>
                <div class="control">
                  <div class="select is-fullwidth">
                    <select <?php if (isset($_SESSION['msg'])) { echo "disabled"; } ?> required name="slcgenero">
                      <option disabled>Selecione o gênero</option>
                      <option <?php if ($dados->genero == "Mistério"){ echo "selected"; }  ?> value="Mistério">Mistério</option>
                      <option <?php if ($dados->genero == "Ficção Científica"){ echo "selected"; }  ?> value="Ficção Científica">Ficção Científica</option>
                      <option <?php if ($dados->genero == "Romance"){ echo "selected"; }  ?> value="Romance">Romance</option>
                      <option <?php if ($dados->genero == "Terror"){ echo "selected"; }  ?> value="Terror">Terror</option>
                      <option <?php if ($dados->genero == "Poesia"){ echo "selected"; }  ?> value="Poesia">Poesia</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="columns">
              <div class="field column">
                <label class="label">Ano de Lançamento<span class="has-text-danger">*</span></label>
                <div class="control">
                  <input class="input" type="number" min="1455" max="2018"<?php if (isset($_SESSION['msg'])) { echo "disabled"; } ?> value="<?php echo $dados->anoLanc; ?>" required name="txtanolanc" placeholder="Insira o ano de lançamento">
                </div>
              </div>
              <div class="field column">

                <label class="label">ISBN<span class="has-text-danger">*</span></label>
                <div class="control">
                  <input class="input" type="text" <?php if (isset($_SESSION['msg'])) { echo "disabled"; } ?> value="<?php echo $dados->isbn; ?>" required name="txtisbn" placeholder="Insira o ISBN">
                </div>
              </div>
            </div>

            <div class="field is-grouped">
              <div class="control">
                <input class="button is-link" <?php if (isset($_SESSION['msg'])) { echo "disabled"; } ?> type="submit" name="submit" value="Alterar">
              </div>
              <div class="control">
                <input class="button is-danger" <?php if (isset($_SESSION['msg'])) { echo "disabled"; } ?> type="reset" name="reset" value="Limpar">
              </div>
              <div class="content has-text-danger is-pulled-right">
                <p>* campos obrigatórios</p>
              </div>
            </div>

          </form>
        </div> <!--fecha box do form-->
      </div><!--fecha container do form-->

      <div class="container column">
        <?php
        if (isset($_SESSION['msg'])) {
          echo "<div class='notification is-success'>";
          echo "<h3 class='subtitle'>".$_SESSION['msg']."</h3>";
          $b = unserialize($_SESSION['book']);
          echo "<p>".$b."</p>";
          echo "<div class='buttons is-right'>";
          echo "<a href='buscar-livros.php' class='button is-link'>Voltar</a>";
          echo "</div>";
          echo "</div>";
          unset($_SESSION['msg']);
        } else if (isset($_POST['submit'])) {

          $book = new Livro();

          $book->titulo = $_POST['txttitulo'];
          $book->autor = $_POST['txtautor'];
          $book->editora = $_POST['txteditora'];
          $book->genero = $_POST['slcgenero'];
          $book->anoLanc = $_POST['txtanolanc'];
          $book->isbn = $_POST['txtisbn'];
          $book->idLivro = $_GET['id'];

          $livroDAO->alterarLivro($book);

          $_SESSION['msg'] = "Livro alterado com sucesso!";
          $_SESSION['book'] = serialize($book);

          header("location:alterar-livro.php?id=$dados->idLivro");
        } else {
          echo "<div class='notification'>";
          echo "<h3 class='subtitle'>Altere o livro ao lado!</h3>";
          echo "</div>";
        }
        ?>
      </div>
    </section><!--fecha section-->
  </body>
</html>
