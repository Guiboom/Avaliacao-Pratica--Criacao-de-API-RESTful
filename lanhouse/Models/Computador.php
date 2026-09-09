<?php
    require_once __DIR__ . "/../conexao.php";

    class Computador {

        public function listarComputadores() {
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

        public function cadastrarComputador($nome,$numero,$status,$pessoa_id) {
            global $conexao;
            $sql = "INSERT INTO computador(nome, numero, status, pessoa_id) VALUES ('$nome', '$numero', '$status', '$pessoa_id' )";
            return $conexao->query($sql);
        }

        public function deletarComputador($id) {
            global $conexao;
            $sql = "DELETE FROM computador WHERE id = $id";
            return $conexao->query($sql);
            
        }

        public function alterar($dados) {
            global $conexao;
            $sql = "UPDATE computador SET nome = '" .$dados['nome']. "', numero = '" .$dados['numero']. "', status = '" .$dados['status']. "' WHERE id = " .$dados['id']. "', pessoa_id = '" .$dados['pessoa_id']. "' WHERE id = " .$dados['id'];
            return $conexao->query($sql);
        }

    }
?>