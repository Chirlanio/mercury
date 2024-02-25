<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAddEcommerceOrder
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meioa Sola
 */
class AdmsAddEcommerceOrder {

    private $Resultado;
    private $Dados;
    private $treatData;

    function getResultado() {
        return $this->Resultado;
    }

    public function addOrder(array $Dados) {

        $this->Dados = $Dados;
        $this->treatData['number_invoice_nf'] = isset($this->Dados['number_invoice_nf']) ? $this->Dados['number_invoice_nf'] : null;
        unset($this->Dados['number_invoice_nf']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->insertEcommerceOrder();
        } else {
            $this->Resultado = false;
        }
    }

    private function insertEcommerceOrder() {

        $this->Dados['created_by'] = $_SESSION['usuario_id'];
        $this->Dados['date_order'] = date("Y-m-d", strtotime($this->Dados['date_order']));
        $this->Dados['number_invoice_nf'] = $this->treatData['number_invoice_nf'];
        $this->Dados['adms_sit_ecommerce_id'] = 1;
        $this->Dados['created'] = date("Y-m-d H:i:s");

        $addProcess = new \App\adms\Models\helper\AdmsCreate();
        $addProcess->exeCreate("adms_ecommerce_orders", $this->Dados);

        if ($addProcess->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Pedido</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O pedido não foi cadastrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listar->fullRead("SELECT id s_id, nome store FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id={$_SESSION['usuario_loja']}");
        } else {
            $listar->fullRead("SELECT id s_id, nome store FROM tb_lojas WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        }
        $registro['store'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listar->fullRead("SELECT id f_id, nome colaborador FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {
            $listar->fullRead("SELECT id f_id, nome colaborador FROM tb_funcionarios WHERE status_id =:status_id ORDER BY nome ASC");
        }
        $registro['employee'] = $listar->getResultado();

        $this->Resultado = ['store' => $registro['store'], 'employee' => $registro['employee']];

        return $this->Resultado;
    }
}
