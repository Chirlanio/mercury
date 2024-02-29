<?php

namespace App\adms\Models\helper;

use PDOException;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

class AdmsDelete extends AdmsConn {

    private $Tabela;
    private $Termos;
    private $Values;
    private $Resultado;
    private $Query;
    private $Conn;

    public function getResultado() {
        return $this->Resultado;
    }

    public function exeDelete($Tabela, $Termos, $ParseString) {
        $this->Tabela = (string) $Tabela;
        $this->Termos = (string) $Termos;
        parse_str($ParseString, $this->Values);

        $this->executarInstrucao();
    }

    private function executarInstrucao() {
        $this->Query = "DELETE FROM {$this->Tabela} {$this->Termos}";
        $this->conexao();
        try {
            $stmt = $this->Conn->prepare($this->Query);
            $stmt->execute($this->Values);
            $this->Resultado = ($stmt->rowCount() > 0) ? true : false;
        } catch (PDOException $ex) {
            $this->Resultado = false;
        }
    }

    private function conexao() {
        $this->Conn = parent::getConn();
    }
}
