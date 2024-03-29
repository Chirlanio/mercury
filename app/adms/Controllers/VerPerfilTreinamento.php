<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerPerfilTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerPerfilTreinamento {

    private $Dados;

    public function perfil() {
        $verPerfil = new \App\adms\Models\AdmsVerPerfilTreinamento();
        $this->Dados['dados_perfil'] = $verPerfil->verPerfil();

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/usuarioTreinamento/perfil", $this->Dados);
        $carregarView->renderizar();
    }

}
