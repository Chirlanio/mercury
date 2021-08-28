<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarBairro
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarBairro {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verBairro($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verBairro = new \App\adms\Models\helper\AdmsRead();
        $verBairro->fullRead("SELECT b.id id_bai, b.nome bairro, b.rota_id r_id, r.nome rota 
                FROM tb_bairros b
                INNER JOIN tb_rotas r ON r.id=b.rota_id
                WHERE b.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verBairro->getResultado();
        return $this->Resultado;
    }

    public function altBairro(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditBairro();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditBairro() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltBairro = new \App\adms\Models\helper\AdmsUpdate();
        $upAltBairro->exeUpdate("tb_bairros", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltBairro->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Bairro atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O bairro não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id r_id, nome rota FROM tb_rotas ORDER BY id ASC");
        $registro['rota_id'] = $listar->getResultado();

        $this->Resultado = ['rota_id' => $registro['rota_id']];

        return $this->Resultado;
    }

}
