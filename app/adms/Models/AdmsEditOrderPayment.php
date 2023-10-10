<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditOrderPayment
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AdmsEditOrderPayment {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $File;
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

    public function viewOrder($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewOrder = new \App\adms\Models\helper\AdmsRead();
        $viewOrder->fullRead("SELECT op.* FROM adms_order_payments op WHERE op.id =:id LIMIT :limit", "id={$this->DadosId}&limit=1");
        $this->Resultado = $viewOrder->getResultado();
        return $this->Resultado;
    }

    public function altOrder(array $Dados) {
        $this->Dados = $Dados;
        $this->File = (!empty($this->Dados['new_file']['name'])) ? $this->Dados['new_file'] : $this->Dados['file_name'];
        $this->Bank = $this->Dados['bank_id'];
        $this->NumberNf = $this->Dados['number_nf'];
        $this->Agency = $this->Dados['agency'];
        $this->AdvanceAmount = $this->Dados['advance_amount'];
        $this->Checking = $this->Dados['checking_account'];
        $this->TypeKey = $this->Dados['adms_type_key_pix_id'];
        $this->KeyPix = $this->Dados['key_pix'];
        $this->obs = (!empty($this->Dados['obs']) ? $this->Dados['obs'] : null);

        $this->Dados['total_value'] = str_replace(',', '.', str_replace('.', '', $this->Dados['total_value']));
        if ((!empty($this->Dados['total_value'])) and (!empty($this->Dados['advance_amount']))) {
            $this->Dados['advance_amount'] = (!empty($this->AdvanceAmount) ? str_replace(',', '.', str_replace('.', '', $this->AdvanceAmount)) : 0);
        }
        unset($this->Dados['new_file'], $this->Dados['file_name'], $this->Dados['number_nf'], $this->Dados['agency'], $this->Dados['checking_account'], $this->Dados['adms_type_key_pix_id'], $this->Dados['key_pix'], $this->Dados['bank_id'], $this->Dados['advance_amount'], $this->Dados['obs']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->valOrder();
        } else {
            $this->Resultado = false;
        }
    }

    private function valOrder() {
        if (empty($this->File['name'])) {
            $this->updateEditOrderPayment();
        } else {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['file_name'] = $slugImg->nomeSlug($this->File['name']);

            $upload = new \App\adms\Models\helper\AdmsUpload();
            $upload->upload($this->File, 'assets/files/orderPayments/' . $this->Dados['id'] . '/', $this->Dados['file_name']);
            if ($upload->getResultado()) {
                $this->updateEditOrderPayment();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function updateEditOrderPayment() {
        $this->Dados['number_nf'] = !empty($this->NumberNf) ? $this->NumberNf : null ;
        $this->Dados['bank_id'] = !empty($this->Bank) ? $this->Bank : null;
        $this->Dados['agency'] = !empty($this->Agency) ? $this->Agency : null;
        $this->Dados['checking_account'] = !empty($this->Checking) ? $this->Checking : null;
        $this->Dados['advance_amount'] = !empty($this->AdvanceAmount) ? $this->AdvanceAmount : null;
        $this->Dados['adms_type_key_pix_id'] = !empty($this->TypeKey) ? $this->TypeKey : null;
        $this->Dados['key_pix'] = !empty($this->KeyPix) ? $this->KeyPix : null;
        $this->Dados['obs'] = $this->obs;

        if (!empty($this->File['name'])) {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['file_name'] = $slugImg->nomeSlug($this->File['name']);
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAltOrder = new \App\adms\Models\helper\AdmsUpdate();
        $upAltOrder->exeUpdate("adms_order_payments", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltOrder->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento</strong> atualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A ordem de pagamento não foi atualizada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id a_id, name area FROM adms_areas ORDER BY name ASC");
        $registro['area'] = $listar->getResultado();

        $listar->fullRead("SELECT id cc_id, name costCenter FROM adms_cost_centers ORDER BY name ASC");
        $registro['costCenter'] = $listar->getResultado();

        $listar->fullRead("SELECT id b_id, brand FROM adms_brands_suppliers WHERE status_id =:status_id ORDER BY brand ASC", 'status_id=1');
        $registro['brand'] = $listar->getResultado();

        $listar->fullRead("SELECT id s_id, fantasy_name supplier, cnpj_cpf FROM adms_suppliers WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        $registro['supp'] = $listar->getResultado();

        $listar->fullRead("SELECT id t_id, name typePayment FROM adms_type_payments ORDER BY name ASC");
        $registro['typePayment'] = $listar->getResultado();

        $listar->fullRead("SELECT id ba_id, bank_name FROM adms_banks WHERE status_id =:status_id ORDER BY bank_name ASC", "status_id=1");
        $registro['bank'] = $listar->getResultado();

        $listar->fullRead("SELECT id ma_id, name manager FROM adms_managers WHERE status_id =:status_id ORDER BY name ASC", "status_id=1");
        $registro['manager'] = $listar->getResultado();

        $listar->fullRead("SELECT id tp_id, name typePix FROM adms_type_key_pixs WHERE status_id =:status_id ORDER BY name ASC", "status_id=1");
        $registro['typeKey'] = $listar->getResultado();

        $listar->fullRead("SELECT id st_id, exibition_name sit FROM adms_sits_order_payments WHERE status_id =:status_id ORDER BY exibition_name ASC", "status_id=1");
        $registro['sits'] = $listar->getResultado();

        $this->Resultado = ['area' => $registro['area'], 'costCenter' => $registro['costCenter'], 'brand' => $registro['brand'], 'supp' => $registro['supp'], 'typePayment' => $registro['typePayment'], 'bank' => $registro['bank'], 'manager' => $registro['manager'], 'typeKey' => $registro['typeKey'], 'sits' => $registro['sits']];

        return $this->Resultado;
    }
}
