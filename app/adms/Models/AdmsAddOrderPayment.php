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
    private $installmentValues;
    private $datePayments;
    private $titular;
    private $launchNumebr;
    private $DadosUsuario;
    private $typeAccount;
    private $documentNumberSupplier;

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
        $this->installmentValues = !empty($this->Dados['installment_values']) ? $this->Dados['installment_values'] : null;
        $this->datePayments = !empty($this->Dados['date_payments']) ? $this->Dados['date_payments'] : null;
        $this->titular = !empty($this->Dados['name_supplier']) ? $this->Dados['name_supplier'] : null;
        $this->launchNumebr = !empty($this->Dados['launch_numebr']) ? $this->Dados['launch_numebr'] : null;
        $this->typeAccount = !empty($this->Dados['type_account']) ? $this->Dados['type_account'] : null;
        $this->documentNumberSupplier = !empty($this->Dados['document_number_supplier']) ? $this->Dados['document_number_supplier'] : null;
        unset($this->Dados['document_number_supplier'], $this->Dados['type_account'], $this->Dados['launch_number'], $this->Dados['name_supplier'], $this->Dados['agency'], $this->Dados['checking_account'], $this->Dados['bank_id'], $this->Dados['adms_type_key_pix_id'], $this->Dados['key_pix'], $this->Dados['advance_amount'], $this->Dados['number_nf'], $this->Dados['file_name'], $this->Dados['obs'], $this->Dados['installment_values'], $this->Dados['date_payments']);

        //var_dump($this->Dados);
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
        $this->Dados['adms_user_id'] = $_SESSION['usuario_id'];
        $this->Dados['name_supplier'] = $this->titular;
        $this->Dados['launch_number'] = $this->launchNumebr;
        $this->Dados['type_account'] = $this->typeAccount;
        $this->Dados['document_number_supplier'] = (!empty($this->documentNumberSupplier) ? str_replace('.', '', str_replace('-', '', $this->documentNumberSupplier)) : null);
        $this->Dados['created'] = date("Y-m-d H:i:s");

        if (!empty($this->Filename['name'][0])) {
            $slugFile = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['file_name'] = $slugFile->nomeSlug($this->Filename['name'][0]);
        }

        $addOrder = new \App\adms\Models\helper\AdmsCreate();
        $addOrder->exeCreate("adms_order_payments", $this->Dados);

        if ($addOrder->getResultado()) {
            if (empty($this->Filename['name'][0])) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento:</strong> Cadastrada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $addOrder->getResultado();
                $this->insertInstallment();
                $this->valArquivo();
                $this->viewManager();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A solicitação não foi cadastrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function valArquivo() {
        if (!isset($this->Filename['name'][0])) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhum arquivo foi selecionado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
            return;
        }

        $uploadPath = 'assets/files/orderPayments/' . $this->Dados['id'] . '/';
        $arquivosParaUpload = [];

        foreach ($this->Filename['name'] as $key => $filename) {
            $arquivosParaUpload[] = [
                'tmp_name' => $this->Filename['tmp_name'][$key],
                'name' => $filename,
                'type' => $this->Filename['type'][$key]
            ];
        }

        if (count($arquivosParaUpload) > 1) {
            $uploadFile = new \App\adms\Models\helper\AdmsUploadMultFiles();
            $uploadFile->upload($uploadPath, $arquivosParaUpload);
        } else {
            $newName = new \App\adms\Models\helper\AdmsSlug();
            $this->Filename['name'][0] = $newName->nomeSlug($this->Filename['name'][0]);

            $uploadFile = new \App\adms\Models\helper\AdmsUpload();
            $uploadFile->upload($arquivosParaUpload[0], $uploadPath, $this->Filename['name'][0]);
        }

        if ($uploadFile->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento:</strong> Solicitação cadastrada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação cadastrada. Erro ao realizar o upload do arquivo!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function insertInstallment() {
        $installments = intval($this->Dados['installments']);
        $datePayments = $this->datePayments;
        $installmentValues = $this->installmentValues;

        $insertData = [];

        // Prepara os dados para inserção
        for ($i = 0; $i < $installments; $i++) {
            $insertData[] = [
                'adms_order_payment_id' => $this->Dados['id'],
                'installment' => $installments,
                'date_payment' => $datePayments[$i],
                'installment_value' => str_replace(',', '.', str_replace('.', '', $installmentValues[$i])),
                'created' => date("Y-m-d H:i:s")
            ];
        }

        // Insere os dados no banco de dados
        $installment = new \App\adms\Models\helper\AdmsCreate();

        foreach ($insertData as $data) {
            $installment->exeCreate('adms_installments', $data);
        }
    }

    private function viewManager() {

        $manager = new \App\adms\Models\helper\AdmsRead();
        $manager->fullRead("SELECT * FROM adms_managers WHERE id =:id LIMIT :limit", "id=" . $this->Dados['manager_id'] . "&limit=1");
        $this->DadosUsuario = $manager->getResultado();

        if ($this->DadosUsuario) {
            $this->sendEmail();
        }
    }

    private function sendEmail() {
        $nome = explode(" ", $this->DadosUsuario[0]['name']);
        $prim_nome = $nome[0];
        $this->DadosEmail['dest_nome'] = $prim_nome;
        $this->DadosEmail['dest_email'] = $this->DadosUsuario[0]['email'];
        $this->DadosEmail['titulo_email'] = "Ordem de Pagaqmento";
        $this->DadosEmail['cont_email'] = "Ola " . $prim_nome . "<br><br>";
        $this->DadosEmail['cont_email'] .= "Foi cadastrada uma nova ordem de pagamento.<br>";
        $this->DadosEmail['cont_email'] .= "<p>Segue informacoes sobre o cadastro.</p>";
        $this->DadosEmail['cont_email'] .= "<p>ID: " . $this->Dados['id'] . ".<br>";
        $this->DadosEmail['cont_email'] .= "Valor: " . number_format($this->Dados['total_value'], 2, ',', '.') . ".<br>";
        $this->DadosEmail['cont_email'] .= "Data Pagamento: " . date("d/m/Y", strtotime($this->Dados['date_payment'])) . ".</p>";
        $this->DadosEmail['cont_email'] .= "Se voce nao reconhece a solicitacao entre em contado com o setor Financeiro.<br>";

        $this->DadosEmail['cont_text_email'] = "Ola " . $prim_nome . " Foi cadastrada uma nova ordem de pagamento. Segue informacoes sobre o cadastro. ID: " . $this->Dados['id'] . " Valor: " . number_format($this->Dados['total_value'], 2, ',', '.') . " Data Pagamento: " . date("d/m/Y", strtotime($this->Dados['date_payment'])) . ". Se você não reconhece a solicitação entre em contado com o setor Financeiro.";

        $emailPHPMailer = new \App\adms\Models\helper\AdmsPhpMailer();
        $emailPHPMailer->emailPhpMailer($this->DadosEmail);

        if ($emailPHPMailer->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>E-mail enviado com sucesso, verifique sua caixa de entrada!</div>";
            $this->Resultado = true;
        } else {
            //$_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Erro ao recuperar a senha!</div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id a_id, name area FROM adms_areas WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        $registro['area'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
            $listar->fullRead("SELECT id c_id, cost_center_id, name costCenter FROM adms_cost_centers WHERE status_id =:status_id ORDER BY name ASC", "status_id=1");
        } else {
            $listar->fullRead("SELECT id c_id, name costCenter FROM adms_cost_centers WHERE adms_area_id =:adms_area_id AND status_id =:status_id ORDER BY name ASC", "adms_area_id=" . $_SESSION['area_id'] . "&status_id=1");
        }
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
