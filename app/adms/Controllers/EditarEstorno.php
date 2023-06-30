<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarEstorno
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class EditarEstorno {

    private $Dados;
    private $DadosId;

    public function editEstorno($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editEstornoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação de estorno não encontrada!</div>";
            $UrlDestino = URLADM . 'estorno/listarEstorno';
            header("Location: $UrlDestino");
        }
    }

    private function editEstornoPriv() {
        if (!empty($this->Dados['EditEstorno'])) {
            unset($this->Dados['EditEstorno']);
            $this->Dados['file_novo'] = ($_FILES['file_novo'] ? $_FILES['file_novo'] : null);

            $editarEstorno = new \App\adms\Models\AdmsEditarEstorno();
            $editarEstorno->altEstorno($this->Dados);

            if ($editarEstorno->getResultado()) {
                $UrlDestino = URLADM . 'ver-estorno/ver-estorno/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editEstornoViewPriv();
            }
        } else {
            $verEstorno = new \App\adms\Models\AdmsEditarEstorno();
            $this->Dados['form'] = $verEstorno->verEstorno($this->DadosId);
            $this->editEstornoViewPriv();
        }
    }

    private function editEstornoViewPriv() {
        if ($this->Dados['form']) {

            $listarSelect = new \App\adms\Models\AdmsEditarEstorno();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_estorno' => ['menu_controller' => 'ver-estorno', 'menu_metodo' => 'ver-estorno'],
                'list_estorno' => ['menu_controller' => 'estorno', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/estorno/editarEstorno", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
            $UrlDestino = URLADM . 'estorno/listar';
            header("Location: $UrlDestino");
        }
    }

}
