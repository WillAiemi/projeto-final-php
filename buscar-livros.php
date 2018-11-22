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
} else {
  $_SESSION['msg'] = "Você precisa estar logado para acessar esse conteúdo.";
  header("location:index.php");
  die();
}
include_once "dao/livrodao.class.php";
include_once "modelo/livro.class.php";

$livroDAO = new LivroDAO();
if (!isset($_GET['search'])) {
  $_GET['search'] = "all";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca do Bairro - Buscar Livros</title>
    <link href="node_modules/bulma/css/bulma.css" rel="stylesheet">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.css">
    <style>
      #margin-botton{
        margin-bottom: 1em;
      }
    </style>
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
                <a href="buscar-livros.php" class="navbar-item is-active">
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
          <h1 class="title">Biblioteca do Bairro</h1>
          <h2 class="subtitle">Pesquisar Livros</h2>
        </div>
      </div><!--fecha hero-body-->

      <div class="hero-foot">
        <nav class="tabs is-boxed is-fullwidth">
          <div class="container">
            <ul>
              <?php
              $buscaTodos = "<li><a href='?search=all'>Todos os Livros</a></li>";
              $buscaTitulo = "<li><a href='?search=title'>Buscar por Título</a></li>";
              $buscaAutor = "<li><a href='?search=author'>Buscar por Autor</a></li>";
              $buscaGenero = "<li><a href='?search=genre'>Buscar por Gênero</a></li>";

              switch ($_GET['search']) {
                case "all":
                  echo "<li class='is-active'><a href='#'>Todos os Livros</a></li>".$buscaTitulo.$buscaAutor.$buscaGenero;
                  break;
                case "title":
                  echo $buscaTodos."<li class='is-active'><a href='#'>Buscar por Título</a></li>".$buscaAutor.$buscaGenero;
                  break;
                case "author":
                  echo $buscaTodos.$buscaTitulo."<li class='is-active'><a href='#'>Buscar por Autor</a></li>".$buscaGenero;
                  break;
                case "genre":
                  echo $buscaTodos.$buscaTitulo.$buscaAutor."<li class='is-active'><a href='#'>Buscar por Gênero</a></li>";
                  break;
                default:
                  header("location:buscar-livros.php");
              }

              ?>
            </ul>
          </div>
        </nav>
      </div>
    </section>

    <section class="section">
      <div id="margin-botton" class="container">
        <?php
        $array;
        switch ($_GET['search']) {
          case "all":
            $array = $livroDAO->buscarLivros();
            break;
          case "title":
          case "author":
          case "genre":
            $r;
            switch ($_GET['search']) {
              case "title":
              $r = "título";
              break;
              case "author":
              $r = "autor(a)";
              break;
              case "genre":
              $r = "gênero";
              break;
            }

            echo "<form action='' method='post'>";
            echo "<div class='field has-addons'>";
            echo "<div class='control is-expanded'>";

            if (isset($_POST['q'])) {
              echo "<input class='input' type='text' name='q' value='".$_POST['q']."' placeholder='Insira palavras-chave ou ".$r." do livro que você procura'>";
            } else {
              echo "<input class='input' type='text' name='q' placeholder='Insira palavras-chave ou ".$r." do livro que você procura'>";
            }
            echo "</div>";
            echo "<div class='control has-icons-left'>";
            echo "<input type='submit' name='' value='Pesquisar' class='input button is-info'>";
            echo "<span class='icon is-medium is-left'><i class='fas fa-search'></i></span>";
            echo "</div>";
            echo "</div>";
            echo "</form>";

            if (isset($_POST['q'])) {
              switch ($_GET['search']) {
                case "title":
                $array = $livroDAO->buscarLivrosPorFiltro("titulo",$_POST['q']);
                break;

                case "author":
                $array = $livroDAO->buscarLivrosPorFiltro("autor",$_POST['q']);
                break;

                case "genre":
                $array = $livroDAO->buscarLivrosPorFiltro("genero",$_POST['q']);
                break;
              }
            }
        }
        if (isset($array)) {
          if(count($array) == 0){
            echo "</section>";
            echo "<div class='notification is-warning is-fullwidth'>";
            echo "<h3 class='subtitle has-text-centered'>Nenhum livro foi encontrado com os parâmetros da busca.</h3>";
            echo "</div>";
            return;
          }
        } else {
          return;
        }

        /*echo "<div class='section'>";
        foreach ($array as $livro) {
          echo "<div class='box'>";
          echo "<p>";
          echo $livro;
          echo "</p>";
          echo "</div>";
        }
        echo "</div>";*/
        ?>
      </div>

      <div class="table-container">
        <table class='table is-bordered is-striped is-hoverable is-fullwidth'>
          <thead>
            <tr>
              <th>ID Local</th>
              <th>Título</th>
              <th>Autor</th>
              <th>Editora</th>
              <th>Gênero</th>
              <th>Ano de lançamento</th>
              <th>ISBN</th>
            </tr>
          </thead>

          <tfoot>
            <tr>
              <th>ID Local</th>
              <th>Título</th>
              <th>Autor</th>
              <th>Editora</th>
              <th>Gênero</th>
              <th>Ano de lançamento</th>
              <th>ISBN</th>
            </tr>
          </tfoot>

          <tbody>
              <?php
              foreach ($array as $livro) {
                echo "<tr>";
                echo "<td>".$livro->idLivro."</td>";
                echo "<td>".$livro->titulo."</td>";
                echo "<td>".$livro->autor."</td>";
                echo "<td>".$livro->editora."</td>";
                echo "<td>".$livro->genero."</td>";
                echo "<td>".$livro->anoLanc."</td>";
                echo "<td>".$livro->isbn."</td>";
                if ($adm == true) {
                  echo "<td><a href='alterar-livro.php?id=".$livro->idLivro."' class='button is-warning'><span class='icon'><i class='far fa-edit'></i></span><span>Editar</span></td>";
                  echo "<td><a href='buscar-livros.php?id=$livro->idLivro&del=true' class='button is-danger is-small'><span class='icon'><i class='fas fa-times'></i></span><span>Excluir</span></td>";
                }
                echo "</tr>";
              }
              ?>
          </tbody>
        </table>
      </div> <!-- fecha table container -->
    </section> <!--fecha section-->
    <?php
    if (isset($_GET['del'])) {
      if ($_GET['del'] == true) {
        $livroDAO->excluirLivro($_GET['id']);
        header("location:buscar-livros.php");
      }
    }

    ?>
  </body>
</html>
