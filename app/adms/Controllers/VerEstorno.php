<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerEstorno
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerEstorno {

    private $Dados;
    private $DadosId;

    public function verEstorno($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            
            $verEstorno = new \App\adms\Models\AdmsVerEstorno();
            $this->Dados['dados_estorno'] = $verEstorno->verEstorno($this->DadosId);

            $botao = ['list_estorno' => ['menu_controller' => 'estorno', 'menu_metodo' => 'listar'],
                'edit_estorno' => ['menu_controller' => 'editar-estorno', 'menu_metodo' => 'edit-estorno'],
                'del_estorno' => ['menu_controller' => 'apagar-estorno', 'menu_metodo' => 'apagar-estorno']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/estorno/verEstorno", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
            $UrlDestino = URLADM . 'estorno/listar';
            header("Location: $UrlDestino");
        }
    }

}
