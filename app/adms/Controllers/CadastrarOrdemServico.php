<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarOdemServico
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class CadastrarOrdemServico {

    private $Dados;

    public function cadOrdemServico() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['CadOrdem'])) {
            unset($this->Dados['CadOrdem']);

            $this->Dados['image_one'] = ($_FILES['image_one'] ? $_FILES['image_one'] : null);
            $this->Dados['image_two'] = ($_FILES['image_two'] ? $_FILES['image_two'] : null);
            $this->Dados['image_three'] = ($_FILES['image_three'] ? $_FILES['image_three'] : null);
            $this->Dados['cupom_fiscal'] = ($_FILES['cupom_fiscal'] ? $_FILES['cupom_fiscal'] : null);

            $cadOrdemServico = new \App\adms\Models\AdmsCadastrarOrdemServico();
            $cadOrdemServico->cadOrdemServico($this->Dados);
            if ($cadOrdemServico->getResultado()) {
                $UrlDestino = URLADM . 'ordem-servico/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadOrdemServicoViewPriv();
            }
        } else {
            $this->cadOrdemServicoViewPriv();
        }
    }

    private function cadOrdemServicoViewPriv() {

        $listarSelect = new \App\adms\Models\AdmsCadastrarOrdemServico();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_ordem_servico' => ['menu_controller' => 'ordem-servico', 'menu_metodo' => 'listar'],
            'cad_ordem_servico' => ['menu_controller' => 'cadastrar-ordem-servico', 'menu_metodo' => 'cad-ordem-servico'],
            'ver_ordem_servico' => ['menu_controller' => 'ver-ordem-servico', 'menu_metodo' => 'ver-ordem-servico'],
            'editar_ordem_servico' => ['menu_controller' => 'editar-ordem-servico', 'menu_metodo' => 'edit-ordem-servico'],
            'del_ordem_servico' => ['menu_controller' => 'apagar-ordem-servico', 'menu_metodo' => 'apagar-ordem-servico']];

        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/ordemServico/cadOrdemServico", $this->Dados);
        $carregarView->renderizar();
    }

}
