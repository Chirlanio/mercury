<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarPerfilTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarPerfilTreinamento {

    private $Dados;

    public function altPerfil() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['EdiPerfil'])) {
            unset($this->Dados['EdiPerfil']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $altPerfilBd = new \App\adms\Models\AdmsEditarPerfilTreinamento();
            $altPerfilBd->altPerfil($this->Dados);
            if ($altPerfilBd->getResultado()) {
                $UrlDestino = URLADM . 'ver-perfil-treinamento/perfil';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->altPerfilPriv();
            }
        } else {
            $verPerfil = new \App\adms\Models\AdmsVerPerfilTreinamento();
            $this->Dados['form'] = $verPerfil->verPerfil();
            $this->altPerfilPriv();
        }
    }

    private function altPerfilPriv() {
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/usuarioTreinamento/editPerfil", $this->Dados);
        $carregarView->renderizar();
    }

}
