<?php
$conexao = mysqli_connect("localhost", "root", "", "apiPessoas");

if (mysqli_connect_errno()) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(["erro" => "Falha ao conectar ao MySQL: " . mysqli_connect_error()]);
    exit();
}