<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarBalanco {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verBalanco($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] == 1) {
            $verAjuste->fullRead("SELECT aj.*, lj.id loja_id, lj.nome, f.id resp_loja_id, f.nome, sit.id sit_id, sit.nome sit, r.nome resp FROM adms_balancos aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_funcionarios f ON f.id=aj.responsavel_loja_id INNER JOIN adms_responsavel_auditoria r ON r.id=aj.responsavel_auditoria_id INNER JOIN tb_status sit ON sit.id=aj.status_id WHERE aj.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        } else {
            $verAjuste->fullRead("SELECT aj.*, lj.id loja_id, lj.nome, f.id resp_loja_id, f.nome, sit.id sit_id, sit.nome sit, r.nome resp FROM adms_aud_balancos aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_funcionarios f ON f.id=aj.resp_loja_id INNER JOIN adms_responsavel_auditoria r ON r.id=aj.responsavel_auditoria_id INNER JOIN tb_status sit ON sit.id=aj.status_id WHERE aj.id =:id AND (aj.status_id =:status_id OR aj.status_id =:status_id2) LIMIT :limit", "id=" . $this->DadosId . "&status_id=2&status_id2=5&limit=1");
        }
        $this->Resultado = $verAjuste->getResult();
        return $this->Resultado;
    }

    public function altBalanco(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditBalanco();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditBalanco() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltBalanco = new \App\adms\Models\helper\AdmsUpdate();
        $upAltBalanco->exeUpdate("adms_balancos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltBalanco->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cadastro não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id_loja, id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResult();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status ORDER BY id ASC");
        $registro['sit_id'] = $listar->getResult();

        if ($_SESSION['adms_niveis_acesso_id'] <= 2) {
            $listar->fullRead("SELECT id resp_loja_id, nome resp_loja FROM tb_funcionarios ORDER BY nome ASC");
        } else {
            $listar->fullRead("SELECT id resp_loja_id, nome resp_loja FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['func_id'] = $listar->getResult();

        $listar->fullRead("SELECT id r_id, nome resp_aud FROM adms_responsavel_auditoria WHERE status_id =:status_id ORDER BY nome ASC", "status_id=1");
        $registro['resp'] = $listar->getResult();
        
        $listar->fullRead("SELECT id c_id, nome ciclo FROM adms_ciclos WHERE status_id <=:status_id ORDER BY id DESC", "status_id=4");
        $registro['ciclo'] = $listar->getResult();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit_id' => $registro['sit_id'], 'func_id' => $registro['func_id'], 'resp' => $registro['resp'], 'ciclo' => $registro['ciclo']];

        return $this->Resultado;
    }

}
