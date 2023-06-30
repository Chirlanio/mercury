<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqUsuarioTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CpAdmsPesqUsuarioTreinamento {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function pesqUsuario($PageId = null, $Dados = null) {
        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;
        //var_dump($this->Dados);

        $this->Dados['nome'] = trim($this->Dados['nome']);

        $_SESSION['pesqUsuarioNome'] = $this->Dados['nome'];

        if (!empty($this->Dados['nome'])) {
            $this->pesqUsuarioNome();
        }
        return $this->Resultado;
    }

    private function pesqUsuarioNome() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-usuarios-treinamento/listar', '?nome=' . $this->Dados['nome']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(user.id) AS num_result 
                FROM adms_users_treinamentos user
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                WHERE nivac.ordem >=:ordem AND user.nome LIKE '%' :nome '%' ", "ordem=" . $_SESSION['ordem_nivac'] . "&nome={$this->Dados['nome']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT user.id, user.nome, user.email, user.image,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM adms_users_treinamentos user 
                INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                WHERE nivac.ordem >=:ordem AND user.nome LIKE '%' :nome '%'
                ORDER BY id ASC LIMIT :limit OFFSET :offset", "ordem=" . $_SESSION['ordem_nivac'] . "&nome={$this->Dados['nome']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarUsuario->getResultado();
        return $this->Resultado;
    }

}
