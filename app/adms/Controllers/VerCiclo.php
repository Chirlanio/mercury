<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerCiclo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerCiclo {

    private $Dados;
    private $DadosId;

    public function verCiclo($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verCiclo = new \App\adms\Models\AdmsVerCiclo();
            $this->Dados['dados_ciclo'] = $verCiclo->verCiclo($this->DadosId);

            $botao = ['list_ciclo' => ['menu_controller' => 'ciclos', 'menu_metodo' => 'listar'],
                'edit_ciclo' => ['menu_controller' => 'editar-ciclo', 'menu_metodo' => 'edit-ciclo'],
                'del_ciclo' => ['menu_controller' => 'apagar-ciclo', 'menu_metodo' => 'apagar-ciclo']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/ciclo/verCiclo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'ciclos/listar';
            header("Location: $UrlDestino");
        }
    }

}
