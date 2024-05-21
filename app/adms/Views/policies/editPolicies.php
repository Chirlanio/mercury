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
                <div class="form-group col-md-12">

                    <input name="file_name_old" type="hidden" value="<?php
                    if (isset($valorForm['link'])) {
                        echo $valorForm['link'];
                    }
                    ?>">
                    
                    <label>Arquivo</label>
                    <input class="form-control-file is-valid" name="file_name_new" type="file" />
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditPolicie" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
