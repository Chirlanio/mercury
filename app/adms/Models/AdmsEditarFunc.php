<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarFunc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarFunc {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verFunc($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verFunc = new \App\adms\Models\helper\AdmsRead();
        $verFunc->fullRead("SELECT f.id, f.nome, f.usuario, f.cpf, f.loja_id, f.cargo_id, f.status_id, s.id sit_id, s.nome sit, c.nome loja
                FROM tb_funcionarios f
                INNER JOIN tb_lojas lj ON lj.id=f.loja_id
                INNER JOIN tb_status s ON s.id=f.status_id
                INNER JOIN tb_cargos c ON c.id=f.cargo_id
                WHERE f.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verFunc->getResultado();
        return $this->Resultado;
    }

    public function altFunc(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditFunc();
            //var_dump($this->Dados);
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditFunc() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltFunc = new \App\adms\Models\helper\AdmsUpdate();
        $upAltFunc->exeUpdate("tb_funcionarios", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltFunc->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cadastro não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

    public function listarFunc() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_loja, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM tb_status ORDER BY id ASC");
        $registro['sit_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id cargo_id, nome cargo FROM tb_cargos ORDER BY nome ASC");
        $registro['cargo_id'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit_id' => $registro['sit_id'], 'cargo_id' => $registro['cargo_id']];

        return $this->Resultado;
    }

}
