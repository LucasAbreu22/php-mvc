<?php

class AdminController{
    public function index(){
            $loader = new \Twig\Loader\FilesystemLoader('./app/view');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('admin.html');

            $objPostagens = Postagem::selecionarTodos();

            $parametros = array();
            $parametros['postagens'] = $objPostagens;

            $conteudo = $template->render($parametros);

            echo  $conteudo;
    }

    public function create(){
            $loader = new \Twig\Loader\FilesystemLoader('./app/view');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('create.html');

            $parametros = array();

            $conteudo = $template->render($parametros);

            echo  $conteudo;
    }

    public function insert(){

        try{
            Postagem::insert($_POST);

            echo "<script>alert('Publicação inserida com sucesso!');</script>";
            echo "<script>location.href='http://localhost/phpMVC/?pagina=admin&metodo=index'</script>";

        }catch (Exception $e){
            echo "<script>alert('".$e->getMessage()."');</script>";
            echo "<script>location.href='http://localhost/phpMVC/?pagina=admin&metodo=create'</script>";

        }
        
    }

    public function edit($params){
        try{
            $loader = new \Twig\Loader\FilesystemLoader('./app/view');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('edit.html');

            $parametros = array();
            $conteudo = Postagem::selecionarPorId($params);

            $parametros['id'] = $conteudo->id;
            $parametros['titulo'] = $conteudo->titulo;
            $parametros['conteudo'] = $conteudo->conteudo;
            
            $conteudo = $template->render($parametros);

            echo  $conteudo;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function editar(){
        try{
            Postagem::edit($_POST);

            echo "<script>alert('Publicação editada com sucesso!');</script>";

        }catch (Exception $e){
            echo "<script>alert('".$e->getMessage()."');</script>";

        }
        echo "<script>location.href='http://localhost/phpMVC/?pagina=admin&metodo=index'</script>";

    }

    public function delete($params){
        try{

            $conteudo = Postagem::selecionarPorId($params);

            if(isset($conteudo->comentarios)){
                Postagem::deleteComentario($params);
            }

            Postagem::deletePost($params);
            
            echo "<script>alert('Publicação deletada com sucesso!');</script>";

        }catch(Exception $e){
            echo "<script>alert('".$e->getMessage()."');</script>";

        }
       echo "<script>location.href='http://localhost/phpMVC/?pagina=admin&metodo=index'</script>";

    }
}