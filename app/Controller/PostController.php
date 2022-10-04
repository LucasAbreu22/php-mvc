<?php

class PostController{
    public function index($params){

            $loader = new \Twig\Loader\FilesystemLoader('./app/view');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('single.html');

            $parametros = array();
            $conteudo = Postagem::selecionarPorId($params);

            $parametros['id'] = $conteudo->id;
            $parametros['titulo'] = $conteudo->titulo;
            $parametros['conteudo'] = $conteudo->conteudo;
            $parametros['comentarios'] = $conteudo->comentario;

            $conteudo = $template->render($parametros);

            echo  $conteudo;
        
    }
}