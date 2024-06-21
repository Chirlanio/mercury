<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['form']);
?>
<div class="content p-1">
    <div class="list-group-item h-100">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Check List - <strong>ID: </strong><span style="font-size: 14px;" ><?php echo $valorForm['hash_id']; ?></span></h2>
            </div>

            <div class="p-2 d-print-none">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['list_check_list']) {
                        echo "<a href='" . URLADM . "check-list/list' class='btn btn-outline-info btn-sm ml-2' title='Listar'><i class='fas fa-list'></i></a> ";
                    }
                    if ($this->Dados['botao']['view_check_list']) {
                        echo "<a href='" . URLADM . "view-check-list/check-list/" . $valorForm['id'] . "' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i></a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                        <?php
                        if ($this->Dados['botao']['list_check_list']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "check-list/list'>Listar</a>";
                        }
                        if ($this->Dados['botao']['view_check_list']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "check-list/check-list/" . $valorForm['id'] . "'>Cadastrar</a>";
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
            <input name="hash_id" type="hidden" value="<?php
            if (isset($valorForm['hash_id'])) {
                echo $valorForm['hash_id'];
            }
            ?>">

            <?php
            echo "<input type='hidden' name='adms_store_id' id='adms_store_id' value='" . $valorForm['adms_store_id'] . "'>";
            echo '<div>';
            foreach ($this->Dados['select']['areas'] as $area) {
                extract($area);
                ?>

                <h4 class="mb-3"><?php echo $cla_id . " - " . $name_area ?></h4>

                <?php
                foreach ($this->Dados['select']['questions'] as $question) {
                    extract($question);
                    if ($cla_id == $clqa_id) {
                        ?>
                        <h6 class="mb-3"><?php echo $cla_id . "." . $clq_id . " - " . $question_description ?></h6>

                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                                <input id="<?php echo $cla_id . '-' . $clq_id . '1'; ?>" name="<?php echo 'adms_sits_question_id-' . $cla_id . $clq_id; ?>" type="radio" class="custom-control-input is-invalid" value="1" required>
                                <label class="custom-control-label" for="<?php echo $cla_id . '-' . $clq_id . '1'; ?>">Atendeu</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="<?php echo $cla_id . '-' . $clq_id . '2'; ?>" name="<?php echo 'adms_sits_question_id-' . $cla_id . $clq_id; ?>" type="radio" class="custom-control-input is-invalid" value="2" required>
                                <label class="custom-control-label" for="<?php echo $cla_id . '-' . $clq_id . '2'; ?>">Atendeu Parcial</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="<?php echo $cla_id . '-' . $clq_id . '3'; ?>" name="<?php echo 'adms_sits_question_id-' . $cla_id . $clq_id; ?>" type="radio" class="custom-control-input is-invalid" value="3" required>
                                <label class="custom-control-label" for="<?php echo $cla_id . '-' . $clq_id . '3'; ?>">Não Atendeu</label>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="justified">Justificativas</label>
                                <input type="text" name="justified" id="justified" class="form-control is-invalid" value="<?php
                                if (isset($valorForm['justified']) and !empty($valorForm['justified'])) {
                                    echo $valorForm['justified'];
                                } else {
                                    echo '';
                                }
                                ?>">

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="file_name">Arquivo</label>
                                <input class="form-control-file is-invalid" name="file_name[]" id="file_name" type="file" multiple/>
                            </div>
                        </div>
                        
                        <?php
                    }
                }
            }
            echo '</div>';
            ?>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditCheckList" type="submit" class="btn btn-warning" value="Salvar">

        </form>
    </div>
</div>
