<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarPed
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarPed {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verPed($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verPed = new \App\adms\Models\helper\AdmsRead();
        $verPed->fullRead("SELECT p.*,
                t.id tam_id, t.nome tam, l.nome loja, f.nome func, tr.id sit_id, tr.nome sit
                FROM tb_prateleira_infinita p
                INNER JOIN tb_tam t ON t.id=p.tam_id
                INNER JOIN tb_lojas l ON l.id=p.loja_id
                INNER JOIN tb_funcionarios f ON f.id=p.func_id
                INNER JOIN tb_status_prat tr ON tr.id=p.status_id
                WHERE p.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verPed->getResultado();
        return $this->Resultado;
    }

    public function altPed(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditPed();
            //var_dump($this->Dados);
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditPed() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltDash = new \App\adms\Models\helper\AdmsUpdate();
        $upAltDash->exeUpdate("tb_prateleira_infinita", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltDash->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Pedido atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O pedido não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['adms_niveis_acesso_id'] != 5) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:loja_id ORDER BY id ASC", "loja_id=" . $_SESSION['usuario_loja']);
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status_prat ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();

        if ($_SESSION['adms_niveis_acesso_id'] != 5) {
            $listar->fullRead("SELECT id id_func, nome func FROM tb_funcionarios ORDER BY nome ASC");
        } else {
            $listar->fullRead("SELECT id id_func, nome func FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['func'] = $listar->getResultado();

        $listar->fullRead("SELECT id tam_id, nome tam FROM tb_tam ORDER BY nome ASC");
        $registro['tam'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit'], 'func' => $registro['func'], 'tam' => $registro['tam']];

        return $this->Resultado;
    }

}
