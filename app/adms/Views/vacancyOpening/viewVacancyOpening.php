<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_vacancy'][0])) {
    extract($this->Dados['dados_vacancy'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Abertura de Vaga - <strong>ID:</strong> <?php echo $id; ?></h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_vacancy']) {
                            echo "<a href='" . URLADM . "vacancy-opening/list' class='btn btn-outline-info btn-sm m-1' title='Listar'><i class='fas fa-list'></i></a>";
                        }
                        if ($this->Dados['botao']['edit_vacancy']) {
                            echo "<a href='" . URLADM . "edit-vacancy-opening/edit-vacancy/$id' class='btn btn-outline-warning btn-sm m-1' title='Editar'><i class='fa-solid fa-pen-to-square'></i></a>";
                        }
                        if ($this->Dados['botao']['del_vacancy']) {
                            echo "<a href='" . URLADM . "delete-vacancy-opening/delete-vacancy/$id' class='btn btn-outline-danger btn-sm m-1' data-confirm='Tem certeza de que deseja excluir o item selecionado?' title='Apagar'><i class='fas fa-eraser'></i></a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none d-print-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_ecommerce_order']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "vacancy-opening/list'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_ecommerce_order']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-vacancy-opening/edit-vacancy/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_ecommerce_order']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-vacancy-opening/delete-vacancy/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div><hr>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <div class="content p1">
                <div class="row">

                    <div class="col-md-12">
                        <form>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="loja_id">Loja</label>
                                    <input type="text" class="form-control bg-white" id="loja_id" readonly value="<?php echo $store_name; ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="adms_request_type_id">Tipo</label>
                                    <input type="text" class="form-control bg-white" id="adms_request_type_id" value="<?php echo $type_name; ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="func_id">Colaborador</label>
                                    <input type="text" class="form-control bg-white" id="func_id" value="<?php echo $employee_name; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="adms_cargo_id">Cargo</label>
                                    <input type="text" class="form-control bg-white" id="adms_cargo_id" value="<?php echo $cargo_nome; ?>" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label for="adms_work_schedule_id">Turno</label>
                                    <input name="adms_work_schedule_id" type="text" class="form-control bg-white" id="adms_work_schedule_id" value="<?php echo $schedules; ?>" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="adms_recruiters">Recrutador</label>
                                    <input name="adms_recruiters" type="text" class="form-control bg-white" id="adms_recruiters" value="<?php echo $recruiter_name; ?>" readonly />
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-2">
                                    <label for="interview_hr">1ª Entrevista</label>
                                    <input name="interview_hr" type="text" class="form-control bg-white" id="interview_hr" value="<?php echo (!empty($interview_hr) ? date("d/m/Y", strtotime($interview_hr)) : ""); ?>" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="evaluators_hr">Avaliador(a):</label>
                                    <input name="evaluators_hr" type="text" class="form-control bg-white" id="evaluators_hr" value="<?php echo $evaluators_hr; ?>" readonly />
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="interview_hr">2ª Entrevista</label>
                                    <input name="interview_hr" type="text" class="form-control bg-white" id="interview_hr" value="<?php echo (!empty($interview_leader) ? date("d/m/Y", strtotime($interview_leader)) : ""); ?>" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="evaluators_hr">Avaliador(a):</label>
                                    <input name="evaluators_hr" type="text" class="form-control bg-white" id="evaluators_hr" value="<?php echo $evaluators_leader; ?>" readonly />
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Candidato(a) Aprovado(a)</label>
                                    <input name="approved" id="approved" type="text" class="form-control bg-white" value="<?php echo (!empty($approved) ? $approved : ""); ?>" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><p>Observações:</p></h6>
                                            <small class="text-muted lead"><?php echo $comments; ?></small>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="form-row">
                                <div class="col-md-2 mb-3">
                                    <label for="delivery_forecast">SLA Previsto</label>
                                    <input type="text" class="form-control bg-white" id="delivery_forecast" value="<?php echo $predicted_sla; ?>" readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="delivery_forecast">Previsão de Entrega</label>
                                    <input type="text" class="form-control bg-white" id="delivery_forecast" value="<?php echo date("d/m/Y", strtotime($delivery_forecast)); ?>" readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="closing_date">Data de Fechamento</label>
                                    <input type="text" class="form-control bg-white" id="closing_date" value="<?php echo (!empty($closing_date) ? date("d/m/Y", strtotime($closing_date)) : ""); ?>" readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <?php
                                    $data_inicio = new DateTime($created);
                                    $data_fim = !empty($closing_date) ? new DateTime($closing_date) : new DateTime();

                                    // Resgata diferença entre as datas
                                    $dateInterval = $data_inicio->diff($data_fim);
                                    ?>
                                    <label for="delivery_forecast">SLA Efetivo</label>
                                    <input type="text" class="form-control bg-white" id="delivery_forecast" value="<?php echo (!empty($closing_date) ? $dateInterval->days + 1 : ""); ?>" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-2 mb-3">
                                    <label for="created">Cadastrado</label>
                                    <input type="text" class="form-control bg-white" id="created" value="<?php echo date("d/m/Y H:i:s", strtotime($created)); ?>" readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="modified">Atualizado</label>
                                    <input type="text" class="form-control bg-white" id="modified" value="<?php echo (!empty($modified) ? date("d/m/Y H:i:s", strtotime($modified)) : ""); ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="adms_sit_vacancy_id">Situação</label>
                                    <input name="adms_sit_vacancy_id" type="text" class="form-control bg-white" id="adms_sit_vacancy_id" value="<?php echo $status; ?>" readonly />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="update_by">Atualizado Por:</label>
                                    <input name="update_by" type="text" class="form-control bg-white" id="update_by" value="<?php echo (!empty($apelido) ? $apelido : ""); ?>" readonly />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $UrlDestino = URLADM . 'vacancy-opening/list';
    header("Location: $UrlDestino");
}    