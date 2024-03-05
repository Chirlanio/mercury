<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarEstorno
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meioa Sola
 */
class AdmsCadastrarEstorno {

    private $Resultado;
    private $Dados;
    private $File;
    private $Bandeira;
    private $Parcelas;
    private $NsuVazio;
    private $AuthVazio;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadEstorno(array $Dados) {

        $this->Dados = $Dados;

        $this->Bandeira = $this->Dados['adms_bandeira_id'];
        $this->Parcelas = $this->Dados['qtd_parcelas'];
        $this->NsuVazio = $this->Dados['nsu'];
        $this->AuthVazio = $this->Dados['auto_cartao'];
        $this->File = $this->Dados['arquivo'];
        unset($this->Dados['arquivo'], $this->Dados['auto_cartao'], $this->Dados['nsu'], $this->Dados['adms_bandeira_id'], $this->Dados['qtd_parcelas']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->verResponsavel();
            $this->inserirEstorno();
        } else {
            $this->Resultado = false;
        }
    }

    private function verResponsavel() {
        switch ($this->Dados['loja_id']):
            case 'Z421';
            case 'Z422';
            case 'Z423';
            case 'Z424';
            case 'Z425';
            case 'Z426';
            case 'Z427';
            case 'Z428';
            case 'Z434';
            case 'Z435';
            case 'Z436';
            case 'Z437';
                $this->Dados['adms_resp_aut_id'] = 2;
                break;
            case 'Z429';
            case 'Z430';
            case 'Z431';
            case 'Z432';
            case 'Z433';
            case 'Z438';
            case 'Z439';
            case 'Z440';
                $this->Dados['adms_resp_aut_id'] = 1;
                break;
            case 'Z441';
                $this->Dados['adms_resp_aut_id'] = 3;
                break;
            default :
                $this->Dados['adms_resp_aut_id'] = 4;
                break;
        endswitch;
    }

    private function inserirEstorno() {

        $this->Dados['nsu'] = $this->NsuVazio;
        $this->Dados['auto_cartao'] = $this->AuthVazio;
        $this->Dados['valor_lancado'] = str_replace('.', '', $this->Dados['valor_lancado']);
        $this->Dados['valor_lancado'] = str_replace(',', '.', $this->Dados['valor_lancado']);
        $this->Dados['valor_correto'] = str_replace('.', '', $this->Dados['valor_correto']);
        $this->Dados['valor_correto'] = str_replace(',', '.', $this->Dados['valor_correto']);
        $this->Dados['valor_estorno'] = str_replace('.', '', $this->Dados['valor_estorno']);
        $this->Dados['valor_estorno'] = str_replace(',', '.', $this->Dados['valor_estorno']);
        $this->Dados['cpf_cliente'] = str_replace(['.', '-'], '', $this->Dados['cpf_cliente']);
        $this->Dados['adms_bandeira_id'] = $this->Bandeira;
        $this->Dados['qtd_parcelas'] = $this->Parcelas;
        $this->Dados['created'] = date("Y-m-d H:i:s");

        $slugEst = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['arquivo'] = $slugEst->nomeSlug($this->File['name']);

        $cadEstorno = new \App\adms\Models\helper\AdmsCreate;
        $cadEstorno->exeCreate("adms_estornos", $this->Dados);
        
        if ($cadEstorno->getResult()) {
            if (empty($this->File['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Estorno cadastrado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $cadEstorno->getResult();
                $this->valArquivo();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A solicitação não foi cadastrada!</div>";
            $this->Resultado = false;
        }
    }

    private function valArquivo() {
        $uploadFile = new \App\adms\Models\helper\AdmsUpload();
        $uploadFile->upload($this->File, 'assets/files/estorno/' . $this->Dados['id'] . '/', $this->Dados['arquivo']);
        if ($uploadFile->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação cadastrada com sucesso. Upload do arquivo realizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-info'>Erro: Solicitação cadastrada. Erro ao realizar o upload do arquivo!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();
        
        $listar->fullRead("SELECT id m_id, nome motivo FROM adms_motivo_estorno ORDER BY nome ASC");
        $registro['id_mot'] = $listar->getResult();

        $listar->fullRead("SELECT id id_band, nome bandeira, icone FROM adms_bandeiras ORDER BY nome ASC");
        $registro['id_band'] = $listar->getResult();

        $listar->fullRead("SELECT id id_form, nome forma_pag FROM tb_forma_pag ORDER BY nome ASC");
        $registro['id_form'] = $listar->getResult();

        $listar->fullRead("SELECT id id_resp, nome resp_aut FROM adms_resp_autorizacao ORDER BY nome ASC");
        $registro['id_resp'] = $listar->getResult();

        $listar->fullRead("SELECT id id_sit, nome sit_est FROM adms_sits_estornos WHERE id <>:id ORDER BY id ASC", "id=3");
        $registro['id_sit'] = $listar->getResult();

        if ($_SESSION['adms_niveis_acesso_id'] <= 3 || $_SESSION['adms_niveis_acesso_id'] == 9) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE status_id =:status_id ORDER BY id_loja ASC", "status_id=1");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id AND status_id =:status_id ORDER BY id_loja ASC", "id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['loja_id'] = $listar->getResult();

        if ($_SESSION['adms_niveis_acesso_id'] <= 3) {
            $listar->fullRead("SELECT id id_func, nome func FROM tb_funcionarios WHERE status_id =:status_id ORDER BY nome ASC", "status_id=1");
        } else {
            $listar->fullRead("SELECT id id_func, nome func FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['id_func'] = $listar->getResult();

        $this->Resultado = ['id_band' => $registro['id_band'], 'id_form' => $registro['id_form'],
            'id_resp' => $registro['id_resp'], 'id_sit' => $registro['id_sit'],
            'id_mot' => $registro['id_mot'], 'loja_id' => $registro['loja_id'], 'id_func' => $registro['id_func']];

        return $this->Resultado;
    }

}
