<?php

namespace App\adms\Models\helper;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCampoVazioComTag
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsCampoVazioComTag
{

    private $Dados;
    private $Resultado;
    
    function getResultado()
    {
        return $this->Resultado;
    }

    
    public function validarDados(array $Dados)
    {
        $this->Dados = $Dados;
        $this->Dados = array_map('trim', $this->Dados);
        if (in_array('', $this->Dados)) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário preencher todos os campos!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}
