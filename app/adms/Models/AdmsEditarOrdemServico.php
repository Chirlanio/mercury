<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarOrdemServico
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AdmsEditarOrdemServico {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Obs;

    function getResultado() {
        return $this->Resultado;
    }

    public function verOrdemServico($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verOrdemServico = new \App\adms\Models\helper\AdmsRead();
        $verOrdemServico->fullRead("SELECT os.*, lj.nome loja,
                se.nome sit, tp.nome tipo, t.nome tam, m.nome marca, ljc.nome loja_conserto
                FROM adms_qualidade_ordem_servico os
                INNER JOIN tb_lojas lj ON lj.id=os.loja_id
                INNER JOIN tb_lojas ljc ON ljc.id=os.loja_id_conserto
                INNER JOIN adms_stis_ordem_servico se ON se.id=os.status_id
                INNER JOIN adms_tips_ordem_servico tp ON tp.id=os.tipo_ordem_id
                INNER JOIN tb_tam t ON t.id=os.tam_id
                INNER JOIN adms_marcas m ON m.id=os.marca_id
                WHERE os.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verOrdemServico->getResultado();
        return $this->Resultado;
    }

    public function altOrdemServico(array $Dados) {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditOrdemServico();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditOrdemServico() {

        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltEstorno = new \App\adms\Models\helper\AdmsUpdate();
        $upAltEstorno->exeUpdate("adms_qualidade_ordem_servico", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltEstorno->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação atualizada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A olicitação não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id l_id, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id']];

        return $this->Resultado;
    }

}
