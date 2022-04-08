<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarOrdemServico
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meioa Sola
 */
class AdmsCadastrarOrdemServico {

    private $Resultado;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function cadOrdemServico(array $Dados) {

        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        $difDias = new \App\adms\Models\helper\AdmsDiferencaData;
        $difDias->validarDados($this->Dados);
        $this->Dados['data_dif_emissao_confir'] = $difDias->getResultado();

        if ($valCampoVazio->getResultado()) {
            $this->inserirOrdem();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirOrdem() {

        $this->Dados['created'] = date("Y-m-d H:i:s");

        $cadOrdem = new \App\adms\Models\helper\AdmsCreate;
        $cadOrdem->exeCreate("adms_qualidade_ordem_servico", $this->Dados);

        if ($cadOrdem->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Ordem de serviço cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A solicitação não foi cadastrada!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['adms_niveis_acesso_id'] <= 3 || $_SESSION['adms_niveis_acesso_id'] == 9) {
            $listar->fullRead("SELECT id l_id, nome loja FROM tb_lojas WHERE status_id =:status_id ORDER BY id_loja ASC", "status_id=1");
        } else {
            $listar->fullRead("SELECT id l_id, nome loja FROM tb_lojas WHERE id =:id AND status_id =:status_id ORDER BY id_loja ASC", "id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['loja'] = $listar->getResultado();

        $listar->fullRead("SELECT id tip_id, nome tipo FROM adms_tips_ordem_servico ORDER BY id ASC");
        $registro['tips'] = $listar->getResultado();

        $listar->fullRead("SELECT id tam_id, nome tam FROM tb_tam ORDER BY id ASC");
        $registro['tam'] = $listar->getResultado();

        $listar->fullRead("SELECT id m_id, nome marca FROM adms_marcas WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        $registro['marc'] = $listar->getResultado();

        $this->Resultado = ['loja' => $registro['loja'], 'tips' => $registro['tips'], 'tam' => $registro['tam'], 'marc' => $registro['marc']];

        return $this->Resultado;
    }

}
