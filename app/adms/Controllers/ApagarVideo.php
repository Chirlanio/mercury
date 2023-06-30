<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarVideo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarVideo {

    private $DadosId;

    public function apagarVideo($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $apagarVideo = new \App\adms\Models\AdmsApagarVideo();
            $apagarVideo->apagarVideo($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Necessário selecionar um treinamento!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'escola-digital/listar-videos';
        header("Location: $UrlDestino");
    }

}
