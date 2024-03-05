<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerPerfilTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerPerfilTreinamento {

    private $Resultado;

    public function verPerfil() {
        $verPerfil = new \App\adms\Models\helper\AdmsRead();
        $verPerfil->fullRead("SELECT id, nome, usuario, email, cpf, image, adms_niveis_acesso_id, adms_sits_usuario_id, created, modified  FROM adms_users_treinamentos WHERE id =:id LIMIT :limit", "id=" . $_SESSION['usuario_id'] . "&limit=1");
        $this->Resultado = $verPerfil->getResult();
        return $this->Resultado;
    }

}
