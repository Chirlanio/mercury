<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($_FILES);
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Cadastro do Arquivo</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_arq']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'listar-arquivo/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
        <form method="POST" action="" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Titulo</label>
                    <input name="nome" type="text" class="form-control" placeholder="Nome do arquivo" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Campanha - Promoção</label>
                    <select name="adms_art_id" id="adms_art_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['art'] as $art) {
                            extract($art);
                            if (isset($valorForm['adms_art_id']) AND $valorForm['adms_art_id'] == $id_art) {
                                echo "<option value='$id_art' selected>$titulo</option>";
                            } else {
                                echo "<option value='$id_art'>$titulo</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="status_id" id="status_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if (isset($valorForm['status_id']) AND $valorForm['status_id'] == $id_sit) {
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
                    <input name="arq_antigo" type="hidden" value="<?php
                    if (isset($valorForm['slug'])) {
                        echo $valorForm['slug'];
                    } elseif (isset($valorForm['arquivo'])) {
                        echo $valorForm['arquivo'];
                    }
                    ?>">
                    <label><span class="text-danger">*</span> Selecione um arquivo</label>
                    <input name="slug" type="file" class="form-control-file" value="<?php
                    if (isset($valorForm['arq_antigo'])) {
                        echo $valorForm['arq_antigo'];
                    } elseif (isset($valorForm['arquivo'])) {
                        echo $valorForm['arquivo'];
                    }
                    ?>">                    
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditArq" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
