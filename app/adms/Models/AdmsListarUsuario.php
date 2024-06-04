<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarUsuario
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarUsuario {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarUsuario($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'usuarios/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(user.id) AS num_result FROM adms_usuarios user INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id WHERE nivac.ordem >=:ordem", "ordem=" . $_SESSION['ordem_nivac']);
        $this->ResultadoPg = $paginacao->getResultado();

        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT user.id, user.nome, user.email, sit.nome nome_sit, cr.cor cor_cr, a.name area FROM adms_usuarios user LEFT JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id LEFT JOIN adms_cors cr ON cr.id=sit.adms_cor_id LEFT JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id LEFT JOIN adms_areas a ON a.id = user.adms_area_id WHERE nivac.ordem >=:ordem ORDER BY user.id ASC LIMIT :limit OFFSET :offset", "ordem=" . $_SESSION['ordem_nivac'] . "&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarUsuario->getResult();
        return $this->Resultado;
    }

    public function usersOnline(int $PageId = null) {
        $this->PageId = $PageId;

        $pagination = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'users-online/list');
        $pagination->condicao($this->PageId, $this->LimiteResultado);
        $pagination->paginacao("SELECT COUNT(id) AS num_result FROM adms_users_online WHERE adms_sit_access_id =:user_online", "user_online=1");
        $this->ResultadoPg = $pagination->getResultado();

        $usersOnline = new \App\adms\Models\helper\AdmsRead();
        $usersOnline->fullRead("SELECT user.id, user.adms_user_id, user.adms_date_access, user.adms_hours_access, us.nome, us.email, lj.nome store, sa.name_sit, cr.cor cor_cr FROM adms_users_online user LEFT JOIN adms_usuarios us ON user.adms_user_id = us.id LEFT JOIN tb_lojas lj ON user.adms_store_id = lj.id LEFT JOIN adms_sit_access sa ON user.adms_sit_access_id = sa.id INNER JOIN adms_cors cr ON cr.id = sa.adms_cor_id WHERE user.adms_sit_access_id =:user_online ORDER BY user.adms_user_id ASC LIMIT :limit OFFSET :offset", "user_online=1&limit={$this->LimiteResultado}&offset={$pagination->getOffset()}");
        $this->Resultado = $usersOnline->getResult();
        return $this->Resultado;
    }
}
