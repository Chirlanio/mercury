<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerVideo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerVideo {

    private $Resultado;
    private $DadosId;

    /**
     * <b>Ver Estorno:</b> Receber o id da solicitação de estorno para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function verVideo($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verVideo = new \App\adms\Models\helper\AdmsRead();
        if($_SESSION['adms_niveis_acesso_id'] >= 4){
            $verVideo->fullRead("SELECT id, titulo, subtitulo, tema, facilitador, nome_video, image_thumb, description, status_id
                FROM adms_ed_videos
                WHERE id =:id AND status_id =:status_id LIMIT :limit", "id=" . $this->DadosId . "&status_id=1&limit=1");
        } else {
            $verVideo->fullRead("SELECT id, titulo, subtitulo, tema, facilitador, nome_video, image_thumb, description, status_id
                FROM adms_ed_videos
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        }
        $this->Resultado = $verVideo->getResultado();
        return $this->Resultado;
    }

}
