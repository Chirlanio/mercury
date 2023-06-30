<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerFunc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerFunc {

    private $Dados;
    private $DadosId;

    public function verFunc($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verFunc = new \App\adms\Models\AdmsVerFunc();
            $this->Dados['dados_func'] = $verFunc->verFunc($this->DadosId);

            $botao = ['list_func' => ['menu_controller' => 'funcionarios', 'menu_metodo' => 'listar-func'],
                'edit_func' => ['menu_controller' => 'editar-func', 'menu_metodo' => 'edit-func'],
                'del_func' => ['menu_controller' => 'apagar-func', 'menu_metodo' => 'apagar-func']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/funcionarios/verFunc", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Funcionário não encontrado!</div>";
            $UrlDestino = URLADM . 'funcionarios/listarFunc';
            header("Location: $UrlDestino");
        }
    }

}
