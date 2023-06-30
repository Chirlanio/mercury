<?php

namespace App\adms\Models\helper;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsImportFile
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsImportFile extends AdmsConn {

    private $Tabela;
    private $Dados;
    private $Query;
    private $Conn;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function exeImport($Tabela, array $Dados) {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;
        $this->getIntrucao();
        $this->executarInstrucao();
    }

    private function getIntrucao() {
        $this->Query = "LOAD DATA LOCAL INFILE INTO " . URLADM . "'assets/files/imports/' TABLE {$this->Tabela} FIELDS TERMINATED by ';' LINES TERMINATED BY '\n' IGNORE 1 ROWS";
    }

    private function executarInstrucao() {
        $this->conexao();
        try {
            $this->Query->execute($this->Dados);
            $this->Resultado = $this->Conn->lastInsertId();
        } catch (Exception $ex) {
            $this->Resultado = null;
        }
    }

    private function conexao() {
        $this->Conn = parent::getConn();
        $this->Query = $this->Conn->prepare($this->Query);
    }

}
