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
                <h2 class="display-4 titulo">Editar Cargo</h2>
            </div>
            <span class="d-none d-md-block">
                <?php
                if ($this->Dados['botao']['list_cargo']) {
                    echo "<a href='" . URLADM . "cargo/listar-cargo' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['vis_cargo']) {
                    echo "<a href='" . URLADM . "ver-cargo/ver-cargo/{$valorForm['id']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
                }
                ?>
            </span>

        </div>
        <hr>
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
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome do cargo" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="adms_niv_cargo_id"><span class="text-danger">*</span> Nível do cargo</label>
                    <select name="adms_niv_cargo_id" id="adms_niv_cargo_id" class="form-control is-invalid" required>
                        <?php
                        if (isset($valorForm['adms_niv_cargo_id']) and $valorForm['adms_niv_cargo_id'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Gerencial</option>";
                            echo "<option value='2'>Operacional</option>";
                        } elseif (isset($valorForm['adms_niv_cargo_id']) and $valorForm['adms_niv_cargo_id'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Gerencial</option>";
                            echo "<option value='2' selected>Operacional</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Gerencial</option>";
                            echo "<option value='2'>Operacional</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditCargo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
