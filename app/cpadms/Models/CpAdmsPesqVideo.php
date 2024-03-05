<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqVideo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CpAdmsPesqVideo {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarVideo($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['titulo'] = trim($this->Dados['titulo']);

        $_SESSION['pesqVideo'] = $this->Dados['titulo'];

        if (!empty($this->Dados['titulo'])) {
            $this->pesqVideo();
        }
        return $this->Resultado;
    }

    private function pesqVideo() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pesq-videos/listar', '?titulo=' . $this->Dados['titulo']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_ed_videos WHERE titulo LIKE '%' :titulo '%' OR subtitulo LIKE '%' :subtitulo '%'", "titulo={$this->Dados['titulo']}&subtitulo={$this->Dados['titulo']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarDelivery = new \App\adms\Models\helper\AdmsRead();
        $listarDelivery->fullRead("SELECT id, titulo, subtitulo, tema, facilitador, nome_video, image_thumb, description, status_id, created, modified FROM adms_ed_videos WHERE titulo LIKE '%' :titulo '%' OR subtitulo LIKE '%' :subtitulo '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "titulo={$this->Dados['titulo']}&subtitulo={$this->Dados['titulo']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarDelivery->getResult();
    }

}
