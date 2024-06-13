<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']['resp']);
?>
<div class="content p-1">
    <div class="list-group-item h-100">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Check List</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_check_list']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'check-list/list'; ?>" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-list"></i></a>
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
                    <label><span class="text-danger">*</span> Loja</label>
                    <?php
                    echo '<select name="adms_store_id" id="adms_store_id" class="form-control is-invalid" required>';
                    echo '<option value="">Selecione</option>';
                    foreach ($this->Dados['select']['stores'] as $store) {
                        extract($store);
                        if ($valorForm['adms_store_id'] == $l_id) {
                            echo "<option value='$l_id' selected>$name_store</option>";
                        } else {
                            echo "<option value='$l_id'>$name_store</option>";
                        }
                    }
                    echo "</select>";
                    ?>
                </div>

                <div class="form-group col-md-6">
                    <label for="responsible_applicator"><span class="text-danger">*</span> Aplicador</label>
                    <select name="responsible_applicator" id="responsible_applicator" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['responsible_applicator']) and $valorForm['responsible_applicator'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Deborah Costa</option>";
                            echo "<option value='2'>Larissa Marcarenhas</option>";
                        } elseif (isset($valorForm['responsible_applicator']) and $valorForm['responsible_applicator'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Deborah Costa</option>";
                            echo "<option value='2' selected>Larissa Mascarenhas</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Deborah Costa</option>";
                            echo "<option value='2'>Larissa Marcarenhas</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="AddCheckList" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
