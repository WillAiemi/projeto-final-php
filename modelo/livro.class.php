<?php //LIVROS(IDLIVRO, TITULO,AUTOR,EDITORA,GENERO,ANOLANÇAMENTO, ISBN)
class Livro{
  private $idLivro;
  private $titulo;
  private $autor;
  private $editora;
  private $genero;
  private $anoLanc;
  private $isbn;

  public function __construct(){}
  public function __destruct(){}

  public function __get($a){ return $this->$a; }
  public function __set($a, $v){ $this->$a = $v; }

  public function __toString(){
    if (isset($this->idLivro)) {
      return nl2br("ID Local: $this->idLivro
                    Título: $this->titulo
                    Autor: $this->autor
                    Editora: $this->editora
                    Gênero: $this->genero
                    Ano de Lançamento: $this->anoLanc
                    ISBN: $this->isbn");
    }
    return nl2br("Título: $this->titulo
                  Autor: $this->autor
                  Editora: $this->editora
                  Gênero: $this->genero
                  Ano de Lançamento: $this->anoLanc
                  ISBN: $this->isbn");
  }
}
