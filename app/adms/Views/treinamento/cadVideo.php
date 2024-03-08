<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($valorForm);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Treinamento</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_video']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'escola-digital/listar-videos'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i></a>
                </div>
                <?php
            }
            ?>
        </div>
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Título</label>
                    <input name="titulo" id="titulo" class="form-control is-invalid" placeholder="Título do treinamento" value="<?php
                    if (isset($valorForm['titulo'])) {
                        echo $valorForm['titulo'];
                    }
                    ?>" required autofocus />
                        
                </div>

                <div class="form-group col-md-6">
                    <label>Subtitulo</label>
                    <input name="subtitulo" type="text" class="form-control is-invalid" placeholder="Subtitulo do treinamento" value="<?php
                    if (isset($valorForm['subtitulo'])) {
                        echo $valorForm['subtitulo'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Tema</label>
                    <input name="tema" type="text" id="tema" class="form-control is-invalid" placeholder="Tema do treinamento" value="<?php
                    if (isset($valorForm['tema'])) {
                        echo $valorForm['tema'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Facilitador</label>
                    <input name="facilitador" type="text" id="facilitador" class="form-control is-invalid" required value="<?php
                    if (isset($valorForm['facilitador'])) {
                        echo $valorForm['facilitador'];
                    }
                    ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Vídeo</label>
                    <input class="form-control-file is-invalid" name="nome_video" type="file" required />
                </div>
                
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Imagem</label>
                    <input class="form-control-file is-invalid" name="image_thumb" type="file" required />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Observações</label>
                    <textarea name="description" id="description" class="form-control editorCK" rows="3">
                        <?php
                        if(isset($valorForm['description'])){
                            echo $valorForm['description'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadVideo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>

