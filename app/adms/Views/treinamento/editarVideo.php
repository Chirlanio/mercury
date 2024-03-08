<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Vídeo</h2>
            </div>
            <span class="d-none d-md-block p-2">
                <?php
                if ($this->Dados['botao']['vis_video']) {
                    echo "<a href='" . URLADM . "escola-digital/listar-videos' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['vis_video']) {
                    echo "<a href='" . URLADM . "ver-video/ver-video/{$valorForm['id']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
                }
                ?>
            </span>
        </div>
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" class="was-validated" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Título</label>
                    <input name="titulo" type="text" class="form-control is-invalid" placeholder="Digite o título do treinamento" value="<?php
                    if (isset($valorForm['titulo'])) {
                        echo $valorForm['titulo'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Subtitulo</label>
                    <input name="subtitulo" type="text" class="form-control is-valid" placeholder="Subtitulo do treinamento" value="<?php
                    if (isset($valorForm['subtitulo'])) {
                        echo $valorForm['subtitulo'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Tema</label>
                    <input name="tema" type="text" class="form-control is-invalid" placeholder="Tema do treinamento" value="<?php
                    if (isset($valorForm['tema'])) {
                        echo $valorForm['tema'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Facilitador</label>
                    <input name="facilitador" type="text" class="form-control is-invalid" id="nome" placeholder="Facilitador" value="<?php
                    if (isset($valorForm['facilitador'])) {
                        echo $valorForm['facilitador'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="status_id" id="status_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit_id'] as $loja) {
                            extract($loja);
                            if ($valorForm['status_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$status</option>";
                            } else {
                                echo "<option value='$sit_id'>$status</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input name="video_antigo" type="hidden" value="<?php
                    if (isset($valorForm['video_antigo'])) {
                        echo $valorForm['video_antigo'];
                    } elseif (isset($valorForm['nome_video'])) {
                        echo $valorForm['nome_video'];
                    }
                    ?>">
                    <label><span class="text-danger">*</span> Vídeo</label>
                    <input class="form-control-file is-invalid" name="video_novo" type="file">
                </div>
                <div class="form-group col-md-6">
                    <?php
                    if (isset($valorForm['nome_video']) AND (!empty($valorForm['nome_video']))) {
                        $video_antigo = URLADM . 'assets/videos/treinamento/' . $valorForm['id'] . '/' . $valorForm['nome_video'];
                    } elseif (isset($valorForm['video_antigo']) AND (!empty($valorForm['video_antigo']))) {
                        $imagem_antiga = URLADM . 'assets/videos/treinamento/' . $valorForm['id'] . '/' . $valorForm['video_antigo'];
                    } else {
                        $imagem_antiga = URLADM . 'assets/videos/treinamento/' . $valorForm['id'] . '/' . $valorForm['nome_video'];
                    }
                    ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input name="imagem_antiga" type="hidden" value="<?php
                    if (isset($valorForm['imagem_antiga'])) {
                        echo $valorForm['imagem_antiga'];
                    } elseif (isset($valorForm['image_thumb'])) {
                        echo $valorForm['image_thumb'];
                    }
                    ?>">
                    <label><span class="text-danger">*</span> Foto</label>
                    <input class="form-control-file is-invalid" name="imagem_nova" type="file" onchange="previewImagem();">
                </div>
                <div class="form-group col-md-6">
                    <?php
                    if (isset($valorForm['image_thumb']) AND (!empty($valorForm['image_thumb']))) {
                        $imagem_antiga = URLADM . 'assets/imagens/treinamento/' . $valorForm['id'] . '/' . $valorForm['image_thumb'];
                    } elseif (isset($valorForm['imagem_antiga']) AND (!empty($valorForm['imagem_antiga']))) {
                        $imagem_antiga = URLADM . 'assets/imagens/treinamento/' . $valorForm['id'] . '/' . $valorForm['imagem_antiga'];
                    } else {
                        $imagem_antiga = URLADM . 'assets/imagens/treinamento/preview_img.png';
                    }
                    ?>
                    <img src="<?php echo $imagem_antiga; ?>" alt="Capa do treinamento" id="preview-user" class="img-thumbnail" style="width: 300px;">
                </div>
            </div>

            <div class="form-group">
                <label><span class="text-danger">*</span> Descrição</label>
                <textarea name="description" id="editorCk" class="form-control editorCK" rows="5"><?php
                    if (isset($valorForm['description'])) {
                        echo $valorForm['description'];
                    }
                    ?>
                </textarea>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditVideo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
