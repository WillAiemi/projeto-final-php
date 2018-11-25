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
} else {
    $_SESSION['msg'] = "Você precisa estar logado para acessar esse conteúdo.";
    header("location:index.php");
    die();
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
                                    <a href="cadastro-livro.php" class="navbar-item is-active">
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
                        Cadastro de Livros
                    </h2>
                </div>
            </div>
        </section>

        <section class="section columns">
            <div class="container column">
                <div class="box">
                    <form action="" method="post">
                        <div class="columns">
                            <div class="field column">
                                <label class="label">Título<span class="has-text-danger">*</span></label>
                                <div class="control">
                                    <input class="input" type="text" required name="txttitulo" autofocus placeholder="Insira o título">
                                </div>
                            </div>
                            <div class="field column">
                                <label class="label">Autor(a)<span class="has-text-danger">*</span></label>
                                <div class="control">
                                    <input class="input" type="text" required name="txtautor" placeholder="Insira o(a) autor(a)">
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="field column">
                                <label class="label">Editora<span class="has-text-danger">*</span></label>
                                <div class="control">
                                    <input class="input" type="text" required name="txteditora" placeholder="Insira a editora">
                                </div>
                            </div>
                            <div class="field column">
                                <label class="label">Gênero<span class="has-text-danger">*</span></label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select required name="slcgenero">
                                            <option disabled selected>Selecione o gênero</option>
                                            <option value="Mistério">Mistério</option>
                                            <option value="Ficção Científica">Ficção Científica</option>
                                            <option value="Romance">Romance</option>
                                            <option value="Terror">Terror</option>
                                            <option value="Poesia">Poesia</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="field column">
                                <label class="label">Ano de Lançamento<span class="has-text-danger">*</span></label>
                                <div class="control">
                                    <input class="input" type="number" min="1455" max="2018" required name="txtanolanc" placeholder="Insira o ano de lançamento">
                                </div>
                            </div>
                            <div class="field column">

                                <label class="label">ISBN<span class="has-text-danger">*</span></label>
                                <div class="control">
                                    <input class="input" type="text" required name="txtisbn" placeholder="Insira o ISBN">
                                </div>
                            </div>
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <input class="button is-link" type="submit" name="submit" value="Enviar">
                            </div>
                            <div class="control">
                                <input class="button is-danger" type="reset" name="reset" value="Limpar">
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
                include_once 'modelo/livro.class.php';
                include 'dao/livrodao.class.php';
                include 'util/utilidade.class.php';
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

                    $book->titulo = Utilidade::capitalizarPalavras($_POST['txttitulo']);
                    $book->autor = Utilidade::capitalizarPalavras($_POST['txtautor']);
                    $book->editora = Utilidade::capitalizarPalavras($_POST['txteditora']);
                    $book->genero = $_POST['slcgenero'];
                    $book->anoLanc = $_POST['txtanolanc'];
                    $book->isbn = $_POST['txtisbn'];

                    $livroDAO = new LivroDAO();
                    $livroDAO->cadastrarLivro($book);

                    $_SESSION['msg'] = "Livro cadastrado com sucesso!";
                    $_SESSION['book'] = serialize($book);

                    header("location:cadastro-livro.php");
                } else {
                    echo "<div class='notification'>";
                    echo "<h3 class='subtitle'>Cadastre seu livro ao lado!</h3>";
                    echo "</div>";
                }
                ?>
            </div>
        </section><!--fecha section-->
    </body>
</html>
