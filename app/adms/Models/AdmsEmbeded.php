<?php

namespace App\adms\Models;

If(!defined('URLADM')){
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEmbeded
 *
 * @author Chirlanio
 */
class AdmsEmbeded {
    
    private $Resultado;

    public function listarDash() {

        $dash = new \App\adms\Models\helper\AdmsRead();

        if (($_SESSION['adms_niveis_acesso_id'] == 5) OR ($_SESSION['adms_niveis_acesso_id'] == 6)) {
            $dash->fullRead("SELECT * FROM tb_dashboards WHERE status_id =:status_id AND loja_id =:loja_id LIMIT :limit", "status_id=1&loja_id=" . $_SESSION['usuario_loja']."&limit=1");
        } else {
            $dash->fullRead("SELECT * FROM tb_dashboards WHERE status_id =:status_id LIMIT :limit", "status_id=1&limit=1");
        }
        $this->Resultado = $dash->getResult();
        return $this->Resultado;
    }
}
