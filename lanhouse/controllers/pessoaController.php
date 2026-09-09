<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../Models/Pessoa.php";

$request = $_SERVER['REQUEST_METHOD'];
$pessoa = new Pessoa;


if($request === 'GET') {

    if(isset($_GET['idPessoa'])) {
        $id = $_GET['idPessoa'];
        $buscaPessoa = $pessoa->listarPesosa($id);
        if($buscaPessoa) {
            http_response_code(200);
            echo json_encode($buscaPessoa);
        }
        exit;
    }

    $lista = $pessoa->listarPessoas();
    echo json_encode($lista);

} else if($request === 'POST') {
    $dadosRecebidos = json_decode(file_get_contents("php://input"), true);
    $nome = $dadosRecebidos['nome'];
    $inserir = $pessoa->cadastrarPessoa($nome);
    if($inserir) {
        http_response_code(200);
        echo json_encode(["mensagem"=>"Pessoa cadastrada"]);
    }
} else if($request === "DELETE") {
    if(isset($_GET['idPessoa'])) {
        $id = $_GET['idPessoa'];
        $deletar = $pessoa->deletarPessoa($id);
        if($deletar) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Pessoa Deletada"]);
        }
    }
    exit;
    
} else if($request === "PUT") {
    $dadosRecebidos = json_decode(file_get_contents("php://input"), true);
    $alterar = $pessoa->alterar($dadosRecebidos);
    if($alterar) {
        echo json_encode([
            "mensagem" => "Pessoa Alterada"
        ]);
    } else {
        echo json_encode([
            "mensagem" => "Erro API"
        ]);
    }
}

?>