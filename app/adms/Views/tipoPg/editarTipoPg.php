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
                <h2 class="display-4 titulo">Editar Tipo de Página</h2>
            </div>
            <span class="d-none d-md-block">
                <?php
                if ($this->Dados['botao']['list_tpg']) {
                    echo "<a href='" . URLADM . "tipo-pg/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['vis_tpg']) {
                    echo "<a href='" . URLADM . "ver-tipo-pg/ver-tipo-pg/{$valorForm['id']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
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
                    <label><span class="text-danger">*</span> Tipo</label>
                    <input name="tipo" type="text" class="form-control is-invalid" placeholder="Tipo da página Ex: adms, sts" value="<?php
                    if (isset($valorForm['tipo'])) {
                        echo $valorForm['tipo'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome do tipo da página" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label><span class="text-danger">*</span> Observação</label>
                <textarea name="obs" class="form-control is-invalid editorCK" id="obs" rows="3" required><?php
                    if (isset($valorForm['obs'])) {
                        echo $valorForm['obs'];
                    }
                    ?>
                </textarea>
            </div>
            
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditTipoPg" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
