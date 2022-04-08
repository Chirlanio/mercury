<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerMarca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerMarca {

    private $Dados;
    private $DadosId;

    public function verMarca($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verMarca = new \App\adms\Models\AdmsVerMarca();
            $this->Dados['dados_marca'] = $verMarca->verMarca($this->DadosId);

            $botao = ['list_marca' => ['menu_controller' => 'marcas', 'menu_metodo' => 'listar'],
                'edit_marca' => ['menu_controller' => 'editar-marca', 'menu_metodo' => 'edit-marca'],
                'del_marca' => ['menu_controller' => 'apagar-marca', 'menu_metodo' => 'apagar-marca']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/marca/verMarca", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Nenhuma marca encontrada!</div>";
            $UrlDestino = URLADM . 'marcas/listar';
            header("Location: $UrlDestino");
        }
    }

}
