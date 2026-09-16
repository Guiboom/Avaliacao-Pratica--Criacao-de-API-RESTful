<?php
    require_once __DIR__ . "/../conexao.php";

    class Computador {

        private $conexao;


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

        public function listarComputador($id) {//ta guloso o erro kkkk
            global $conexao;
            $sql = "SELECT * FROM computador WHERE id = $id";


            
            $pessoa = $conexao->query("SELECT * FROM pessoa WHERE id=$id");

            $computador['pessoa_id'] = $pessoa->fetchAll();
            $resultado = $conexao->query($sql);
            return $resultado->fetch_assoc();
/*         $sqlComputador = $this->conexao->query("SELECT * FROM computador WHERE id=$id");
        $computador = $sqlComputador->fetch();

        $pessoa = $this->conexao->query("SELECT * FROM pessoa WHERE id=$id");

        $computador['id_pessoa'] = $pessoa->fetch(PDO::FETCH_ASSOC);
        $result = $computador;

        return $result; */
        }

        public function cadastrarComputador($nome,$numero,$status,$pessoa_id) {
            global $conexao;
            if ($pessoa_id === null){
                $sql = "INSERT INTO computador(nome, numero, status, pessoa_id) VALUES ('$nome', '$numero', '$status', NULL )";
            }else{
                $sql = "INSERT INTO computador(nome, numero, status, pessoa_id) VALUES ('$nome', '$numero', '$status', '$pessoa_id' )";
            }
            return $conexao->query($sql);
        }

        public function deletarComputador($id) {
            global $conexao;
            $sql = "DELETE FROM computador WHERE id = $id";
            return $conexao->query($sql);
            
        }

        public function alterar($dados) {
            global $conexao;
            if ($dados['pessoa_id'] === null){
                $pessoa_id = "NULL";
                }else{
                $pessoa_id = $dados['pessoa_id'];
                }
            $sql = "UPDATE computador SET nome = '" .$dados['nome']. "', numero = '" .$dados['numero']. "', status = '" .$dados['status']. "', pessoa_id = $pessoa_id WHERE id = " .$dados['id'];
            return $conexao->query($sql);
        }

    }
?>