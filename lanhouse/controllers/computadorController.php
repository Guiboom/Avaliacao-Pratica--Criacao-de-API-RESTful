<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../Models/Computador.php";

$request = $_SERVER['REQUEST_METHOD'];
$computador = new Computador;


if($request === 'GET') {

    if(isset($_GET['idComputador'])) {
        $id = $_GET['idComputador'];
        $buscaComputador = $computador->listarComputador($id);
        if($buscaComputador) {
            http_response_code(200);
            echo json_encode($buscaComputador);
        }
        exit;
    }

    $lista = $computador->listarComputadores();
    echo json_encode($lista);

} else if($request === 'POST') {
    $dadosRecebidos = json_decode(file_get_contents("php://input"), true);
    $nome = $dadosRecebidos['nome'];
    $numero = $dadosRecebidos['numero'];
    $status = $dadosRecebidos['status'];
    $pessoa_id = $dadosRecebidos['pessoa_id'];
    $inserir = $computador->cadastrarComputador($nome,$numero,$status,$pessoa_id);
    if($inserir) {
        http_response_code(201);
        echo json_encode(["mensagem"=>"Computador cadastrada"]);
    }
} else if($request === "DELETE") {
    if(isset($_GET['idComputador'])) {
        $id = $_GET['idComputador'];
        $deletar = $computador->deletarComputador($id);
        if($deletar) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Computador Deletada"]);
        }
    }
    exit;
    
} else if($request === "PUT") {
    $dadosRecebidos = json_decode(file_get_contents("php://input"), true);
    $alterar = $computador->alterar($dadosRecebidos);
    if($alterar) {
        echo json_encode([
            "mensagem" => "Computador Alterada"
        ]);
    } else {
        echo json_encode([
            "mensagem" => "Erro API"
        ]);
    }
}

?>