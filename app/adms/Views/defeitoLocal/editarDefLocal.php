<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['form']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Local do Defeito</h2>
            </div>
            <span class="d-none d-md-block">
                <?php
                if ($this->Dados['botao']['list_def_local']) {
                    echo "<a href='" . URLADM . "defeito-local/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['vis_def_local']) {
                    echo "<a href='" . URLADM . "ver-defeito-local/ver-defeito-local/{$valorForm['id']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
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
        <form method="POST" action="" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-9">
                    <label><span class="text-danger">* </span>Descrição</label>
                    <input name="descricao" class="form-control" value="<?php
                    if (isset($valorForm['descricao'])) {
                        echo $valorForm['descricao'];
                    }
                    ?>">
                </div>
                
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span>Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="status_id" id="status_id" class="custom-select is-invalid" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $st) {
                            extract($st);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$s_id'>$sit</option>";
                            }
                        }
                    } else {
                        echo '<select name="status_id" id="sit_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $st) {
                            extract($st);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$s_id'>$sit</option>";
                            }
                        }
                    }
                    ?>
                    </select>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditDefLocal" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
