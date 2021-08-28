<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarDashboard
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsEditarDashboard {

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado() {
        return $this->Resultado;
    }

    public function verDashboard($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verAjuste = new \App\adms\Models\helper\AdmsRead();
        $verAjuste->fullRead("SELECT d.id, d.nome, d.descricao, d.area_id, d.loja_id, d.link, d.status_id,
                sit.id sit_id, sit.nome nome_sit,
                a.nome area
                FROM tb_dashboards d
                INNER JOIN tb_lojas lj ON lj.id=d.loja_id
                INNER JOIN adms_sits_pgs sit ON sit.id=d.status_id
                INNER JOIN tb_areas a ON a.id=d.area_id
                WHERE d.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verAjuste->getResultado();
        return $this->Resultado;
    }

    public function altDashboard(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditDashboard();
            //var_dump($this->Dados);
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditDashboard() {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltDash = new \App\adms\Models\helper\AdmsUpdate();
        $upAltDash->exeUpdate("tb_dashboards", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltDash->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Dashboard atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Dashboard não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_loja, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM adms_sits_pgs ORDER BY id ASC");
        $registro['sit_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id area_id, nome area FROM tb_areas ORDER BY id ASC");
        $registro['area_id'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit_id' => $registro['sit_id'], 'area_id' => $registro['area_id']];

        return $this->Resultado;
    }

}
