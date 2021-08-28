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
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Lojas</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_loja']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'loja/listarLojas'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                <div class="form-group col-md-2">
                    <label><span class="text-danger">* </span>ID</label>
                    <input name="id" type="text" class="form-control is-invalid" placeholder="ID da Loja" value="<?php
                    if (isset($valorForm['id'])) {
                        echo $valorForm['id'];
                    }
                    ?>" required>
                </div>
                <div class = "form-group col-md-3">
                    <label><span class = "text-danger">* </span>Nome da Loja</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Digite o nome da loja" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required>
                </div>
                <div class = "form-group col-md-2">
                    <label><span class = "text-danger">* </span>CNPJ</label>
                    <input name="cnpj" type="text" class="form-control is-invalid" placeholder="Somente números" value="<?php
                    if (isset($valorForm['cnpj'])) {
                        echo $valorForm['cnpj'];
                    }
                    ?>" required>
                </div>
                <div class = "form-group col-md-5">
                    <label><span class = "text-danger">* </span>Razão Social</label>
                    <input name="razao_social" type="text" class="form-control is-invalid" placeholder="EX: MEIA SOLA ACESSÓRIOS DE MODA LTDA" value="<?php
                    if (isset($valorForm['razao_social'])) {
                        echo $valorForm['razao_social'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label><span class="text-danger">* </span>Inscrição Estadual</label>
                    <input name="ins_estadual" type="text" class="form-control is-invalid" placeholder="Somente números" value="<?php
                    if (isset($valorForm['ins_estadual'])) {
                        echo $valorForm['ins_estadual'];
                    }
                    ?>" required="">
                </div>
                <div class = "form-group col-md-10">
                    <label><span class = "text-danger">* </span>Endereço</label>
                    <input name="endereco" type="text" class="form-control is-invalid" placeholder="Rua Dom Manuel, 621 Centro, Fortaleza - CE" value="<?php
                    if (isset($valorForm['endereco'])) {
                        echo $valorForm['endereco'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">* </span>Rede</label>
                    <select name="rede_id" id="rede_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['rede_id'] as $rede) {
                            extract($rede);
                            if ($valorForm['rede_id'] == $rede_id) {
                                echo "<option value='$rede_id' selected>$rede</option>";
                            } else {
                                echo "<option value='$rede_id'>$rede</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">* </span>Gerente</label>
                    <select name="func_id" id="func_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func_id'] as $rede) {
                            extract($rede);
                            if ($valorForm['func_id'] == $func_id) {
                                echo "<option value='$func_id' selected>$func</option>";
                            } else {
                                echo "<option value='$func_id'>$func</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger text-center">* </span>Situação</label>
                    <select name="status_id" id="status_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['status_id'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $sit_id) {
                                echo "<option value='$sit_id' selected>$sit</option>";
                            } else {
                                echo "<option value='$sit_id'>$sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <input name="created" type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadLoja" type="submit" class="btn btn-success" value="Cadastrar">
        </form>
    </div>
</div>
