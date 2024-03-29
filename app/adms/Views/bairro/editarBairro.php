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
                <h2 class="display-4 titulo">Editar Bairro</h2>
            </div>
            <span class="d-none d-md-block">
                <?php
                if ($this->Dados['botao']['list_bairro']) {
                    echo "<a href='" . URLADM . "bairro/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['vis_bairro']) {
                    echo "<a href='" . URLADM . "ver-bairro/ver-bairro/{$valorForm['id_bai']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
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
        <form method="POST" action="" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id_bai'])) {
                echo $valorForm['id_bai'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control" placeholder="Nome do bairro" value="<?php
                    if (isset($valorForm['bairro'])) {
                        echo $valorForm['bairro'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Rota</label>
                    <?php
                    if ($_SESSION['adms_niveis_acesso_id'] > 2) {
                        echo '<select name="rota_id" id="rota_id" class="form-control" aria-label="Disabled input" disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['rota_id'] as $sol) {
                            extract($sol);
                            if ($valorForm['r_id'] == $r_id) {
                                echo "<option value='$r_id' selected>$rota</option>";
                            } else {
                                echo "<option value='$r_id'>$rota</option>";
                            }
                        }

                        echo "</select>";
                    } else {
                        echo '<select name="rota_id" id="rota_id" class="form-control">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['rota_id'] as $sol) {
                            extract($sol);
                            if ($valorForm['r_id'] == $r_id) {
                                echo "<option value='$r_id' selected>$rota</option>";
                            } else {
                                echo "<option value='$r_id'>$rota</option>";
                            }
                        }

                        echo "</select>";
                    }
                    ?>
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditBairro" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
