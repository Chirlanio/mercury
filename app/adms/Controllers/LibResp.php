<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of LibResp
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class LibResp {

    private $DadosId;
    private $Resp;
    private $PageId;

    public function libResp($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->Resp = filter_input(INPUT_GET, "resp", FILTER_SANITIZE_NUMBER_INT);
        $this->PageId = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
        if (!empty($this->DadosId) AND (!empty($this->Resp)) AND (!empty($this->PageId))) {
            $libResp = new \App\adms\Models\AdmsLibResp();
            $libResp->libResp($this->DadosId);
            $UrlDestino = URLADM . "autorizar/listar/{$this->PageId}?resp={$this->Resp}";
            header("Location: $UrlDestino");
        } else {
            $UrlDestino = URLADM . 'autorizacao-resp/listar';
            header("Location: $UrlDestino");
        }
    }

}
