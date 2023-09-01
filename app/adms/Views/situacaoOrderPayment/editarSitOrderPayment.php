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
                <h2 class="display-4 titulo">Editar Situação</h2>
            </div>
            <?php
            if ($this->Dados['botao']['vis_sit']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'situacao-order-payment/listar'; ?>" class="btn btn-outline-primary btn-sm">Listar</a>
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
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="name" type="text" class="form-control" placeholder="Nome da situação" value="<?php
                    if (isset($valorForm['name'])) {
                        echo $valorForm['name'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Ordem</label>
                    <input name="order_sit" type="text" class="form-control" value="<?php
                    if (isset($valorForm['order_sit'])) {
                        echo $valorForm['order_sit'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="status_id" id="status_id" class="form-control" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $id) {
                                echo "<option value='$id' selected>$status</option>";
                            } else {
                                echo "<option value='$id'>$status</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditSit" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
