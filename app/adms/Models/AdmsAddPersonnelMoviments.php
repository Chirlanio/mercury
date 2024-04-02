<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAddPersonnelMoviments
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meioa Sola
 */
class AdmsAddPersonnelMoviments {

    private $Resultado;
    private $Dados;
    private $treatData;
    private $Filename;
    private $DadosEmail;
    private array $areas = [4, 6, 8, 10, 14];
    private array|null $DadosDismissal;
    private array|null $DadosUsuario;
    private string|null $Observation;

    function getResultado() {
        return $this->Resultado;
    }

    public function addMoviment(array $Dados) {

        $this->Dados = $Dados;
        $this->Filename = !empty($this->Dados['file_name']) ? $this->Dados['file_name'] : null;
        //$this->DadosDismissal['phone_chip'] = $this->Dados['phone_chip'];
        $this->Observation = $this->Dados['observation'];
        if (isset($this->Dados['phone_chip'])) {
            unset($this->Dados['phone_chip']);
        }
        if (isset($this->Dados['observation'])) {
            unset($this->Dados['observation']);
        }
        if (isset($this->Dados['file_name'])) {
            unset($this->Dados['file_name']);
        }

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->treatData($this->Dados);
        } else {
            $this->Resultado = false;
        }
    }

    private function treatData(array $Dados) {
        $this->treatData = $Dados;

        $this->treatData['adms_area_id'] = (isset($this->Dados['request_area_id']) and !empty($this->Dados['request_area_id'])) ? $this->Dados['request_area_id'] : 0;
        $this->treatData['fouls'] = (isset($this->Dados['totalFouls']) and !empty($this->Dados['totalFouls'])) ? $this->Dados['totalFouls'] : null;
        $this->treatData['days_off'] = (isset($this->Dados['totalDaysOff']) and !empty($this->Dados['totalDaysOff'])) ? $this->Dados['totalDaysOff'] : null;
        $this->treatData['folds'] = (isset($this->Dados['totalFolds']) and !empty($this->Dados['totalFolds']) and $this->Dados['totalFolds'] > 0) ? date("H:i:s", strtotime($this->Dados['totalFolds'])) : null;
        $this->treatData['fixed_fund'] = (isset($this->Dados['totalFund']) and !empty($this->Dados['totalFund'])) ? str_replace(",", ".", $this->Dados['totalFund']) : null;

        if (empty($this->treatData['fouls'])) {
            unset($this->treatData['fouls']);
        }
        if (empty($this->treatData['days_off'])) {
            unset($this->treatData['days_off']);
        }
        if (empty($this->treatData['folds'])) {
            unset($this->treatData['folds']);
        }
        if (empty($this->treatData['fixed_fund'])) {
            unset($this->treatData['fixed_fund']);
        }
        if (isset($this->treatData['totalFouls'])) {
            unset($this->treatData['totalFouls']);
        }
        if (isset($this->treatData['totalDaysOff'])) {
            unset($this->treatData['totalDaysOff']);
        }
        if (isset($this->treatData['totalFolds'])) {
            unset($this->treatData['totalFolds']);
        }
        if (isset($this->treatData['totalFund'])) {
            unset($this->treatData['totalFund']);
        }

        $this->insertMoviment();
    }

    private function insertMoviment() {

        $this->treatData['created'] = date("Y-m-d H:i:s");
        $this->treatData['observation'] = $this->Observation;
        $this->viewUser($this->Dados['adms_employee_id']);

        $addProcess = new \App\adms\Models\helper\AdmsCreate();
        $addProcess->exeCreate("adms_personnel_moviments", $this->treatData);

        if ($addProcess->getResult()) {
            $this->Dados['id'] = $addProcess->getResult();
            $this->viewManager();
            $this->valArquivo();
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Movimentação</strong> cadastrada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A Movimentação não foi cadastrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
        $this->InsertDismissalFollow();
    }

    private function valArquivo() {
        if (!isset($this->Filename['name'][0])) {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhum arquivo foi selecionado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
            return;
        }

        $uploadPath = 'assets/files/mp/' . $this->Dados['id'] . '/';
        $arquivosParaUpload = [];

        foreach ($this->Filename['name'] as $key => $filename) {
            $arquivosParaUpload[] = [
                'tmp_name' => $this->Filename['tmp_name'][$key],
                'name' => $filename,
                'type' => $this->Filename['type'][$key],
                'error' => $this->Filename['error'][$key],
                'size' => $this->Filename['size'][$key]
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

    private function viewManager() {

        foreach ($this->areas as $area) {
            $manager = new \App\adms\Models\helper\AdmsRead();
            $manager->fullRead("SELECT name, email FROM adms_managers WHERE id =:id LIMIT :limit", "id=" . $area . "&limit=1");
            $this->DadosUsuario = $manager->getResult();

            if ($this->DadosUsuario) {
                $this->treatDismissalFollow($this->Dados);
            }
        }
    }

    private function treatDismissalFollow(array $DadosDismissal) {
        $this->DadosDismissal = $DadosDismissal;

        $userDismissal = new \App\adms\Models\helper\AdmsRead();
        $userDismissal->fullRead("SELECT cargo_id  FROM tb_funcionarios WHERE id =:id LIMIT :limit", "id={$this->DadosDismissal['adms_employee_id']}&limit=1");
        $this->DadosDismissal['office_id'] = $userDismissal->getResult();
        unset($this->DadosDismissal['adms_loja_id'], $this->DadosDismissal['adms_employee_relation_id'], $this->DadosDismissal['adms_resignation_id'], $this->DadosDismissal['early_warning_id'], $this->DadosDismissal['request_area_id'], $this->DadosDismissal['requester_id'], $this->DadosDismissal['board_id'], $this->DadosDismissal['id'], $this->DadosDismissal['adms_employee_id'], $this->DadosDismissal['last_day_worked'], $this->DadosDismissal['fouls'], $this->DadosDismissal['totalFouls'], $this->DadosDismissal['days_off'], $this->DadosDismissal['totalDaysOff'], $this->DadosDismissal['folds'], $this->DadosDismissal['totalFolds'], $this->DadosDismissal['fixed_fund'], $this->DadosDismissal['totalFund'], $this->DadosDismissal['access_power_bi'], $this->DadosDismissal['access_zznet'], $this->DadosDismissal['access_cigam'], $this->DadosDismissal['access_camera'], $this->DadosDismissal['access_deskfy'], $this->DadosDismissal['notebook'], $this->DadosDismissal['email_corporate'], $this->DadosDismissal['access_meu_atendimento'], $this->DadosDismissal['office_parking_card'], $this->DadosDismissal['office_parking_shopping'], $this->DadosDismissal['key_office'], $this->DadosDismissal['key_store'], $this->DadosDismissal['instagram_corporate'], $this->DadosDismissal['deactivate_instagram_account'], $this->DadosDismissal['access_dito'], $this->DadosDismissal['signature_date_trct']);

        $this->DadosDismissal['adms_person_mov_id'] = $DadosDismissal['id'];
        $this->DadosDismissal['tb_funcionario_id'] = $DadosDismissal['adms_employee_id'];
        $this->DadosDismissal['office_id'] = $this->DadosDismissal['office_id'][0]['cargo_id'];
        $this->DadosDismissal['uniform'] = 1;
        $this->DadosDismissal['phone_chip'] = in_array($this->DadosUsuario[0]['cargo_id'], [1, 13]) ? 1 : 2;
        $this->DadosDismissal['original_card'] = $this->Dados['adms_resignation_id'] == 2 ? 1 : 2;
        $this->DadosDismissal['termination_date'] = $DadosDismissal['last_day_worked'];
        $this->DadosDismissal['signature_date_trct'] = date('Y-m-d', strtotime($this->Dados['last_day_worked'] . '+10 days'));
        $this->DadosDismissal['aso_resigns'] = $this->Dados['adms_employee_relation_id'] == 2 ? 2 : 1;
        $this->DadosDismissal['send_aso_guide'] = 2;
        $this->DadosDismissal['created'] = date("Y-m-d H:i:s");

        if (!empty($this->DadosDismissal['tb_funcionario_id'])) {
            $this->viewUser($this->DadosDismissal['tb_funcionario_id']);
        }
    }

    private function InsertDismissalFollow() {

        $userDF = new \App\adms\Models\helper\AdmsCreate();
        $userDF->exeCreate("adms_dismissal_follow_up", $this->DadosDismissal);
        $this->Resultado = $userDF->getResult();
    }

    private function viewUser(int|null $userId) {
        $this->DadosUsuario['userId'] = $userId;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT f.nome employee, l.nome store, f.cargo_id, cg.adms_niv_cargo_id FROM tb_funcionarios f LEFT JOIN tb_lojas l ON l.id = f.loja_id LEFT JOIN tb_cargos cg ON cg.id = f.cargo_id WHERE f.id =:id", "id={$this->DadosUsuario['userId']}");
        $this->DadosUsuario['nameUser'] = $viewUser->getResult();

        $this->sendEmail();

        return $this->Resultado = false;
    }

    private function sendEmail() {
        $nome = explode(" ", $this->DadosUsuario[0]['name']);
        $prim_nome = $nome[0];
        $this->DadosEmail['dest_nome'] = $prim_nome;
        $this->DadosEmail['dest_email'] = $this->DadosUsuario[0]['email'];
        $this->DadosEmail['titulo_email'] = "Movimentação de Pessoal";
        $this->DadosEmail['cont_email'] = "Olá " . $prim_nome . ",<br><br>";
        $this->DadosEmail['cont_email'] .= "Foi cadastrada uma nova movimentação de pessoal.<br>";
        $this->DadosEmail['cont_email'] .= "<p>Segue informações do cadastro.</p>";
        $this->DadosEmail['cont_email'] .= "<p>ID: {$this->Dados['id']}.<br>";
        $this->DadosEmail['cont_email'] .= "Loja: {$this->DadosUsuario['nameUser'][0]['store']}.<br>";
        $this->DadosEmail['cont_email'] .= "Consultora: {$this->DadosUsuario['nameUser'][0]['employee']}.<br>";
        $this->DadosEmail['cont_email'] .= "Data do Desligamento: " . date("d/m/Y", strtotime($this->Dados['last_day_worked'])) . ".</p>";
        $this->DadosEmail['cont_email'] .= "Para visualizar <a href='" . URLADM . "view-personnel-moviments/view-moviment/{$this->Dados['id']}'>clique aqui</a>.<br>";
        $this->DadosEmail['cont_email'] .= "Se e-mail enviado para recebimento de equipamentos e bloqueio de acessos.<br>";

        $this->DadosEmail['cont_text_email'] = "Olá " . $prim_nome . ",\n\n Foi cadastrada uma nova movimentação de pessoal.\n\n Segue informações sobre o cadastro.\n\n ID: " . $this->Dados['id'] . "\n Loja: " . $this->DadosUsuario['nameUser'][0]['store'] . "\n Consultora: " . $this->DadosUsuario['nameUser'][0]['employee'] . "\n Data do Desligamento: " . date("d/m/Y", strtotime($this->Dados['last_day_worked'])) . ".\n\n Para visualizar copie o link: " . URLADM . "view-order-payments/order-payment/{$this->Dados['id']}\n\n Se você não reconhece a solicitação entre em contado com o setor Financeiro.";

        $emailPHPMailer = new \App\adms\Models\helper\AdmsPhpMailer();
        $emailPHPMailer->emailPhpMailer($this->DadosEmail);

        if ($emailPHPMailer->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>E-mail enviado com sucesso, verifique sua caixa de entrada!</div>";
            $this->Resultado = true;
        } else {
            $this->Resultado = false;
        }
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id a_id, name area_name FROM adms_areas ORDER BY name ASC");
        $registro['areas'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] == STOREPERMITION) {
            $listar->fullRead("SELECT id s_id, nome store FROM tb_lojas WHERE id =:s_id AND status_id =:status_id ORDER BY id ASC", "s_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {
            $listar->fullRead("SELECT id s_id, nome store FROM tb_lojas WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        }
        $registro['name_stores'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] == STOREPERMITION) {
            $listar->fullRead("SELECT id f_id, nome colaborador FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {
            $listar->fullRead("SELECT id f_id, nome colaborador FROM tb_funcionarios WHERE status_id =:status_id ORDER BY nome ASC");
        }
        $registro['employee'] = $listar->getResult();

        $listar->fullRead("SELECT id m_id, name manager FROM adms_managers WHERE status_id =:status_id ORDER BY name ASC ", "status_id=1");
        $registro['manager'] = $listar->getResult();

        $listar->fullRead("SELECT f.id f_id, f.nome manager_sector FROM tb_funcionarios f LEFT JOIN tb_cargos c ON c.id = f.cargo_id LEFT JOIN adms_niv_cargos nv ON nv.id = c.adms_niv_cargo_id WHERE c.adms_niv_cargo_id =:adms_niv_cargo_id AND f.status_id =:status_id ORDER BY f.nome", "adms_niv_cargo_id=1&status_id=1");
        $registro['manager_sector'] = $listar->getResult();

        $this->Resultado = ['name_stores' => $registro['name_stores'], 'employee' => $registro['employee'], 'areas' => $registro['areas'], 'manager' => $registro['manager'], 'manager_sector' => $registro['manager_sector']];

        return $this->Resultado;
    }
}
