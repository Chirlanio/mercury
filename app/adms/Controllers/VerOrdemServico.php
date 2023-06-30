<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerOrdemServico
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerOrdemServico {

    private $Dados;
    private $DadosId;

    public function verOrdemServico($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            
            $verOrderService = new \App\adms\Models\AdmsVerOrdemServico();
            $this->Dados['dados_ordem_servico'] = $verOrderService->verOrdemServico($this->DadosId);

            $botao = ['list_ordem_servico' => ['menu_controller' => 'ordem-servico', 'menu_metodo' => 'listar'],
                'edit_ordem_servico' => ['menu_controller' => 'editar-ordem-servico', 'menu_metodo' => 'edit-ordem-servico'],
                'del_ordem_servico' => ['menu_controller' => 'apagar-ordem-servico', 'menu_metodo' => 'apagar-ordem-servico']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/ordemServico/verOrdemServico", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
            $UrlDestino = URLADM . 'ordem-servico/listar';
            header("Location: $UrlDestino");
        }
    }

}
