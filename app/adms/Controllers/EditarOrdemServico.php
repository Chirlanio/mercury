<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarOrdemServico
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class EditarOrdemServico {

    private $Dados;
    private $DadosId;

    public function editOrdemServico($DadosId = null) {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->Dados['image_one'] = ($_FILES['image_one'] ? $_FILES['image_one'] : null);
        $this->Dados['image_two'] = ($_FILES['image_two'] ? $_FILES['image_two'] : null);
        $this->Dados['image_three'] = ($_FILES['image_three'] ? $_FILES['image_three'] : null);

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editOrdemServicoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Ordem de serviço não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'ordem-servico/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editOrdemServicoPriv() {
        if (!empty($this->Dados['EditOrdem'])) {
            unset($this->Dados['EditOrdem']);

            $editarOrdemServico = new \App\adms\Models\AdmsEditarOrdemServico();
            $editarOrdemServico->altOrdemServico($this->Dados);

            if ($editarOrdemServico->getResultado()) {
                $UrlDestino = URLADM . 'ver-ordem-servico/ver-ordem-servico/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editOrdemServicoViewPriv();
            }
        } else {
            $verOrdemServico = new \App\adms\Models\AdmsEditarOrdemServico();
            $this->Dados['form'] = $verOrdemServico->verOrdemServico($this->DadosId);
            $this->editOrdemServicoViewPriv();
        }
    }

    private function editOrdemServicoViewPriv() {
        if ($this->Dados['form']) {

            $listarSelect = new \App\adms\Models\AdmsEditarOrdemServico();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_ordem_servico' => ['menu_controller' => 'ver-ordem-servico', 'menu_metodo' => 'ver-ordem-servico'],
                'list_ordem_servico' => ['menu_controller' => 'ordem-servico', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/ordemServico/editarOrdemServico", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Ordem de serviço não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'ordem-servico/listar';
            header("Location: $UrlDestino");
        }
    }

}
