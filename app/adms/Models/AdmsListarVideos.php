<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarArquivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarVideos {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 3;
    private $ResultadoPg;

    function getResultado() {
        return $this->ResultadoPg;
    }

    public function listarVideos($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'escola-digital/listar-videos');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_ed_videos WHERE status_id =:status_id", "status_id=1");
        $this->ResultadoPg = $paginacao->getResultado();

        $listar = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] >= 4) {
            $listar->fullRead("SELECT v.*, st.nome status
                    FROM adms_ed_videos v
                    INNER JOIN tb_status st ON st.id=v.status_id
                    WHERE v.status_id =:status_id
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", "status_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listar->fullRead("SELECT v.id, v.titulo, v.subtitulo, v.tema, v.facilitador, v.nome_video, v.image_thumb, v.description, v.status_id, v.modified
                    FROM adms_ed_videos v
                    ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listar->getResult();
        return $this->Resultado;
    }
}
