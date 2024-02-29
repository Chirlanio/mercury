<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsDeletePersonnelMoviments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsDeletePersonnelMoviments {

    private $DadosId;
    private $Resultado;
    private $DadosArq;

    function getResultado() {
        return $this->Resultado;
    }

    public function deleteMoviment($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->viewMoviment();
        if ($this->DadosArq) {
            $delMoviment = new \App\adms\Models\helper\AdmsDelete();
            $delMoviment->exeDelete("adms_personnel_moviments", "WHERE id =:id AND adms_sits_personnel_mov_id =:adms_sits_personnel_mov_id", "id={$this->DadosId}&adms_sits_personnel_mov_id=1");
            if ($delMoviment->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarArq();
                $apagarImg->apagarArq('assets/files/mp/' . $this->DadosId . '/' . $this->DadosArq[0]['file_name'], 'assets/files/mp/' . $this->DadosId);
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Movimentação de Pessoal</strong> e arquivos apagados com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = false;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Só é permitido apagar solicitações com a situação \"Pendente\"!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Cadastro e o Arquivos não foram apagados!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function viewMoviment() {
        $viewOrder = new \App\adms\Models\helper\AdmsRead();
        $viewOrder->fullRead("SELECT * FROM adms_personnel_moviments WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosArq = $viewOrder->getResultado();
    }
}
