<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerDelivery
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerDelivery {

    private $Dados;
    private $DadosId;

    public function verDelivery($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            
            $verPed = new \App\adms\Models\AdmsVerDelivery();
            $this->Dados['dados_ped'] = $verPed->verDelivery($this->DadosId);

            $botao = ['list_ped' => ['menu_controller' => 'delivery', 'menu_metodo' => 'listar'],
                'edit_ped' => ['menu_controller' => 'editar-ped', 'menu_metodo' => 'edit-ped'],
                'del_ped' => ['menu_controller' => 'apagar-ped', 'menu_metodo' => 'apagar-ped']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/delivery/verDelivery", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Pedido não encontrado!</div>";
            $UrlDestino = URLADM . 'delivery/listar';
            header("Location: $UrlDestino");
        }
    }

}
