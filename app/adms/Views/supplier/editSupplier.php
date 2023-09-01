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
                <h2 class="display-4 titulo">Fornecedor</h2>
            </div>

            <?php
            if ($this->Dados['botao']['view_supplier']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'view-supplier/view-supplier/' . $valorForm['id_supp']; ?>" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye"></i></a>
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
            if (isset($valorForm['id_supp'])) {
                echo $valorForm['id_supp'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Razão Social</label>
                    <input name="corporate_social" type="text" class="form-control" placeholder="Razão social" value="<?php
                    if (isset($valorForm['corporate_social'])) {
                        echo $valorForm['corporate_social'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome Fantasia</label>
                    <input name="fantasy_name" type="text" class="form-control" placeholder="Nome fantasia" value="<?php
                    if (isset($valorForm['fantasy_name'])) {
                        echo $valorForm['fantasy_name'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> CPF/CNPJ</label>
                    <input name="cnpj_cpf" type="text" id="cnpj" class="form-control" placeholder="" value="<?php
                    if (isset($valorForm['cnpj_cpf'])) {
                        echo $valorForm['cnpj_cpf'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Contato</label>
                    <input name="contact" type="text" id="phone_with_ddd" class="form-control" placeholder="" value="<?php
                    if (isset($valorForm['contact'])) {
                        echo $valorForm['contact'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> E-mail</label>
                    <input name="email" type="email" class="form-control" placeholder="email@email.com.br" value="<?php
                    if (isset($valorForm['email'])) {
                        echo $valorForm['email'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Rota</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="status_id" id="status_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$status</option>";
                            } else {
                                echo "<option value='$s_id'>$status</option>";
                            }
                        }
                    } else {
                        echo '<select name="status_id" id="status_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$status</option>";
                            } else {
                                echo "<option value='$s_id'>$status</option>";
                            }
                        }
                    }
                    echo "</select>";
                    ?>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditSupplier" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
