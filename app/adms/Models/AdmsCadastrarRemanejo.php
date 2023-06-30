<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsCadastrarRemanejo {

    private $Resultado;
    private $Dados;
    private $File;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadRemanejo(array $Dados) {
        $this->Dados = $Dados;
        var_dump($this->Dados);
        $this->File = $this->Dados['arquivo'];
        unset($this->Dados['arquivo']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirUsuario();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirUsuario() {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['arquivo'] = $slugImg->nomeSlug($this->File['name']);

        $cadUsuario = new \App\adms\Models\helper\AdmsCreate;
        $cadUsuario->exeCreate("adms_remanejos", $this->Dados);
        if ($cadUsuario->getResultado()) {
            if (empty($this->File['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Remanejo cadastrado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $this->Dados['id'] = $cadUsuario->getResultado();
                $this->valFile();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O remanejo não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    private function valFile() {
        $uploadArq = new \App\adms\Models\helper\AdmsUpload();
        $uploadArq->upload($this->File, 'assets/files/remanejo/' . $this->Dados['id'] . '/', $this->Dados['arquivo']);
        if ($uploadArq->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Remanejo cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O remanejo não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id mar_id, nome marca FROM adms_marcas ORDER BY nome ASC");
        $registro['mar_id'] = $listar->getResultado();

        if ($_SESSION['ordem_nivac'] <= 5) {
            $listar->fullRead("SELECT id lj_ori_id, nome loja_origem FROM tb_lojas ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id lj_ori_id, nome loja_origem FROM tb_lojas WHERE id =:id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja']);
        }
        $registro['loja_ori'] = $listar->getResultado();

        if ($_SESSION['ordem_nivac'] == 7) {
            $listar->fullRead("SELECT id lj_des_id, nome loja_destino FROM tb_lojas WHERE status_id <>:status_id AND id <>:id ORDER BY id ASC", "status_id=2&id=" . $_SESSION['usuario_loja']);
        } else {
            $listar->fullRead("SELECT id lj_des_id, nome loja_destino FROM tb_lojas WHERE status_id <>:status_id ORDER BY id ASC", "status_id=2");
        }
        $registro['loja_des'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id id_tip, nome tipo FROM adms_tps_remanejos");
        $registro['tip_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id prdd_id, nome prioridade FROM adms_prioridades ORDER BY nome ASC");
        $registro['prdd_id'] = $listar->getResultado();

        $this->Resultado = ['mar_id' => $registro['mar_id'], 'loja_ori' => $registro['loja_ori'], 'loja_des' => $registro['loja_des'],
            'tip_id' => $registro['tip_id'], 'prdd_id' => $registro['prdd_id']];

        return $this->Resultado;
    }

}
