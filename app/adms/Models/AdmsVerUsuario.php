<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerUsuario
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerUsuario {

    private $Resultado;
    private $DadosId;

    public function verUsuario($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verPerfil = new \App\adms\Models\helper\AdmsRead();
        $verPerfil->fullRead("SELECT user.*,
                nivac.nome nome_nivac,
                sit.nome nome_sit,
                cr.cor cor_cr,
                l.nome loja,
                a.name area,
                m.name manager
                FROM adms_usuarios user
                LEFT JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                LEFT JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id
                LEFT JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                LEFT JOIN tb_lojas l ON l.id=user.loja_id
                LEFT JOIN adms_areas a ON a.id = user.adms_area_id
                LEFT JOIN adms_managers m ON m.adms_area_id = user.adms_area_id
                WHERE user.id =:id AND nivac.ordem >=:ordem LIMIT :limit", "id=" . $this->DadosId . "&ordem=" . $_SESSION['ordem_nivac'] . "&limit=1");
        $this->Resultado = $verPerfil->getResultado();
        return $this->Resultado;
    }
}
