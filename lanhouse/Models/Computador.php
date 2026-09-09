<?php
    require_once __DIR__ . "/../conexao.php";

    class Computador {

        public function listarComputadoress() {
            global $conexao;
            $sql = "SELECT * FROM computador";
            $resultado = $conexao->query($sql);
            if($resultado) {
                $dados = [];
                while($row = $resultado->fetch_assoc()) {
                    $dados[] = $row; 
                }
            }
            return $dados;
        }

        public function listarComputador($id) {
            global $conexao;
            $sql = "SELECT * FROM computador WHERE id = $id";
            $resultado = $conexao->query($sql);
            return $resultado->fetch_assoc();
        }

        public function cadastrarComputador($nome,$telefone,$email) {
            global $conexao;
            $sql = "INSERT INTO computador(nome, telefone, email) VALUES ('$nome', '$telefone', '$email')";
            return $conexao->query($sql);
        }

        public function deletarComputador($id) {
            global $conexao;
            $sql = "DELETE FROM computador WHERE id = $id";
            return $conexao->query($sql);
            
        }

        public function alterar($dados) {
            global $conexao;
            $sql = "UPDATE computador SET nome = '" .$dados['nome']. "', telefone = '" .$dados['telefone']. "', email = '" .$dados['email']. "' WHERE id = " .$dados['id'];
            return $conexao->query($sql);
        }

    }
?>