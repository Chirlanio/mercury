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
                <h2 class="display-4 titulo">Cadastrar Situações de Ajustes</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_sit']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'situacao-order-payment/listar'; ?>" class="btn btn-outline-info btn-sm"><i class='fa-solid fa-list'></i></a>
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
                    <input name="name" type="text" class="form-control is-invalid" placeholder="Nome da situação" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Ordem</label>
                    <input name="order_sit" type="number" class="form-control is-invalid" value="<?php
                    if (isset($valorForm['order'])) {
                        echo $valorForm['order'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="status_id" id="status_id" class="form-control is-invalid" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $id_sit) {
                                echo "<option value='$id_sit' selected>$status</option>";
                            } else {
                                echo "<option value='$id_sit'>$status</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="CadSit" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
