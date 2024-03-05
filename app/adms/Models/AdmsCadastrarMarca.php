<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarMarca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarMarca {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadMarca(array $Dados) {
        $this->Dados = $Dados;
        
        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirMarca();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirMarca() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadAjuste = new \App\adms\Models\helper\AdmsCreate;
        $cadAjuste->exeCreate("adms_marcas", $this->Dados);
        if ($cadAjuste->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Solicitação enviada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro: </strong>Solicitação não cadastrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status ORDER BY nome ASC");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
