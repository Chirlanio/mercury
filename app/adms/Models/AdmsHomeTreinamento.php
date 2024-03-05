<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsHomeTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsHomeTreinamento {

    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function listar() {

        $contVideo = new \App\adms\Models\helper\AdmsRead();
        $contVideo->fullRead("SELECT COUNT(id) AS num_result FROM adms_ed_videos WHERE status_id =:status_id", "status_id=1");

        $this->Resultado = $contVideo->getResult();
        return $this->Resultado;
    }
    
    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if (($_SESSION['adms_niveis_acesso_id'] == 11) OR ($_SESSION['adms_niveis_acesso_id'] == 12)) {
            $listar->fullRead("SELECT COUNT(id) AS video FROM adms_ed_videos WHERE status_id =:status_id", "status_id=1");
        } else {
            $listar->fullRead("SELECT COUNT(id) AS video FROM adms_ed_videos");
        }
        $registro['vid'] = $listar->getResult();

        $listar->fullRead("SELECT COUNT(id) AS colab FROM adms_users_treinamentos WHERE adms_sits_usuario_id =:adms_sits_usuario_id", "adms_sits_usuario_id=1");
        $registro['col'] = $listar->getResult();

        $this->Resultado = ['vid' => $registro['vid'], 'col' => $registro['col']];

        return $this->Resultado;
    }

}
