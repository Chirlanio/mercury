<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['form'][0]);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Artigo</h2>
            </div>

            <div class="p-2 d-print-none">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_art']) {
                        echo "<a href='" . URLADM . "artigo/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                    }
                    if ($this->Dados['botao']['vis_art']) {
                        echo "<a href='" . URLADM . "ver-artigo/ver-artigo/" . $valorForm['id'] . "' class='btn btn-outline-success btn-sm'>Visualizar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_art']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "artigo/listar'>Listar</a>";
                        }
                        if ($this->Dados['botao']['vis_art']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "ver-artigo/ver-artigo/" . $valorForm['id'] . "'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div><hr>
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
                    <input name="titulo" type="text" class="form-control" placeholder="Titulo do artigo" value="<?php
                    if (isset($valorForm['titulo'])) {
                        echo $valorForm['titulo'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Descrição</label>
                    <textarea name="descricao" class="form-control editorCKQl" id="editor"><?php
                        if (isset($valorForm['descricao'])) {
                            echo $valorForm['descricao'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Resumo Publico</label>
                    <textarea name="resumo_publico" id="editor-dois" class="form-control editorDesUm" rows="3"><?php
                        if (isset($valorForm['resumo_publico'])) {
                            echo $valorForm['resumo_publico'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Conteúdo do Artigo</label>
                    <textarea name="conteudo" id="editor-tres" class="form-control editorCK" rows="3"><?php
                        if (isset($valorForm['conteudo'])) {
                            echo $valorForm['conteudo'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
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
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Tipo de Artigo</label>
                    <select name="adms_tps_artigo_id" id="adms_tps_artigo_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tpart'] as $tpart) {
                            extract($tpart);
                            if ($valorForm['adms_tps_artigo_id'] == $id_tpart) {
                                echo "<option value='$id_tpart' selected>$nome_tpart</option>";
                            } else {
                                echo "<option value='$id_tpart'>$nome_tpart</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Categoria do Artigo</label>
                    <select name="adms_cats_artigo_id" id="adms_cats_artigo_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['catart'] as $catart) {
                            extract($catart);
                            if ($valorForm['adms_cats_artigo_id'] == $id_catart) {
                                echo "<option value='$id_catart' selected>$nome_catart</option>";
                            } else {
                                echo "<option value='$id_catart'>$nome_catart</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div> 

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input name="imagem_antiga" type="hidden" value="<?php
                    if (isset($valorForm['imagem_antiga'])) {
                        echo $valorForm['imagem_antiga'];
                    } elseif (isset($valorForm['imagem'])) {
                        echo $valorForm['imagem'];
                    }
                    ?>">

                    <label><span class="text-danger">*</span> Foto (1200x627)</label>
                    <input name="imagem_nova" type="file" onchange="previewImagem();">
                </div>
                <div class="form-group col-md-6">
                    <?php
                    if (isset($valorForm['imagem']) AND!empty($valorForm['imagem'])) {
                        $imagem_antiga = URLADM . 'assets/imagens/artigos/' . $valorForm['id'] . '/' . $valorForm['imagem'];
                    } elseif (isset($valorForm['imagem_antiga']) AND (!empty($valorForm['imagem_antiga']))) {
                        $imagem_antiga = URLADM . 'assets/imagens/artigos/' . $valorForm['id'] . '/' . $valorForm['imagem_antiga'];
                    } else {
                        $imagem_antiga = URLADM . 'assets/imagens/artigos/preview_img.jpg';
                    }
                    ?>
                    <img src="<?php echo $imagem_antiga; ?>" alt="Imagem do artigo" id="preview-user" class="img-thumbnail" style="width: 300px; height: 150px;">
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
                    <select name="destaque" id="lib_pub" class="form-control" required>
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
            <input name="EditArtigo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
