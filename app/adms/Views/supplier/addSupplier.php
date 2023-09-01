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
                <h2 class="display-4 titulo">Cadastrar Fornecedor</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_supplier']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'supplier/list'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i> Listar</a>
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
        <form method="POST" action="" class="was-validated" enctype="multipart/form-data"> 
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Razão Social</label>
                    <input name="corporate_social" type="text" class="form-control is-invalid" placeholder="Razão social" value="<?php
                    if (isset($valorForm['corporate_social'])) {
                        echo $valorForm['corporate_social'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome Fantasia</label>
                    <input name="fantasy_name" type="text" class="form-control is-invalid" placeholder="Nome fantasia" value="<?php
                    if (isset($valorForm['fantasy_name'])) {
                        echo $valorForm['fantasy_name'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> CPF/CNPJ</label>
                    <input name="cnpj_cpf" id="cnpj_cpf" type="text" class="form-control is-invalid" placeholder="CPF ou CNPJ" value="<?php
                    if (isset($valorForm['cnpj_cpf'])) {
                        echo $valorForm['cnpj_cpf'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Contado</label>
                    <input name="contact" type="tel" id="contact" class="form-control is-invalid" placeholder="(00) 98888-8888" value="<?php
                    if (isset($valorForm['contact'])) {
                        echo $valorForm['contact'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> E-mail</label>
                    <input name="email" type="email" class="form-control is-invalid" placeholder="email@email.com.br" value="<?php
                    if (isset($valorForm['email'])) {
                        echo $valorForm['email'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5) {
                        echo '<select name="status_id" id="status_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
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
                        echo '<select name="status_id" id="status_id" class="form-control is-invalid" required>';
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
            <input name="AddSupplier" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
