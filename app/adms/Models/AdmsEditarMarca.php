<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarMarca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarMarca {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verMarca($DadosId) {

        $this->DadosId = (int) $DadosId;

        $verBairro = new \App\adms\Models\helper\AdmsRead();
        $verBairro->fullRead("SELECT m.id, m.nome, s.id status_id, s.nome status 
                FROM adms_marcas m
                INNER JOIN tb_status s ON s.id=m.status_id
                WHERE m.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verBairro->getResult();
        return $this->Resultado;
    }

    public function altMarca(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditMarca();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditMarca() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltMarca = new \App\adms\Models\helper\AdmsUpdate();
        $upAltMarca->exeUpdate("adms_marcas", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltMarca->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Marca atualizada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Marca não atualizada!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id status_id, nome status FROM tb_status ORDER BY id ASC");
        $registro['sit'] = $listar->getResult();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}
