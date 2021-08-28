<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AlterarSenha
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AlterarSenha
{

    private $Dados;

    public function altSenha()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['AltSenha'])) {
            unset($this->Dados['AltSenha']);
            $altSenhaBd = new \App\adms\Models\AdmsAlterarSenha();
            $altSenhaBd->altSenha($this->Dados);
            if ($altSenhaBd->getResultado()) {
                $UrlDestino = URLADM . 'ver-perfil/perfil';
                header("Location: $UrlDestino");                
            } else {
                $listarMenu = new \App\adms\Models\AdmsMenu();
                $this->Dados['menu'] = $listarMenu->itemMenu();
                $carregarView = new \Core\ConfigView("adms/Views/usuario/alterarSenha", $this->Dados);
                $carregarView->renderizar();
            }
        } else {
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/usuario/alterarSenha", $this->Dados);
            $carregarView->renderizar();
        }
    }

}
