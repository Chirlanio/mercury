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
                <h2 class="display-4 titulo">Editar Motivo - <?php echo $valorForm['motivo']; ?></h2>
            </div>

            <?php
            if ($this->Dados['botao']['list_motivo']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'motivo-estorno/listar'; ?>" class="btn btn-outline-info btn-sm">Listar</a>
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
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Motivo</label>
                    <input name="nome" type="text" class="form-control" placeholder="Digite o motivo do estorno" value="<?php
                    if (isset($valorForm['motivo'])) {
                        echo $valorForm['motivo'];
                    }
                    ?>">
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditMotivo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
