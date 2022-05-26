<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
var_dump($this->Dados['form']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Auditor Responsável</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_resp_auditoria']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'responsavel-auditoria/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome do Auditor" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Empresa</label>
                    <input name="empresa" type="text" class="form-control is-invalid" placeholder="Nome da empresa" value="<?php
                    if (isset($valorForm['empresa'])) {
                        echo $valorForm['empresa'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] >= 4) {
                        echo '<select name="status_id" id="rota_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $sol) {
                            extract($sol);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$status</option>";
                            } else {
                                echo "<option value='$S_id'>$status</option>";
                            }
                        }
                    } else {
                        echo '<select name="status_id" id="status_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sit'] as $sol) {
                            extract($sol);
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
            <input name="CadRespAuditoria" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
