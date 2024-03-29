<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_process'][0])) {
    extract($this->Dados['dados_process'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhes do Processo/Política</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_process']) {
                            echo "<a href='" . URLADM . "process-library/list' class='btn btn-outline-info btn-sm' title='Listar'><i class='fa-solid fa-list'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_process']) {
                            echo "<a href='" . URLADM . "edit-process-library/process-library/$p_id' class='btn btn-outline-warning btn-sm' title='Editar'><i class='fa-solid fa-pen-to-square'></i></a> ";
                        }
                        if ($this->Dados['botao']['edit_files']) {
                            echo "<a href='" . URLADM . "edit-process-library-files/edit-files/$p_id' class='btn btn-outline-dark btn-sm' title='Editar Arquivos'><i class='fa-solid fa-file-pen'></i></a> ";
                        }
                        if ($this->Dados['botao']['del_process']) {
                            echo "<a href='" . URLADM . "delete-process-library/process-library/$p_id' class='btn btn-outline-danger btn-sm' title='Apagar' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-eraser'></i></a> ";
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
                            if ($this->Dados['botao']['edit_process']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-process-library/process-library/$p_id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['edit_files']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-process-library-files/edit-files/$p_id'>Editar Arquivos</a>";
                            }
                            if ($this->Dados['botao']['del_process']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-process-library/process-library/$p_id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
            <dl class="row">

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $p_id; ?></dd>

                <dt class="col-sm-3">Título</dt>
                <dd class="col-sm-9"><?php echo $title; ?></dd>

                <dt class="col-sm-3">Categoria</dt>
                <dd class="col-sm-9"><?php echo $name_category; ?></dd>

                <dt class="col-sm-3">Versão</dt>
                <dd class="col-sm-9"><?php echo $version_number; ?></dd>

                <dt class="col-sm-3">Área</dt>
                <dd class="col-sm-9"><?php echo $area; ?></dd>

                <dt class="col-sm-3">Gestor(a) da Área</dt>
                <dd class="col-sm-9"><?php echo $manager_area; ?></dd>

                <dt class="col-sm-3">Setor</dt>
                <dd class="col-sm-9"><?php echo $sector_name; ?></dd>

                <dt class="col-sm-3">Gestor(a) do Setor</dt>
                <dd class="col-sm-9"><?php echo $manager_sector; ?></dd>

                <dt class="col-sm-3">Arquivos</dt>
                <dd class="col-sm-9"><?php
                    foreach ($this->Dados['listFiles'] as $file) {
                        extract($file);
                        echo $exibition_name . "<a href='".URLADM."assets/files/processLibrary/$adms_process_library_id/$file_name_slug' class='text-decoration-none ml-1' download><i class='fa-solid fa-download btn btn-dark'></i></a><br>";
                    }
                    ?>
                </dd>

                <dt class="col-sm-3">Data Inicial</dt>
                <dd class="col-sm-9"><?php echo date("d/m/Y", strtotime($date_validation_start)); ?></dd>

                <dt class="col-sm-3">Data Final</dt>
                <dd class="col-sm-9"><?php echo date("d/m/Y", strtotime($date_validation_end)); ?></dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9"><span class="badge badge-<?php echo $cor; ?>"><?php echo $status; ?></span></dd>

                <dt class="col-sm-3">Cadastrado</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-3">Atualizado</dt>
                <dd class="col-sm-9"><?php
                    if (!empty($modified)) {
                        echo date('d/m/Y H:i:s', strtotime($modified));
                    }
                    ?>
                </dd>
            </dl>
        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Nenhuma Política ou Processo encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $UrlDestino = URLADM . 'process-library/list';
    header("Location: $UrlDestino");
}
