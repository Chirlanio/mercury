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
                <h2 class="display-4 titulo">Editar Política</h2>
            </div>
            <span class="d-none d-md-block">
                <?php
                if ($this->Dados['botao']['list_policies']) {
                    echo "<a href='" . URLADM . "policies/list' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['view_policies']) {
                    echo "<a href='" . URLADM . "view-policies/view-policie/{$valorForm['id']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
                }
                ?>
            </span>
            <div class="dropdown d-block d-md-none">
                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ações
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                    <?php
                    if ($this->Dados['botao']['list_policies']) {
                        echo "<a class='dropdown-item' href='" . URLADM . "policies/list'>Listar</a>";
                    }
                    if ($this->Dados['botao']['view_policies']) {
                        echo "<a class='dropdown-item' href='" . URLADM . "view-policies/view-policie/" . $valorForm['id'] . "'>Cadastrar</a>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <h2 class="display-4 titulo">Conteúdo</h2>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Titulo</label>
                    <input name="title" type="text" class="form-control" placeholder="Titulo da política" value="<?php
                    if (isset($valorForm['title'])) {
                        echo $valorForm['title'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Descrição</label>
                    <textarea name="description" class="form-control editorDesDois" id="editor"><?php
                        if (isset($valorForm['description'])) {
                            echo $valorForm['description'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Resumo Publico</label>
                    <textarea name="public_summary" id="editor-dois" class="form-control editorDesUm" rows="3"><?php
                        if (isset($valorForm['public_summary'])) {
                            echo $valorForm['public_summary'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Conteúdo da Política</label>
                    <textarea name="content" id="editor-tres" class="form-control editorCK" rows="3"><?php
                        if (isset($valorForm['content'])) {
                            echo $valorForm['content'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="adms_sit_id" id="adms_sit_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['adms_sit_id'] == $id_sit) {
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
                    <input name="old_image" type="hidden" value="<?php
                    if (isset($valorForm['old_image'])) {
                        echo $valorForm['old_image'];
                    } elseif (isset($valorForm['image'])) {
                        echo $valorForm['image'];
                    }
                    ?>">

                    <label><span class="text-danger">*</span> Foto (1200x627)</label>
                    <input name="new_image" type="file" onchange="previewNewImage();">
                </div>
                <div class="form-group col-md-6">
                    <?php
                    if (isset($valorForm['image']) AND (!empty($valorForm['image']))) {
                        $old_image = URLADM . 'assets/imagens/policies/' . $valorForm['id'] . '/' . $valorForm['image'];
                    } elseif (isset($valorForm['old_image']) AND (!empty($valorForm['old_image']))) {
                        $old_image = URLADM . 'assets/imagens/policies/' . $valorForm['id'] . '/' . $valorForm['old_image'];
                    } else {
                        $old_image = URLADM . 'assets/imagens/policies/preview_img.jpg';
                    }
                    ?>
                    <img src="<?php echo $old_image; ?>" alt="Imagem da política" id="preview-image" class="img-thumbnail" style="width: 300px; height: 150px;">
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
                    <input name="slug" type="text" class="form-control" placeholder="Slug do artigo" value="<?php
                    if (isset($valorForm['slug'])) {
                        echo $valorForm['slug'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Palavra chave</label>
                    <input name="keywords" type="text" class="form-control" placeholder="Palavra chave do artigo" value="<?php
                    if (isset($valorForm['keywords'])) {
                        echo $valorForm['keywords'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Data Inicial</label>
                    <input name="dataInicial" type="date" class="form-control" value="<?php
                    if (isset($valorForm['dataInicial'])) {
                        echo $valorForm['dataInicial'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Data Final</label>
                    <input name="dataFinal" type="date" class="form-control" value="<?php
                    if (isset($valorForm['dataFinal'])) {
                        echo $valorForm['dataFinal'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Destaque</label>
                    <select name="destaque" id="destaque" class="form-control" required>
                        <?php
                        if ($valorForm['destaque'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif ($valorForm['destaque'] == 2) {
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
            <input name="EditPolicie" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
