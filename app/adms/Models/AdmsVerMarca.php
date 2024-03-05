<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerMarca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerMarca {

    private $Resultado;
    private $DadosId;

    public function verMarca($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verMarca = new \App\adms\Models\helper\AdmsRead();
        $verMarca->fullRead("SELECT m.id, m.nome marca, m.created, m.modified, s.nome status FROM adms_marcas m INNER JOIN tb_status s ON s.id=m.status_id WHERE m.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verMarca->getResult();
        return $this->Resultado;
    }

}
