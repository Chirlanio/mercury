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
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function pesqUsuario($PageId = null, $Dados = null) {
        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;
        //var_dump($this->Dados);

        $this->Dados['nome'] = trim($this->Dados['nome']);
        $this->Dados['email'] = trim($this->Dados['email']);

        $_SESSION['pesqUsuarioNome'] = $this->Dados['nome'];
        $_SESSION['pesqUsuarioEmail'] = $this->Dados['email'];

        if (!empty($this->Dados['nome']) AND!empty($this->Dados['email'])) {
            $this->pesqUsuarioComp();
        } elseif (!empty($this->Dados['nome'])) {
            $this->pesqUsuarioNome();
        } elseif (!empty($this->Dados['email'])) {
            $this->pesqUsuarioEmail();
        }
        return $this->Resultado;
    }

    private function pesqUsuarioComp() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-usuarios/listar', '?nome=' . $this->Dados['nome'] . '&mail=' . $this->Dados['email']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(user.id) AS num_result FROM adms_usuarios user INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id WHERE nivac.ordem >=:ordem AND user.nome LIKE '%' :nome '%' AND user.email LIKE '%' :email '%' ", "ordem=" . $_SESSION['ordem_nivac'] . "&nome={$this->Dados['nome']}&email={$this->Dados['email']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT user.id, user.nome, user.email, sit.nome nome_sit, cr.cor cor_cr FROM adms_usuarios user INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id WHERE nivac.ordem >=:ordem AND (user.nome LIKE '%' :nome '%' AND user.email LIKE '%' :email '%') ORDER BY id ASC LIMIT :limit OFFSET :offset", "ordem=" . $_SESSION['ordem_nivac'] . "&nome={$this->Dados['nome']}&email={$this->Dados['email']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarUsuario->getResult();
        return $this->Resultado;
    }

    private function pesqUsuarioNome() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-usuarios/listar', '?nome=' . $this->Dados['nome']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(user.id) AS num_result FROM adms_usuarios user INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id WHERE nivac.ordem >=:ordem AND user.nome LIKE '%' :nome '%' ", "ordem=" . $_SESSION['ordem_nivac'] . "&nome={$this->Dados['nome']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT user.id, user.nome, user.email, sit.nome nome_sit, cr.cor cor_cr FROM adms_usuarios user INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id WHERE nivac.ordem >=:ordem AND user.nome LIKE '%' :nome '%' ORDER BY id ASC LIMIT :limit OFFSET :offset", "ordem=" . $_SESSION['ordem_nivac'] . "&nome={$this->Dados['nome']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarUsuario->getResult();
        return $this->Resultado;
    }

    private function pesqUsuarioEmail() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-usuarios/listar', '?email=' . $this->Dados['email']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(user.id) AS num_result FROM adms_usuarios user INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id WHERE nivac.ordem >=:ordem AND user.email LIKE '%' :email '%' ", "ordem=" . $_SESSION['ordem_nivac'] . "&email={$this->Dados['email']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT user.id, user.nome, user.email, sit.nome nome_sit, cr.cor cor_cr FROM adms_usuarios user INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id WHERE nivac.ordem >=:ordem AND user.email LIKE '%' :email '%' ORDER BY id ASC LIMIT :limit OFFSET :offset", "ordem=" . $_SESSION['ordem_nivac'] . "&email={$this->Dados['email']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarUsuario->getResultado();
        return $this->Resultado;
    }

}
