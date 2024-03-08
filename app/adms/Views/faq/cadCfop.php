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
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar CFOP</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_cfop']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'cfop/listar'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i></a>
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
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Operação</label>
                    <input name="operation" type="text" class="form-control is-invalid" placeholder="Nome da operação" value="<?php
                    if (isset($valorForm['operation'])) {
                        echo $valorForm['operation'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> CFOP</label>
                    <input name="cfop" type="number" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['cfop'])) {
                        echo $valorForm['cfop'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Estado</label>
                    <select name="estado" id="estado" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['estado']) === 'CEARA') {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Ceará</option>";
                            echo "<option value='2'>Outros Estados</option>";
                        } elseif (isset($valorForm['estado']) === 'OUTRO ESTADO') {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Ceará</option>";
                            echo "<option value='2' selected>Outros Estados</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Ceará</option>";
                            echo "<option value='2'>Outros Estados</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> CST ICMS</label>
                    <input name="cst_icms" type="text" class="form-control is-invalid" placeholder="3 Digitos" maxlength="3" value="<?php
                    if (isset($valorForm['cst_icms'])) {
                        echo $valorForm['cst_icms'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> ALIQ.ICMS</label>
                    <input name="aliq_icms" type="text" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['aliq_icms'])) {
                        echo $valorForm['aliq_icms'];
                    }
                    ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> CST IPI</label>
                    <input name="cst_ipi" type="text" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['cst_ipi'])) {
                        echo $valorForm['cst_ipi'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> CST PIS/COFINS</label>
                    <input name="cst_pis_cofins" type="text" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['cst_pis_cofins'])) {
                        echo $valorForm['cst_pis_cofins'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> PIS</label>
                    <input name="pis" type="text" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['pis'])) {
                        echo $valorForm['pis'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> COFINS</label>
                    <input name="cofins" type="text" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['cofins'])) {
                        echo $valorForm['cofins'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Tipo Produto</label>
                    <select name="tipo_produto" id="tipo_produto" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['tipo_produto']) === 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Acessório</option>";
                            echo "<option value='2'>Couro</option>";
                            echo "<option value='3'>Todos os Produtos</option>";
                        } elseif (isset($valorForm['tipo_produto']) === 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Acessório</option>";
                            echo "<option value='2' selected>Couro</option>";
                            echo "<option value='3'>Todos os Produtos</option>";
                        } elseif (isset($valorForm['tipo_produto']) === 3) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Acessório</option>";
                            echo "<option value='2'>Couro</option>";
                            echo "<option value='3' selected>Todos os Produtos</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Acessório</option>";
                            echo "<option value='2'>Couro</option>";
                            echo "<option value='3'>Todos os Produtos</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadCfop" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
