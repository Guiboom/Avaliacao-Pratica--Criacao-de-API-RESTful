<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../Models/Computador.php";
require_once __DIR__ . "/../Models/Pessoa.php";

$request = $_SERVER['REQUEST_METHOD'];
$computador = new Computador;
$Pessoa = new Pessoa;


if($request === 'GET') {

    if(isset($_GET['idComputador'])) {
        $id = $_GET['idComputador'];
        $buscaComputador = $computador->listarComputador($id);
        if($buscaComputador) {
            http_response_code(200);
            echo json_encode($buscaComputador);
        } else {
            http_response_code(404);
            echo json_encode([
                "mensagem" => "Computador não encontrado"
            ]);
        }
        exit;
    }else{
        $lista = $computador->listarComputadores();
        echo json_encode($lista);
    }



} else if($request === 'POST') {
    $dadosRecebidos = json_decode(file_get_contents("php://input"), true);
    $nome = $dadosRecebidos['nome'];
    $numero = $dadosRecebidos['numero'];
    $status = $dadosRecebidos['status'];
    $pessoa_id = $dadosRecebidos['pessoa_id'];
    if($pessoa_id === null) {
        $inserir = $computador->cadastrarComputador($nome,$numero,$status,$pessoa_id);
        if($inserir === false){
            http_response_code(400);
            echo json_encode([
                "mensagem" => "Erro API"
            ]);
        }else{
        http_response_code(201);
        echo json_encode(["mensagem"=>"Computador cadastrado"]);
        }

    } else {
        $pessoa = $Pessoa->listarPessoa($pessoa_id);
        if($pessoa){
            $inserir = $computador->cadastrarComputador($nome,$numero,$status,$pessoa_id);
            if($inserir === false){
                http_response_code(400);
                echo json_encode([
                    "mensagem" => "Erro API"
                ]);
            }else{
            http_response_code(201);
            echo json_encode(["mensagem"=>"Computador cadastrado"]);
            }
        }else{
        http_response_code(400);
        echo json_encode([
            "mensagem" => "Erro API"
        ]);
        }
    }
} else if($request === "DELETE") {
    if(isset($_GET['idComputador'])) {
        $id = $_GET['idComputador'];
        $computadorExiste = $computador->listarComputador($id);
        if($computadorExiste){
            $deletar = $computador->deletarComputador($id);
            if($deletar) {
                http_response_code(200);
                echo json_encode(["mensagem" => "Computador Deletado"]);
            } else {
                http_response_code(404);
            echo json_encode([
                "mensagem" => "Erro id não existente"
            ]);}
        }else{
            http_response_code(404);
            echo json_encode([
                "mensagem" => "Erro Computador inexistente"
            ]);}
    }else{
        http_response_code(404);
            echo json_encode([
            "mensagem" => "Erro id não existente"
        ]);
    }
    exit;
    
} else if($request === "PUT") {
    if(isset($_GET['idComputador'])) {
        
        $dadosRecebidos = json_decode(file_get_contents("php://input"), true);
        $pessoa_id = $dadosRecebidos['pessoa_id'];
        $id = $_GET['idComputador'];
        $computadorExiste = $computador->listarComputador($id);

        if($computadorExiste) {
            if($pessoa_id === null){
                $alterar = $computador->alterar($dadosRecebidos);
                http_response_code(200);
                echo json_encode([
                    "mensagem" => "Computador Alterado"
                ]);
            } /* else {
                $pessoa = $Pessoa->listarPessoa($pessoa_id);
                if($pessoa) {
                    $alterar = $computador->alterar($dadosRecebidos);
                    http_response_code(200);
                    echo json_encode([
                        "mensagem" => "Computador Alterado"
                    ]);
                } else {
                    http_response_code(400);
                    echo json_encode([
                        "mensagem" => "Pessoa não encontrada"
                    ]);
                }
            } */
        } else {
            http_response_code(404);
            echo json_encode([
                "mensagem" => "Computador não encontrado"
            ]);
        }
    } else {
        http_response_code(404);
        echo json_encode([
            "mensagem" => "Computador não encontrado"
        ]);
    }
}