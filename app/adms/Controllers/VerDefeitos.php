<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerDefeitos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerDefeitos {

    private $Dados;
    private $DadosId;

    public function verDefeitos($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verDefeitos = new \App\adms\Models\AdmsVerDefeitos();
            $this->Dados['dados_defeitos'] = $verDefeitos->verDefeitos($this->DadosId);

            $botao = ['list_defeitos' => ['menu_controller' => 'defeitos', 'menu_metodo' => 'listar'],
                'edit_defeitos' => ['menu_controller' => 'editar-defeitos', 'menu_metodo' => 'edit-defeitos'],
                'del_defeitos' => ['menu_controller' => 'apagar-defeitos', 'menu_metodo' => 'apagar-defeitos']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/defeitos/verDefeitos", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Defeito não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'defeitos/listar';
            header("Location: $UrlDestino");
        }
    }

}
