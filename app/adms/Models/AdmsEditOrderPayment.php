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
    private $titular;
    private $launchNumber;
    private $installmentId;
    private $installments;
    private $typeAccount;
    private $documentNumberSupplier;

    function getResultado() {
        return $this->Resultado;
    }

    public function viewOrder($DadosId) {
        $this->DadosId = (int) $DadosId;
        $_SESSION['id'] = $this->DadosId;
        $viewOrder = new \App\adms\Models\helper\AdmsRead();
        $viewOrder->fullRead("SELECT op.* FROM adms_order_payments op WHERE op.id =:id LIMIT :limit", "id={$this->DadosId}&limit=1");
        $this->Resultado = $viewOrder->getResultado();
        return $this->Resultado;
    }

    public function altOrder(array $Dados) {
        $this->Dados = $Dados;

        $this->File = (!empty($this->Dados['new_files']['name'])) ? $this->Dados['new_files'] : $this->Dados['file_name'];
        $this->Bank = $this->Dados['bank_id'];
        $this->NumberNf = $this->Dados['number_nf'];
        $this->Agency = $this->Dados['agency'];
        $this->AdvanceAmount = $this->Dados['advance_amount'];
        $this->Checking = $this->Dados['checking_account'];
        $this->TypeKey = $this->Dados['adms_type_key_pix_id'];
        $this->KeyPix = $this->Dados['key_pix'];
        $this->titular = (!empty($this->Dados['name_supplier']) ? $this->Dados['name_supplier'] : null);
        $this->launchNumber = (!empty($this->Dados['launch_number']) ? $this->Dados['launch_number'] : null);
        $this->typeAccount = (!empty($this->Dados['type_account']) ? $this->Dados['type_account'] : null);
        $this->documentNumberSupplier = (!empty($this->Dados['document_number_supplier']) ? $this->Dados['document_number_supplier'] : null);
        $this->installmentId = (!empty($this->Dados['i_id']) ? $this->Dados['i_id'] : null);
        $this->installments['installment_values'] = !empty($this->Dados['installment_values']) ? $this->Dados['installment_values'] : null;
        $this->installments['date_payments'] = !empty($this->Dados['date_payments']) ? $this->Dados['date_payments'] : null;
        $this->installments['i_id'] = !empty($this->Dados['i_id']) ? $this->Dados['i_id'] : $_SESSION['id'];
        $this->obs = (!empty($this->Dados['obs']) ? $this->Dados['obs'] : null);

        $this->Dados['total_value'] = str_replace(',', '.', str_replace('.', '', $this->Dados['total_value']));
        if ((!empty($this->Dados['total_value'])) and (!empty($this->Dados['advance_amount']))) {
            $this->AdvanceAmount = (!empty($this->AdvanceAmount) ? str_replace(',', '.', str_replace('.', '', $this->AdvanceAmount)) : 0);
        }
        unset($this->Dados['document_number_supplier'], $this->Dados['type_account'], $this->Dados['id'], $this->Dados['delete'], $this->Dados['i_id'], $this->Dados['launch_number'], $this->Dados['name_supplier'], $this->Dados['new_files'], $this->Dados['file_name'], $this->Dados['number_nf'], $this->Dados['agency'], $this->Dados['checking_account'], $this->Dados['adms_type_key_pix_id'], $this->Dados['key_pix'], $this->Dados['bank_id'], $this->Dados['advance_amount'], $this->Dados['obs'], $this->Dados['installment_values'], $this->Dados['date_payments']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            if (!empty($this->File['name'][0])) {
                $this->valArquivo();
            } else {
                $this->updateEditOrderPayment();
            }
        } else {
            $this->Resultado = false;
        }
    }

    private function valArquivo() {
        if (!isset($this->File['name'][0])) {
            $this->updateEditOrderPayment();
        }

        $uploadPath = 'assets/files/orderPayments/' . $_SESSION['id'] . '/';
        $arquivosParaUpload = [];

        foreach ($this->File['name'] as $key => $filename) {
            $arquivosParaUpload[] = [
                'tmp_name' => $this->File['tmp_name'][$key],
                'name' => $filename,
                'type' => $this->File['type'][$key]
            ];
        }
        
        if (count($arquivosParaUpload) > 1) {
            $uploadFile = new \App\adms\Models\helper\AdmsUploadMultFiles();
            $uploadFile->upload($uploadPath, $arquivosParaUpload);
        } else {
            $newName = new \App\adms\Models\helper\AdmsSlug();
            $this->File['name'][0] = $newName->nomeSlug($this->File['name'][0]);

            $uploadFile = new \App\adms\Models\helper\AdmsUpload();
            $uploadFile->upload($arquivosParaUpload[0], $uploadPath, $this->File['name'][0]);
        }

        if ($uploadFile->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento:</strong> Solicitação atualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento:</strong> Solicitação atualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function updateEditOrderPayment() {
        $this->Dados['number_nf'] = !empty($this->NumberNf) ? $this->NumberNf : null;
        $this->Dados['bank_id'] = !empty($this->Bank) ? $this->Bank : null;
        $this->Dados['agency'] = !empty($this->Agency) ? $this->Agency : null;
        $this->Dados['checking_account'] = !empty($this->Checking) ? $this->Checking : null;
        $this->Dados['advance_amount'] = !empty($this->AdvanceAmount) ? $this->AdvanceAmount : null;
        $this->Dados['adms_type_key_pix_id'] = !empty($this->TypeKey) ? $this->TypeKey : null;
        $this->Dados['key_pix'] = !empty($this->KeyPix) ? $this->KeyPix : null;
        $this->Dados['obs'] = $this->obs;
        $this->Dados['name_supplier'] = $this->titular;
        $this->Dados['launch_number'] = $this->launchNumber;
        $this->Dados['installment_value'] = !empty($this->installments['installment_values'][0]) ? $this->installments['installment_values'][0] : null;
        $this->Dados['update_user_id'] = $_SESSION['usuario_id'];
        $this->Dados['type_account'] = $this->typeAccount;
        $this->Dados['document_number_supplier'] = $this->documentNumberSupplier;

        if (!empty($this->File['name'][0])) {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['file_name'] = $slugImg->nomeSlug($this->File['name'][0]);
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        //$this->updateInstallment();

        $upAltOrder = new \App\adms\Models\helper\AdmsUpdate();
        $upAltOrder->exeUpdate("adms_order_payments", $this->Dados, "WHERE id =:id", "id=" . $_SESSION['id']);
        if ($upAltOrder->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento</strong> atualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->updateInstallment();
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A ordem de pagamento não foi atualizada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function updateInstallment() {
        $installments = count($this->installments);
        $installId = $this->installments['i_id'];
        $datePayments = $this->installments['date_payments'];
        $installmentValues = $this->installments['installment_values'];

        $insertData = [];

        // Prepara os dados para inserção
        for ($i = 0; $i < $installments; $i++) {
            $insertData[] = [
                'id' => $installId[$i],
                'installment' => $installments,
                'date_payment' => $datePayments[$i],
                'installment_value' => str_replace(',', '.', str_replace('.', '', $installmentValues[$i])),
                'modified' => date("Y-m-d H:i:s")
            ];
        }

        // Insere os dados no banco de dados
        $upAltInstallment = new \App\adms\Models\helper\AdmsUpdate();

        foreach ($insertData as $data) {
            $upAltInstallment->exeUpdate("adms_installments", $data, "WHERE id =:id", "id=" . $data['id']);
            if ($upAltInstallment->getResultado()) {
                $this->Resultado = true;
            } else {
                $this->Resultado = false;
            }
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id a_id, name area FROM adms_areas ORDER BY name ASC");
        $registro['area'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] <= STOREPERMITION) {
            $listar->fullRead("SELECT id cc_id, cost_center_id, name costCenter FROM adms_cost_centers WHERE status_id =:status_id ORDER BY name ASC", "status_id=1");
        } else {//$_SESSION['area_id']
            $listar->fullRead("SELECT id cc_id, cost_center_id, name costCenter FROM adms_cost_centers WHERE adms_area_id =:adms_area_id AND status_id =:status_id ORDER BY name ASC", "adms_area_id=" . $_SESSION['area_id'] . "&status_id=1");
        }
        $registro['costCenter'] = $listar->getResultado();

        $listar->fullRead("SELECT id b_id, brand FROM adms_brands_suppliers WHERE status_id =:status_id ORDER BY brand ASC", 'status_id=1');
        $registro['brand'] = $listar->getResultado();

        $listar->fullRead("SELECT id s_id, fantasy_name supplier, cnpj_cpf FROM adms_suppliers WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        $registro['supp'] = $listar->getResultado();

        $listar->fullRead("SELECT id t_id, name typePayment FROM adms_type_payments ORDER BY name ASC");
        $registro['typePayment'] = $listar->getResultado();

        $listar->fullRead("SELECT id bank_id, bank_name FROM adms_banks WHERE status_id =:status_id ORDER BY bank_name ASC", "status_id=1");
        $registro['bank'] = $listar->getResultado();

        $listar->fullRead("SELECT id ma_id, name manager FROM adms_managers WHERE status_id =:status_id ORDER BY name ASC", "status_id=1");
        $registro['manager'] = $listar->getResultado();

        $listar->fullRead("SELECT id tp_id, name typePix FROM adms_type_key_pixs WHERE status_id =:status_id ORDER BY name ASC", "status_id=1");
        $registro['typeKey'] = $listar->getResultado();

        $listar->fullRead("SELECT id st_id, exibition_name sit FROM adms_sits_order_payments WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        $registro['sits'] = $listar->getResultado();

        $listar->fullRead("SELECT id i_id, adms_order_payment_id, installment qtdInstallments, installment_value installment_values, date_payment date_payments FROM adms_installments WHERE adms_order_payment_id =:adms_order_payment_id ORDER BY id ASC", "adms_order_payment_id=" . $_SESSION['id']);
        $registro['install'] = $listar->getResultado();

        $this->Resultado = ['area' => $registro['area'], 'costCenter' => $registro['costCenter'], 'brand' => $registro['brand'], 'supp' => $registro['supp'], 'typePayment' => $registro['typePayment'], 'bank' => $registro['bank'], 'manager' => $registro['manager'], 'typeKey' => $registro['typeKey'], 'sits' => $registro['sits'], 'install' => $registro['install']];

        return $this->Resultado;
    }
}
