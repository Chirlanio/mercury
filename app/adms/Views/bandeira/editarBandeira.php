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
                <h2 class="display-4 titulo">Editar Bandeira - <?php echo $valorForm['bandeira']; ?></h2>
            </div>
            <span class="d-none d-md-block">
                <?php
                if ($this->Dados['botao']['list_bandeira']) {
                    echo "<a href='" . URLADM . "bandeira/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['vis_bandeira']) {
                    echo "<a href='" . URLADM . "ver-bandeira/ver-bandeira/{$valorForm['id_ban']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
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
            if (isset($valorForm['id_ban'])) {
                echo $valorForm['id_ban'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome do bairro" value="<?php
                    if (isset($valorForm['bandeira'])) {
                        echo $valorForm['bandeira'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label>
                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                            <i class="fas fa-question-circle"></i>
                        </span> <span class="text-danger">*</span> Ícone</label>
                    <input name="icone" type="text" class="form-control is-invalid" placeholder="Ex: fas fa-cc-visa" value="<?php
                    if (isset($valorForm['icone'])) {
                        echo $valorForm['icone'];
                    }
                    ?>" required>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditBandeira" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
