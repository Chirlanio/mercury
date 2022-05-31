<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarBalancoProduto
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarBalancoProduto {

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
            $verAjuste->fullRead("SELECT aj.*, sit.id sit_id, sit.nome sit
                    FROM adms_balanco_produtos aj
                    INNER JOIN tb_status sit ON sit.id=aj.status_id
                    WHERE aj.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        } else {
            $verAjuste->fullRead("SELECT aj.*, sit.id sit_id, sit.nome sit
                    FROM adms_balanco_produtos aj
                    INNER JOIN tb_status sit ON sit.id=aj.status_id
                    WHERE aj.id =:id AND (aj.status_id =:status_id OR aj.status_id =:status_id2)
                    LIMIT :limit", "id=" . $this->DadosId . "&status_id=2&status_id2=5&limit=1");
        }
        $this->Resultado = $verAjuste->getResultado();
        return $this->Resultado;
    }

    public function altBalanco(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditBalancoProduto();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditBalancoProduto() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltBalanco = new \App\adms\Models\helper\AdmsUpdate();
        $upAltBalanco->exeUpdate("adms_balanco_produtos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltBalanco->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cadastro não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id b_id, loja_id, ciclo_id FROM adms_balancos ORDER BY id DESC");
        $registro['balanco'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status ORDER BY id ASC");
        $registro['sit_id'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] <= 2) {
            $listar->fullRead("SELECT id resp_loja_id, nome resp_loja FROM tb_funcionarios ORDER BY nome ASC");
        } else {
            $listar->fullRead("SELECT id resp_loja_id, nome resp_loja FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['func_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id r_id, nome resp_aud FROM adms_responsavel_auditoria WHERE status_id =:status_id ORDER BY nome ASC", "status_id=1");
        $registro['resp'] = $listar->getResultado();
        
        $listar->fullRead("SELECT id c_id, nome ciclo FROM adms_ciclos WHERE status_id <=:status_id ORDER BY id DESC", "status_id=4");
        $registro['ciclo'] = $listar->getResultado();

        $this->Resultado = ['balanco' => $registro['balanco'], 'sit_id' => $registro['sit_id'], 'func_id' => $registro['func_id'], 'resp' => $registro['resp'], 'ciclo' => $registro['ciclo']];

        return $this->Resultado;
    }

}
