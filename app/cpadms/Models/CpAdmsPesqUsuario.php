<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqUsuario
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CpAdmsPesqUsuario {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;
    private $PesqUsuario;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function pesqUsuario($PesqUsuario = null) {
        $this->PesqUsuario = (string) $PesqUsuario;
        $this->ResultadoPg = null;
        //var_dump($this->Dados);

        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT user.id, user.nome, user.email,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM adms_usuarios user 
                INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                WHERE nivac.ordem >=:ordem AND (user.nome LIKE '%' :nome '%' OR user.email LIKE '%' :nome '%')
                ORDER BY id ASC LIMIT :limit", "ordem=" . $_SESSION['ordem_nivac'] . "&nome={$this->PesqUsuario}&limit={$this->LimiteResultado}");
        $this->Resultado = $listarUsuario->getResultado();
        return $this->Resultado;
    }

}
