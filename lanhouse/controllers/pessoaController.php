<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../Models/Pessoa.php";

$request = $_SERVER['REQUEST_METHOD'];
$pessoa = new Pessoa;


if($request === 'GET') {

    if(isset($_GET['idPessoa'])) {
        $id = $_GET['idPessoa'];
        $buscaPessoa = $pessoa->listarPessoa($id);
        if($buscaPessoa) {
            http_response_code(200);
            echo json_encode($buscaPessoa);
        }else{
            http_response_code(404);
            echo json_encode(["mensagem"=>"Pessoa não encontrada"]);
        }
        exit;
    }

    $lista = $pessoa->listarPessoas();
    echo json_encode($lista);

} else if($request === 'POST') {
    $dadosRecebidos = json_decode(file_get_contents("php://input"), true);
    $nome = $dadosRecebidos['nome'];
    $telefone = $dadosRecebidos['telefone'];
    $email = $dadosRecebidos['email'];
    $inserir = $pessoa->cadastrarPessoa($nome,$telefone,$email);
    if($inserir) {
        http_response_code(201);
        echo json_encode(["mensagem"=>"Pessoa cadastrada"]);
    }
} else if($request === "DELETE") {

    if(isset($_GET['idPessoa'])) {
        $id = $_GET['idPessoa'];
        $pessoaExiste = $pessoa->listarPessoa($id);
        if($pessoaExiste) {
            $deletar = $pessoa->deletarPessoa($id);
            if($deletar) {
                http_response_code(200);
                echo json_encode(["mensagem" => "Pessoa Deletada"]);
            }  else {

$ch = curl_init('http://localhost/lanhouse/controllers/computadorController.php?idPessoa=' . $id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if($http_code === 409) {
                    http_response_code(409);
                    echo json_encode([
                        "mensagem" => "Não é possível deletar a pessoa pois existem computadores associados"
                    ]);

curl_close($ch);

                } else {
                    http_response_code(404);
                    echo json_encode([
                        "mensagem" => "Pessoa não encontrada"
                    ]);
                }
            }


            
        }else{
            http_response_code(404);
            echo json_encode([
            "mensagem" => "Pessoa não encontrada"
            ]);   
        }
    } else {
        http_response_code(404);
        echo json_encode([
            "mensagem" => "ID não informado"
        ]);
    }
    exit;
} else if($request === "PUT") {
    $dadosRecebidos = json_decode(file_get_contents("php://input"), true);
    $id = $_GET['id'];
    $pessoaExiste = $pessoa->listarPessoa($id);
    if($pessoaExiste) {
        $alterar = $pessoa->alterar($dadosRecebidos);
        if($alterar) {
            http_response_code(200);
            echo json_encode([
                "mensagem" => "Pessoa Alterada"
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "mensagem" => "Erro API"
            ]);
        }
    }else{
    
    }
}

?>