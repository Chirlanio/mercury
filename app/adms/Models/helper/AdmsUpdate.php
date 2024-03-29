<?php

namespace App\adms\Models\helper;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsUpdate
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsUpdate extends AdmsConn {

    private $Tabela;
    private $Dados;
    private $Query;
    private $Conn;
    private $Resultado;
    private $Termos;
    private $Values;

    function getResult() {
        return $this->Resultado;
    }

    public function exeUpdate($Tabela, array $Dados, $Termos = null, $ParseString = null) {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;
        $this->Termos = (string) $Termos;

        parse_str($ParseString, $this->Values);
        $this->getIntrucao();
        $this->executarInstrucao();
    }

    private function getIntrucao() {
        foreach ($this->Dados as $key => $Value) {
            $Values[] = $key . '= :' . $key;
        }
        $Values = implode(', ', $Values);
        $this->Query = "UPDATE {$this->Tabela} SET {$Values} {$this->Termos}";
    }

    private function executarInstrucao() {
        $this->conexao();
        try {
            $this->Query->execute(array_merge($this->Dados, $this->Values));
            $this->Resultado = true;
        } catch (Exception $ex) {
            $this->Resultado = null;
        }
    }

    private function conexao() {
        $this->Conn = parent::connectDb();
        $this->Query = $this->Conn->prepare($this->Query);
    }

}
