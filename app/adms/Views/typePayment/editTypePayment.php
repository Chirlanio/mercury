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
                <h2 class="display-4 titulo">Tipo de Pagamento</h2>
            </div>
            <?php
            if ($this->Dados['botao']['view_pay']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'view-type-payments/type-payment/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i> Visualizar</a>
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
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="name" type="text" class="form-control is-invalid" placeholder="Digite o nome do tipo de pagamento" value="<?php
                    if (isset($valorForm['name'])) {
                        echo $valorForm['name'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5) {
                        echo '<select name="status_id" id="status_id" class="form-control is-invalid" aria-label="Disabled input" disabled required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sits'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $id) {
                                echo "<option value='$id' selected>$status</option>";
                            } else {
                                echo "<option value='$id'>$status</option>";
                            }
                        }
                    } else {
                        echo '<select name="status_id" id="status_id" class="form-control is-invalid" required>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sits'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $id) {
                                echo "<option value='$id' selected>$status</option>";
                            } else {
                                echo "<option value='$id'>$status</option>";
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
            <input name="EditType" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
