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
                <h2 class="display-4 titulo">Editar CFOP</h2>
            </div>
            <span class="d-none d-md-block">
                <?php
                if ($this->Dados['botao']['list_cfop']) {
                    echo "<a href='" . URLADM . "cfop/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['vis_cfop']) {
                    echo "<a href='" . URLADM . "ver-cfop/ver-cfop/{$valorForm['id']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
                }
                ?>
            </span>

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
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Operação</label>
                    <input name="operation" type="text" class="form-control" placeholder="Nome da Operação" value="<?php
                    if (isset($valorForm['operation'])) {
                        echo $valorForm['operation'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> CFOP</label>
                    <input name="cfop" type="number" class="form-control" value="<?php
                    if (isset($valorForm['cfop'])) {
                        echo $valorForm['cfop'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Estado</label>
                    <select name="estado" id="estado" class="form-control" required>
                        <?php
                        if (isset($valorForm['estado']) == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Ceará</option>";
                            echo "<option value='2'>Outros Estados</option>";
                        } elseif (isset($valorForm['estado']) == 2) {
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
                    <input name="cst_icms" type="text" class="form-control" value="<?php
                    if (isset($valorForm['cst_icms'])) {
                        echo $valorForm['cst_icms'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> Alíquota ICMS</label>
                    <input name="aliq_icms" type="number" class="form-control" value="<?php
                    if (isset($valorForm['aliq_icms'])) {
                        echo $valorForm['aliq_icms'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> CST IPI</label>
                    <input name="cst_ipi" type="text" class="form-control" value="<?php
                    if (isset($valorForm['cst_ipi'])) {
                        echo $valorForm['cst_ipi'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> CST PIS/COFINS</label>
                    <input name="cst_pis_cofins" type="text" class="form-control" value="<?php
                    if (isset($valorForm['cst_pis_cofins'])) {
                        echo $valorForm['cst_pis_cofins'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> PIS</label>
                    <input name="pis" type="text" class="form-control" value="<?php
                    if (isset($valorForm['pis'])) {
                        echo $valorForm['pis'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-2">
                    <label><span class="text-danger">*</span> COFINS</label>
                    <input name="cofins" type="text" class="form-control" value="<?php
                    if (isset($valorForm['cofins'])) {
                        echo $valorForm['cofins'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Tipo Produtos</label>
                    <select name="tipo_produto" id="estado" class="form-control" required>
                        <?php
                        if (isset($valorForm['tipo_produto']) == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Acessório</option>";
                            echo "<option value='2'>Couro</option>";
                            echo "<option value='3'>Todos Produtos</option>";
                        } elseif (isset($valorForm['tipo_produto']) == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Acessório</option>";
                            echo "<option value='2' selected>Couro</option>";
                            echo "<option value='3'>Todos Produtos</option>";
                        } elseif (isset($valorForm['tipo_produto']) == 3) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Acessório</option>";
                            echo "<option value='2'>Couro</option>";
                            echo "<option value='3' selected>Todos Produtos</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Acessório</option>";
                            echo "<option value='2' selected>Couro</option>";
                            echo "<option value='3'>Todos Produtos</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditCfop" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
