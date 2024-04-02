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

    function getResultado() {
        return $this->Resultado;
    }

    public function deleteMoviment($DadosId = null) {
        $this->DadosId = (int) $DadosId;

        $delMoviment = new \App\adms\Models\helper\AdmsDelete();
        $delMoviment->exeDelete("adms_personnel_moviments", "WHERE id =:id AND adms_sits_personnel_mov_id =:adms_sits_personnel_mov_id", "id={$this->DadosId}&adms_sits_personnel_mov_id=1");

        if ($delMoviment->getResult()) {
            $delFiles = new \App\adms\Models\helper\AdmsApagarArq();
            $delFiles->apagarArq('assets/files/mp/' . $this->DadosId, 'assets/files/mp/' . $this->DadosId);
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Movimentação de Pessoal</strong> e arquivos apagados com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Só é permitido apagar solicitações com a situação \"Pendente\"!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }
}
