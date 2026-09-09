<?php
    require_once __DIR__ . "/../conexao.php";

    class Pessoa {

        public function listarPessoas() {
            global $conexao;
            $sql = "SELECT * FROM pessoa";
            $resultado = $conexao->query($sql);
            if($resultado) {
                $dados = [];
                while($row = $resultado->fetch_assoc()) {
                    $dados[] = $row; 
                }
            }
            return $dados;
        }

        public function listarPessoa($id) {
            global $conexao;
            $sql = "SELECT * FROM pessoa WHERE id = $id";
            $resultado = $conexao->query($sql);
            return $resultado->fetch_assoc();
        }

        public function cadastrarPessoa($nome,$telefone,$email) {
            global $conexao;
            $sql = "INSERT INTO pessoa(nome, telefone, email) VALUES ('$nome', '$telefone', '$email')";
            return $conexao->query($sql);
        }

        public function deletarPessoa($id) {
            global $conexao;
            $sql = "DELETE FROM pessoa WHERE id = $id";
            return $conexao->query($sql);
            
        }

        public function alterar($dados) {
            global $conexao;
            $sql = "UPDATE pessoa SET nome = '" .$dados['nome']. "', telefone = '" .$dados['telefone']. "', email = '" .$dados['email']. "' WHERE id = " .$dados['id'];
            return $conexao->query($sql);
        }

    }
?>