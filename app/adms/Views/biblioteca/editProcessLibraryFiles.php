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
                <h2 class="display-4 titulo">Editar Arquivos</h2>
                <input type="hidden">
            </div>

            <div class="p-2 d-print-none">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_process']) {
                        echo "<a href='" . URLADM . "process-library/list' class='btn btn-outline-info btn-sm' title='Listar'><i class='fas fa-list'></i></a> ";
                    }
                    if ($this->Dados['botao']['view_process']) {
                        echo "<a href='" . URLADM . "view-process-library/process-library/" . $valorForm['id'] . "' class='btn btn-outline-primary btn-sm' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_process']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "process-library/list'>Listar</a>";
                        }
                        if ($this->Dados['botao']['view_process']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "view-process-library/process-library/" . $valorForm['id'] . "'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data" class="was-validated"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-row">
                <div class="form-group col-md-9">
                    <label for="adms_area_id"><span class="text-danger">*</span> Processo/Política</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="adms_process_library_id" id="adms_process_library_id" class="form-control is-invalid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['process'] as $file) {
                            extract($file);
                            if ($valorForm['adms_process_library_id'] == $pl_id) {
                                echo "<option value='$pl_id' selected>$processLibrary</option>";
                            } else {
                                echo "<option value='$pl_id'>$processLibrary</option>";
                            }
                        }
                        echo "</select>";
                    } else {
                        echo '<select name="adms_process_library_id" id="adms_process_library_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['process'] as $file) {
                            extract($file);
                            if ($valorForm['adms_process_library_id'] == $pl_id) {
                                echo "<option value='$pl_id' selected>$processLibrary</option>";
                            } else {
                                echo "<option value='$pl_id'>$processLibrary</option>";
                            }
                        }
                        echo "</select>";
                    }
                    ?>
                </div>
                <div class="form-group col-md-3">
                    <label for="adms_area_id"><span class="text-danger">*</span> Situação</label>
                    <?php
                    if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION || $_SESSION['adms_niveis_acesso_id'] == ADMPERMITION) {
                        echo '<select name="status_id" id="status_id" class="form-control is-invalid">';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sits'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$status</option>";
                            } else {
                                echo "<option value='$s_id'>$status</option>";
                            }
                        }
                        echo "</select>";
                    } else {
                        echo '<select name="status_id" id="status_id" class="form-control is-valid" aria-label="Disabled input" required disabled>';
                        echo '<option value="">Selecione</option>';
                        foreach ($this->Dados['select']['sits'] as $sit) {
                            extract($sit);
                            if ($valorForm['status_id'] == $s_id) {
                                echo "<option value='$s_id' selected>$status</option>";
                            } else {
                                echo "<option value='$s_id'>$status</option>";
                            }
                        }
                        echo "</select>";
                    }
                    ?>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="mb-3">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Arquivos</h6>
                                    <small class="text-muted">
                                        <?php
                                        $types = array('png', 'jpg', 'jpeg', 'doc', 'pdf', 'docx', 'xlsx', 'rar', 'xls');
                                        $path = 'assets/files/processLibrary/' . $valorForm['id'] . '/';
                                        $dir = new DirectoryIterator($path);
                                        foreach ($dir as $fileInfo) {
                                            $ext = strtolower($fileInfo->getExtension());
                                            if (in_array($ext, $types)) {
                                                $arquivo = $fileInfo->getFilename();
                                                echo "<span class='m-auto lead'>";
                                                echo $arquivo . " - <a href='" . URLADM . "assets/files/processLibrary/" . $valorForm['id'] . "/$arquivo' class='btn btn-dark btn-sm mr-1' download><i class='fas fa-download'></i> Baixar</a>";
                                                echo "<a href='" . URLADM . "edit-process-library/process-library/" . $valorForm['id'] . "?id=" . $valorForm['adms_process_library_id'] . "&file=$arquivo' class='btn btn-dark btn-sm'><i class='fa-solid fa-trash'></i> Apagar</a><br>";
                                                echo "</span>";
                                            }
                                        }
                                        ?>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <input name="exibition_name[]" type="hidden" value="<?php
                    if (isset($valorForm['exibition_name'])) {
                        echo $valorForm['exibition_name'];
                    } elseif (isset($valorForm['new_files'])) {
                        echo $valorForm['new_files'];
                    }
                    ?>" multiple>

                    <label for="new_files"><span class="text-danger">*</span> Novo Arquivo</label>
                    <input name="new_files[]" id="new_files" type="file" class="custom-file" multiple>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditFiles" type="submit" class="btn btn-warning" value="Salvar">

        </form>
    </div>
</div>
