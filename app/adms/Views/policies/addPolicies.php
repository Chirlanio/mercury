<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
?>
<div class="content p-1">
    <div class="list-group-item">
        
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Política</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_policies']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'policies/list'; ?>" class="btn btn-outline-info btn-sm"><i class='fas fa-list d-block d-md-none fa-2x'></i> <span class='d-none d-md-block'><i class='fa-solid fa-list'></i></span></a>
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

            <h2 class="display-4 titulo">Conteúdo</h2>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Titulo</label>
                    <input name="title" type="text" class="form-control is-invalid" placeholder="Titulo da política" value="<?php
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
                    <label><span class="text-danger">*</span> Conteúdo da Política</label>
                    <textarea name="content" id="editor-dois" class="form-control editorObs" rows="3"><?php
                        if (isset($valorForm['content'])) {
                            echo $valorForm['content'];
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
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Foto (1200x627)</label>
                    <input class="form-control-file is-invalid" name="new_image" type="file" onchange="previewNewImage();" required>
                </div>
                <div class="form-group col-md-6">
                    <?php
                    $imagem_antiga = URLADM . 'assets/imagens/policies/preview_img.jpg';
                    ?>
                    <img src="<?php echo $imagem_antiga; ?>" alt="Imagem da política" id="preview-image" class="img-thumbnail" style="width: 300px; height: 150px;">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Arquivo</label>
                    <input class="form-control-file is-invalid" name="file_name" type="file" required />
                </div>
            </div>

            <hr>
            <h2 class="display-4 titulo">SEO</h2>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Slug</label>
                    <input name="slug" type="text" class="form-control is-invalid" placeholder="Nome que será exibido na barra de endereço URL" title="Não pode ser igual a outro artigo." value="<?php
                    if (isset($valorForm['slug'])) {
                        echo $valorForm['slug'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Palavra chave</label>
                    <input name="keywords" type="text" class="form-control is-invalid" placeholder="Palavra chave do artigo" title="Nome que será usado nas buscas do site" value="<?php
                    if (isset($valorForm['keywords'])) {
                        echo $valorForm['keywords'];
                    }
                    ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Data Inicial</label>
                    <input name="dataInicial" type="date" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['dataInicial'])) {
                        echo $valorForm['dataInicial'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Data Final</label>
                    <input name="dataFinal" type="date" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['dataFinal'])) {
                        echo $valorForm['dataFinal'];
                    }
                    ?>" required="">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Destaque</label>
                    <select name="destaque" id="lib_pub" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['destaque']) == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif (isset($valorForm['destaque']) == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="AddPolicies" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
