<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarAjuste
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarAjuste {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verAjuste($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verAjuste = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] == 1) {
            $verAjuste->fullRead("SELECT aj.*, lj.id loja_id, lj.nome, tam.nome, fs.id func_id_sol, fs.nome consul_sol, f.id func_id, f.nome, sit.id sit_id, sit.nome sit, j.id just_id, j.nome just FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN tb_funcionarios fs ON fs.id=aj.solicitante INNER JOIN tb_funcionarios f ON f.id=aj.func_id INNER JOIN tb_status_aj sit ON sit.id=aj.status_aj_id INNER JOIN tb_justificativas j ON j.id=aj.justficativa_id WHERE aj.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        } else {
            $verAjuste->fullRead("SELECT aj.*, lj.id loja_id, lj.nome, tam.nome, fs.id func_id_sol, fs.nome consul_sol, f.id func_id, f.nome, sit.id sit_id, sit.nome sit, j.id just_id, j.nome just FROM tb_ajuste aj INNER JOIN tb_lojas lj ON lj.id=aj.loja_id INNER JOIN tb_tam tam ON tam.id=aj.tam_id INNER JOIN tb_funcionarios fs ON fs.id=aj.solicitante INNER JOIN tb_funcionarios f ON f.id=aj.func_id INNER JOIN tb_status_aj sit ON sit.id=aj.status_aj_id INNER JOIN tb_justificativas j ON j.id=aj.justficativa_id WHERE aj.id =:id AND (aj.status_aj_id =:status_aj_id OR aj.status_aj_id =:status_aj_id2) LIMIT :limit", "id=" . $this->DadosId . "&status_aj_id=2&status_aj_id2=5&limit=1");
        }
        $this->Resultado = $verAjuste->getResultado();
        return $this->Resultado;
    }

    public function altAjuste(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditAjuste();
            //var_dump($this->Dados);
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditAjuste() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltAjuste = new \App\adms\Models\helper\AdmsUpdate();
        $upAltAjuste->exeUpdate("tb_ajuste", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltAjuste->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A solicitação não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id_loja, id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_aj ORDER BY id ASC");
        $registro['sit_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_tam, nome tam FROM tb_tam ORDER BY id ASC");
        $registro['tam_id'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] <= 2) {
            $listar->fullRead("SELECT id func_id_sol, nome consul_sol FROM tb_funcionarios ORDER BY nome ASC");
        } else {
            $listar->fullRead("SELECT id func_id_sol, nome consul_sol FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['func_id_sol'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] <= 2) {
            $listar->fullRead("SELECT id func_id, nome consul FROM tb_funcionarios ORDER BY nome ASC");
        } else {
            $listar->fullRead("SELECT id func_id, nome consul FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['func_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id just_id, nome just FROM tb_justificativas ORDER BY nome ASC");
        $registro['just_id'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit_id' => $registro['sit_id'], 'tam_id' => $registro['tam_id'], 'func_id_sol' => $registro['func_id_sol'], 'func_id' => $registro['func_id'], 'just_id' => $registro['just_id']];

        return $this->Resultado;
    }

}
