<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 mb-4 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Usuários Online</h2>
            </div>
        </div>
        <hr>
        <?php
        if (empty($this->Dados['listUserOnline'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum usuário encontrado!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
        }
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="d-none d-sm-table-cell">E-mail</th>
                        <th class="d-none d-sm-table-cell">Loja</th>
                        <th class="d-none d-sm-table-cell">Data</th>
                        <th class="d-none d-sm-table-cell">Acessou</th>
                        <th class="d-none d-lg-table-cell text-center">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listUserOnline'] as $userOnline) {
                        extract($userOnline);
                        ?>
                        <tr>
                            <td class="align-middle"><?php echo $nome; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $email; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo $store; ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo date("d/m/Y", strtotime($adms_date_access)); ?></td>
                            <td class="d-none d-sm-table-cell align-middle"><?php echo date("H:i:s", strtotime($adms_hours_access)); ?></td>
                            <td class="d-none d-lg-table-cell align-middle text-center">
                                <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $name_sit; ?></span>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['logout']) {
                                        echo "<a href='" . URLADM . "login/logout/$adms_user_id' class='btn btn-outline-dark btn-sm' title='Sair'><i class='fa-solid fa-right-from-bracket'></i></a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['logout']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "login/logout/$adms_user_id'>Logout</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
            echo $this->Dados['pagination'];
            ?>
        </div>
    </div>
</div>
