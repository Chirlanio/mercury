<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']['responsibles']);
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
                        echo "<a href='" . URLADM . "view-check-list/check-list/" . $valorForm['hash_id'] . "' class='btn btn-outline-primary btn-sm'><i class='fas fa-eye'></i></a> ";
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
                            echo "<a class='dropdown-item' href='" . URLADM . "view-check-list/check-list/" . $valorForm['hash_id'] . "'>Visualizar</a>";
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

        <?php
        $dataNow = date("Y/m/d");
        echo '<div>';
        foreach ($this->Dados['form'] as $formQuestion) {
            try{
            extract($formQuestion);
            }catch(Exception $e){
                $_SESSION['msg'] = "Nenhum registro encontrado";
            }
            ?>
            <form method="POST" action="" enctype="multipart/form-data" class="was-validated"> 
                <input type='hidden' name='adms_store_id' id='adms_store_id' value="<?php echo $valorForm['adms_store_id']; ?>">
                <input name="hash_id" type="hidden" value="<?php
                if (isset($valorForm['hash_id'])) {
                    echo $valorForm['hash_id'];
                }
                ?>">

                <h4 class="mb-3"><?php echo $cla_id . " - " . $name_area ?></h4>
                <h6>Perguntas respondidas: <span class="text-success"><?php echo $this->Dados['select']['countHashResp'][0]['resp_result']; ?></span>.</h6>
                <h6>Faltam: <span class="text-danger"><?php echo $this->Dados['select']['countHashNoResp'][0]['no_resp_result']; ?></span>.</h6>

                <?php
                foreach ($this->Dados['form'] as $question) {
                    extract($question);
                    if ($cla_id == $clqa_id) {
                        ?>
                        <input name="id" type="hidden" value="<?php echo $cls_id; ?>">
                        <h6 class="mb-3"><?php echo $cla_id . "." . $clq_id . " - " . $question_description; ?></h6>

                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                                <input id="<?php echo $cla_id . '-' . $clq_id . '1'; ?>" name="adms_sits_question_id" type="radio" class="custom-control-input is-invalid" value="2" required>
                                <label class="custom-control-label" for="<?php echo $cla_id . '-' . $clq_id . '1'; ?>">Atendeu</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="<?php echo $cla_id . '-' . $clq_id . '2'; ?>" name="adms_sits_question_id" type="radio" class="custom-control-input is-invalid" value="3" required>
                                <label class="custom-control-label" for="<?php echo $cla_id . '-' . $clq_id . '2'; ?>">Atendeu Parcial</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="<?php echo $cla_id . '-' . $clq_id . '3'; ?>" name="adms_sits_question_id" type="radio" class="custom-control-input is-invalid" value="4" required>
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
                                <label for="file_name">Arquivo<small class="text-muted"> - Selecione somente imagens dos tipos '.jpg, .jpeg e .png'</small></label>
                                <input class="form-control-file is-invalid" name="file_name[]" id="file_name" type="file" multiple>
                            </div>
                        </div>

                        <hr>

                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="action_plans">Plano de Ação</label>
                                <textarea class="form-control is-valid editorCK" id="action_plans" name="action_plans" rows="5" cols="10"></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            
                            <div class="form-group col-lg-3 col-md-12">
                                <label for="initial_date">Início</label>
                                <input class="form-control" type="date" id="initial_date" name="initial_date">
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-12">
                                <label for="final_date">Fim</label>
                                <input class="form-control" type="date" id="final_date" name="final_date">
                            </div>
                            
                            <div class="form-group col-lg-6 col-md-12">
                                <label for="action_plan_responsible_id">Responsavel</label>

                                <select class="custom-select" name="action_plan_responsible_id" id="action_plan_responsible_id">
                                    <option value="">Selecione</option>
                                    <?php
                                    foreach ($this->Dados['select']['responsibles'] as $responsavel) {
                                        extract($responsavel);
                                        if (isset($valorForm['action_plan_responsible_id']) and ($valorForm['action_plan_responsible_id'] == $s_id)) {
                                            echo "<option value='$s_id' selected>$resp_store</option>";
                                        } else {
                                            echo "<option value='$s_id'>$resp_store</option>";
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                            
                        </div>

                        <?php
                    }
                }
                ?>

                <p>
                    <span class="text-danger">* </span>Campo obrigatório
                </p>
                <input name="EditCheckList" type="submit" class="btn btn-warning" value="Salvar">

            </form>
            <?php
        }
        echo '</div>';
        ?>
    </div>
</div>
