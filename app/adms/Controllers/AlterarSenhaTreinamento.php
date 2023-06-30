<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AlterarSenhaTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AlterarSenhaTreinamento {

    private $Dados;

    public function altSenha() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['AltSenha'])) {
            unset($this->Dados['AltSenha']);
            $altSenhaBd = new \App\adms\Models\AdmsAlterarSenhaTreinamento();
            $altSenhaBd->altSenha($this->Dados);
            if ($altSenhaBd->getResultado()) {
                $UrlDestino = URLADM . 'ver-perfil-treinamento/perfil';
                header("Location: $UrlDestino");
            } else {
                $listarMenu = new \App\adms\Models\AdmsMenu();
                $this->Dados['menu'] = $listarMenu->itemMenu();
                $carregarView = new \Core\ConfigView("adms/Views/usuarioTreinamento/alterarSenha", $this->Dados);
                $carregarView->renderizar();
            }
        } else {
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/usuarioTreinamento/alterarSenha", $this->Dados);
            $carregarView->renderizar();
        }
    }

}
