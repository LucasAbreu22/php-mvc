<?php

class Postagem{
    public static function selecionarTodos(){
        $con = Connection::getConn();

        $sql = "SELECT * FROM postagem ORDER BY id DESC";

        $sql = $con->prepare($sql);
        $sql->execute();

        $resultado = array();

        while ($row = $sql->fetchObject('Postagem')){
            $resultado[] = $row;
        }

        if(!$resultado){
            throw new Exception("Não foi encontrado resultado no banco!");
        }

        return $resultado;
    }

    public static function selecionarPorId($idPost){
        $con = Connection::getConn();

        $sql = "SELECT * FROM postagem WHERE id = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $idPost, PDO::PARAM_INT);
        $sql->execute();

        $resultado = $sql->fetchObject('Postagem');

        if(!$resultado){
            throw new Exception("Não foi encontrado resultado no banco!");
        }else{
            $resultado->comentario = Comentario::selecionarComentarios($resultado->id);
        }

        return $resultado;
    }

    public static function insert($dadosPost){
        if(empty($dadosPost['titulo']) || empty($dadosPost['conteudo'])){
            throw new Exception("Preencha todos os campos!");
            return false;
        }

        $con = Connection::getConn();

        $sql = "INSERT INTO postagem (titulo, conteudo) VALUES (:titulo, :conteudo)";
        $sql = $con->prepare($sql);
        $sql->bindValue(':titulo', $dadosPost['titulo']);
        $sql->bindValue(':conteudo', $dadosPost['conteudo']);
        $res = $sql->execute();

        if($res == 0){
            throw new Exception("Falha ao inserir publicação!");
            return false;
        }

        return true;

    }

    public static function edit($dadosPost){
        if(empty($dadosPost['titulo']) || empty($dadosPost['conteudo'])){
            throw new Exception("Preencha todos os campos!");
            return false;
        }

        if(empty($dadosPost['id'])){
            throw new Exception("Postagem não identificada![1]");
        }

        $con = Connection::getConn();

        $sql = "UPDATE postagem SET titulo = :titulo, conteudo = :conteudo WHERE id = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':titulo', $dadosPost['titulo']);
        $sql->bindValue(':conteudo', $dadosPost['conteudo']);
        $sql->bindValue(':id', $dadosPost['id'], PDO::PARAM_INT);

        $res = $sql->execute();

        if($res == 0){
            throw new Exception("Falha ao editar publicação!");
            return false;
        }

        return true;

    }

    public static function deletePost($idPost){
        if(empty($idPost)){
            throw new Exception('Postagem não identificada![2]');
        }

        $con = Connection::getConn();

        $sql = "DELETE FROM postagem WHERE id = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $idPost, PDO::PARAM_INT);

        $res = $sql->execute();

        if($res == 0){
            throw new Exception("Falha ao deletar publicação![2]");
            return false;
        }

        return true;
    }

    public static function deleteComentario($idPost){
        if(empty($idPost)){
            throw new Exception('Postagem não identificada![3]');
        }

        $con = Connection::getConn();

        $sql = "DELETE FROM comentario WHERE id_postagem = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $idPost, PDO::PARAM_INT);

        $res = $sql->execute();

        if($res == 0){
            throw new Exception("Falha ao deletar publicação![1]");
            return false;
        }

        return true;
    }
    
}