<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of DeleteProcessLibrary
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class DeleteProcessLibrary
{

    private $DadosId;

    public function processLibrary($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $delProcessLibraryFile = new \App\adms\Models\AdmsDelProcessLibrary();
            $delProcessLibraryFile->delProcessLibraryFile($this->DadosId);
            
            $delProcessLibrary = new \App\adms\Models\AdmsDelProcessLibrary();
            $delProcessLibrary->delProcessLibrary($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhuma política ou Processo encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'process-library/list';
        header("Location: $UrlDestino");
    }
}
