<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditEcommerceOrder
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AdmsEditEcommerceOrder {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $NumberInvoiceNf;

    function getResultado() {
        return $this->Resultado;
    }

    public function viewOrder($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewOrder = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $viewOrder->fullRead("SELECT e.*, l.nome store, f.nome colaborador, s.name status, u.nome creator FROM adms_ecommerce_orders e LEFT JOIN tb_lojas l ON l.id = e.loja_id LEFT JOIN tb_funcionarios f ON f.id = e.func_id LEFT JOIN adms_sits_ecommerce s ON s.id = e.adms_sit_ecommerce_id LEFT JOIN adms_usuarios u ON u.id = e.created_by WHERE e.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        } else {
            $viewOrder->fullRead("SELECT e.*, l.nome store, f.nome colaborador, s.name status, u.nome creator FROM adms_ecommerce_orders e LEFT JOIN tb_lojas l ON l.id = e.loja_id LEFT JOIN tb_funcionarios f ON f.id = e.func_id LEFT JOIN adms_sits_ecommerce s ON s.id = e.adms_sit_ecommerce_id LEFT JOIN adms_usuarios u ON u.id = e.created_by WHERE e.id =:id AND e.loja_id =:loja_id AND e.adms_sit_ecommerce_id =:adms_sit_ecommerce_id LIMIT :limit", "id={$this->DadosId}&loja_id=" . $_SESSION['usuario_loja'] . "&adms_sit_ecommerce_id=1&limit=1");
        }
        $this->Resultado = $viewOrder->getResult();
        return $this->Resultado;
    }

    public function altOrder(array $Dados) {
        $this->Dados = $Dados;
        $this->NumberInvoiceNf = $this->Dados['number_invoice_nf'];

        unset($this->Dados['number_invoice_nf']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditEcommerceOrder();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditEcommerceOrder() {

        $this->Dados['number_invoice_nf'] = $this->NumberInvoiceNf;
        $this->Dados['update_by'] = $_SESSION['usuario_id'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        //var_dump($this->Dados);

        $upAltOrder = new \App\adms\Models\helper\AdmsUpdate();
        $upAltOrder->exeUpdate("adms_ecommerce_orders", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltOrder->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Pedido de faturamento</strong> atualizado com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O pedido de faturamento não foi atualizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, name status FROM adms_sits_ecommerce ORDER BY id ASC");
        $registro['status'] = $listar->getResult();
        
        if ($_SESSION['ordem_nivac'] == STOREPERMITION) {
            $listar->fullRead("SELECT id s_id, nome store FROM tb_lojas WHERE id =:id AND status_id =:status_id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {
            $listar->fullRead("SELECT id s_id, nome store FROM tb_lojas WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        }
        $registro['store'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] == STOREPERMITION) {
            $listar->fullRead("SELECT id f_id, nome colaborador FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {//$_SESSION['area_id']
            $listar->fullRead("SELECT id f_id, nome colaborador FROM tb_funcionarios WHERE status_id =:status_id ORDER BY nome ASC", "status_id=1");
        }
        $registro['employee'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] == STOREPERMITION) {
            $listar->fullRead("SELECT id u_id, nome creator FROM adms_usuarios WHERE loja_id =:loja_id AND adms_sits_usuario_id =:adms_sits_usuario_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&adms_sits_usuario_id=1");
        } else {//$_SESSION['area_id']
            $listar->fullRead("SELECT id u_id, nome creator FROM adms_usuarios WHERE adms_sits_usuario_id =:adms_sits_usuario_id ORDER BY nome ASC", "adms_sits_usuario_id=1");
        }
        $registro['users'] = $listar->getResult();

        $this->Resultado = ['store' => $registro['store'], 'employee' => $registro['employee'], 'users' => $registro['users'], 'status' => $registro['status']];

        return $this->Resultado;
    }
}
