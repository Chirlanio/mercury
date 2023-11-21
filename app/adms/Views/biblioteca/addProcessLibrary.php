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
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Política/Processos</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_process']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'process-library/list'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
                </div>
                <?php
            }
            ?>

        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated"> 

            <h2 class="display-4 titulo">Conteúdo</h2>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Titulo</label>
                    <input name="title" type="text" class="form-control is-invalid" placeholder="Titulo do processo" value="<?php
                    if (isset($valorForm['title'])) {
                        echo $valorForm['title'];
                    }
                    ?>" required autofocus>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Descrição</label>
                    <textarea name="description" id="editor-um" class="form-control is-invalid editorCK" rows="3" required><?php
                        if (isset($valorForm['description'])) {
                            echo $valorForm['description'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Processo</label>
                    <textarea name="content_text" id="editor-dois" class="form-control editorCKQl" rows="3"><?php
                        if (isset($valorForm['content_text'])) {
                            echo $valorForm['content_text'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Resumo Publico</label>
                    <textarea name="public_summary" id="editor-tres" class="form-control editorDesUm" rows="3"><?php
                        if (isset($valorForm['public_summary'])) {
                            echo $valorForm['public_summary'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Categoria</label>
                    <select name="adms_cats_process_id" id="adms_cats_process_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['catart'] as $catPro) {
                            extract($catPro);
                            if (isset($valorForm['adms_cats_process_id']) AND $valorForm['adms_cats_process_id'] == $id_catart) {
                                echo "<option value='$id_catart' selected>$nome_catart</option>";
                            } else {
                                echo "<option value='$id_catart'>$nome_catart</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Área</label>
                    <select name="adms_cats_process_id" id="adms_cats_process_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['catart'] as $catPro) {
                            extract($catPro);
                            if (isset($valorForm['adms_cats_process_id']) AND $valorForm['adms_cats_process_id'] == $id_catart) {
                                echo "<option value='$id_catart' selected>$nome_catart</option>";
                            } else {
                                echo "<option value='$id_catart'>$nome_catart</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Setor</label>
                    <select name="adms_cats_process_id" id="adms_cats_process_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['catart'] as $catPro) {
                            extract($catPro);
                            if (isset($valorForm['adms_cats_process_id']) AND $valorForm['adms_cats_process_id'] == $id_catart) {
                                echo "<option value='$id_catart' selected>$nome_catart</option>";
                            } else {
                                echo "<option value='$id_catart'>$nome_catart</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="adms_sit_id" id="adms_sit_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if (isset($valorForm['adms_sit_id']) AND $valorForm['adms_sit_id'] == $id_sit) {
                                echo "<option value='$id_sit' selected>$nome_sit</option>";
                            } else {
                                echo "<option value='$id_sit'>$nome_sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Gestor da Área</label>
                    <select name="adms_manager_area_id" id="adms_manager_area_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['catart'] as $catPro) {
                            extract($catPro);
                            if (isset($valorForm['adms_manager_area_id']) AND $valorForm['adms_cats_process_id'] == $id_catart) {
                                echo "<option value='$id_catart' selected>$nome_catart</option>";
                            } else {
                                echo "<option value='$id_catart'>$nome_catart</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Gestor do Setor</label>
                    <select name="adms_manager_sector_id" id="adms_manager_sector_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['catart'] as $catPro) {
                            extract($catPro);
                            if (isset($valorForm['adms_manager_sector_id']) AND $valorForm['adms_cats_process_id'] == $id_catart) {
                                echo "<option value='$id_catart' selected>$nome_catart</option>";
                            } else {
                                echo "<option value='$id_catart'>$nome_catart</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Data Inicial</label>
                    <input name="date_validation_start" type="date" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['date_validation_start'])) {
                        echo $valorForm['date_validation_start'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Data Final</label>
                    <input name="date_validation_end" type="date" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['date_validation_end'])) {
                        echo $valorForm['date_validation_end'];
                    }
                    ?>" required="">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Arquivos</label>
                    <input class="form-control-file is-invalid" name="file_name_process[]" type="file" required>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadArtigo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
