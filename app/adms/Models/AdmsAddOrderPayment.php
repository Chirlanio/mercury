<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAddOrderPayment
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meioa Sola
 */
class AdmsAddOrderPayment {

    private $Resultado;
    private $Dados;
    private $Filename;
    private $AdvanceAmount;
    private $Agency;
    private $Checking;
    private $Bank;
    private $TypeKey;
    private $KeyPix;
    private $NumberNf;
    private $obs;

    function getResultado() {
        return $this->Resultado;
    }

    public function addOrder(array $Dados) {

        $this->Dados = $Dados;

        $this->Agency = $this->Dados['agency'];
        $this->Checking = $this->Dados['checking_account'];
        $this->Bank = $this->Dados['bank_id'];
        $this->TypeKey = $this->Dados['adms_type_key_pix_id'];
        $this->KeyPix = $this->Dados['key_pix'];
        $this->AdvanceAmount = $this->Dados['advance_amount'];
        $this->NumberNf = $this->Dados['number_nf'];
        $this->Filename = !empty($this->Dados['file_name']) ? $this->Dados['file_name'] : null;
        $this->obs = !empty($this->Dados['obs']) ? $this->Dados['obs'] : null;
        unset($this->Dados['agency'], $this->Dados['checking_account'], $this->Dados['bank_id'], $this->Dados['adms_type_key_pix_id'], $this->Dados['key_pix'], $this->Dados['advance_amount'], $this->Dados['number_nf'], $this->Dados['file_name'], $this->Dados['obs']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->insertOrder();
        } else {
            $this->Resultado = false;
        }
    }

    private function insertOrder() {

        $this->Dados['created_date'] = date("Y-m-d");
        $this->Dados['agency'] = (!empty($this->Agency) ? $this->Agency : null);
        $this->Dados['checking_account'] = (!empty($this->Checking) ? $this->Checking : null);
        $this->Dados['bank_id'] = (!empty($this->Bank) ? $this->Bank : null);
        $this->Dados['adms_type_key_pix_id'] = (!empty($this->TypeKey) ? $this->TypeKey : null);
        $this->Dados['advance_amount'] = (!empty($this->AdvanceAmount) ? str_replace(',', '.', str_replace('.', '', $this->AdvanceAmount)) : 0);
        $this->Dados['total_value'] = str_replace(',', '.', str_replace('.', '', $this->Dados['total_value']));
        $this->Dados['number_nf'] = (!empty($this->NumberNf) ? $this->NumberNf : 0);
        $this->Dados['key_pix'] = (!empty($this->KeyPix) ? $this->KeyPix : null);
        $this->Dados['adms_sits_order_pay_id'] = ($this->Dados['advance'] == 1 ? 3 : 1);
        $this->Dados['obs'] = $this->obs;
        $this->Dados['created'] = date("Y-m-d H:i:s");

        if (!empty($this->Filename['name'])) {
            $slugFile = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['file_name'] = $slugFile->nomeSlug($this->Filename['name']);
        }
        
        $addOrder = new \App\adms\Models\helper\AdmsCreate;
        $addOrder->exeCreate("adms_order_payments", $this->Dados);

        if ($addOrder->getResultado()) {
            if (empty($this->Filename['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento:</strong> Cadastrada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $addOrder->getResultado();
                $this->valArquivo();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A solicitação não foi cadastrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function valArquivo() {
        $uploadFile = new \App\adms\Models\helper\AdmsUpload();
        $uploadFile->upload($this->Filename, 'assets/files/orderPayments/' . $this->Dados['id'] . '/', $this->Dados['file_name']);
        if ($uploadFile->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento:</strong> Solicitação cadastrada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação cadastrada. Erro ao realizar o upload do arquivo!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id a_id, name area FROM adms_areas WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        $registro['area'] = $listar->getResultado();

        $listar->fullRead("SELECT id c_id, name costCenter FROM adms_cost_centers WHERE status_id =:status_id ORDER BY name ASC", "status_id=1");
        $registro['cost'] = $listar->getResultado();

        $listar->fullRead("SELECT id b_id, brand FROM adms_brands_suppliers WHERE status_id =:status_id ORDER BY brand ASC", "status_id=1");
        $registro['brand'] = $listar->getResultado();

        $listar->fullRead("SELECT id sup_id, fantasy_name, cnpj_cpf FROM adms_suppliers WHERE status_id =:status_id ORDER BY fantasy_name ASC", "status_id=1");
        $registro['supplier'] = $listar->getResultado();

        $listar->fullRead("SELECT id t_id, name type_payment FROM adms_type_payments WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        $registro['type_payment'] = $listar->getResultado();

        $listar->fullRead("SELECT id b_id, bank_name FROM adms_banks WHERE status_id =:status_id ORDER BY bank_name ASC", "status_id=1");
        $registro['bank'] = $listar->getResultado();

        $listar->fullRead("SELECT id p_id, name key_name FROM adms_type_key_pixs WHERE status_id =:status_id ORDER BY name ASC", "status_id=1");
        $registro['key_pix'] = $listar->getResultado();

        $listar->fullRead("SELECT id m_id, name manager FROM adms_managers WHERE status_id =:status_id ORDER BY name ASC", "status_id=1");
        $registro['manager'] = $listar->getResultado();

        $this->Resultado = ['area' => $registro['area'], 'cost' => $registro['cost'], 'brand' => $registro['brand'], 'supplier' => $registro['supplier'],
            'type_payment' => $registro['type_payment'], 'bank' => $registro['bank'], 'key_pix' => $registro['key_pix'], 'manager' => $registro['manager']];

        return $this->Resultado;
    }
}
