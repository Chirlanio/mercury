<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
extract($this->Dados['select']);
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item h-100">
        <div class="d-flex"><!-- inicio NavBar -->
            <div class="mr-auto p-2"> 
                <h2 class="display-4 titulo"><?php
                    if ($_SESSION['adms_niveis_acesso_id'] == 5) {
                        $nome = explode(" ", $_SESSION['nome_gerente']);
                        if (!empty($nome[1])) {
                            $prim_nome = $nome[0];
                        } else {
                            $prim_nome = $nome[1];
                        }
                        echo "Bem vinda, " . $prim_nome . " e equipe - " . $_SESSION['nome_loja'];
                    } else {
                        echo "Bem vindo(a), " . $prim_nome;
                    }
                    ?>
                </h2>
            </div>
        </div><!-- Final NavBar -->

        <hr>

        <?php if ($_SESSION['adms_niveis_acesso_id'] <= 3) { ?>

            <div class="row"><!-- Inicio Cards -->
                <div class="col-lg-3 col-sm-6 mb-3"><!-- Inicio Cards Transferência-->
                    <div class="card bg-success text-white anima-left-delay h-100">
                        <a href="<?php echo URLADM . 'transferencia/listar-transf/'; ?>" class="text-white text-decoration-none">
                            <div class="card-body">
                                <i class="fas fa-truck fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['transfer'] as $transfer) {
                                    extract($transfer);
                                    ?>
                                    <h6 class="card-title blockquote">Transferências</h6>
                                    <figcaption class="blockquote-footer text-white">
                                        Total de <cite title="Transferências">transferências</cite> solicitadas.
                                    </figcaption>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;" ><?php echo number_format($transfer, 0, ',', '.'); ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </a>
                    </div>
                </div><!-- Final Cards Transferência-->
                <div class="col-lg-3 col-sm-6 mb-3"><!-- Inicio Cards Ajuste de Estoque-->
                    <div class="card bg-danger text-white anima-left h-100">
                        <a href="<?php
                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                            echo URLADM . 'ajuste/listar-ajuste/';
                        }
                        ?>" class="text-white text-decoration-none">
                            <div class="card-body">
                                <i class="fas fa-retweet fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['ajuste'] as $aju) {
                                    extract($aju);
                                    ?>
                                    <h6 class="card-title blockquote">Ajustes de Estoque</h6>
                                    <figcaption class="blockquote-footer text-white">
                                        Total de <cite title="Ajustes de Estoque">ajustes de estoques</cite> solicitados.
                                    </figcaption>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($ajuste, 0, ",", ".");
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </a>
                    </div>
                </div><!-- Final Cards Ajuste de Estoque-->
                <div class="col-lg-3 col-sm-6 mb-3"><!-- Inicio Cards Usuários-->
                    <div class="card bg-warning text-white anima-right h-100">
                        <a href="<?php echo URLADM . 'users-online/list'; ?>" class="text-white text-decoration-none">
                            <div class="card-body">
                                <i class="fa-solid fa-users fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['usersTotal'] as $user) {
                                    extract($user);
                                    ?>
                                    <h6 class="card-title blockquote">Usuários</h6>
                                    <figcaption class="blockquote-footer text-white">
                                        Total de <cite title="Cadastro - Troca">usuários</cite> cadastrados.
                                    </figcaption>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($troca, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </a>
                    </div>
                </div><!-- Final Cards Usuário-->
                <div class="col-lg-3 col-sm-6 mb-3"><!-- Inicio Cards Dashboards-->
                    <div class="card bg-primary text-white anima-right-delay h-100">
                        <a href="<?php
                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                            echo URLADM . 'dashboard/listar/';
                        }
                        ?>" class="text-white text-decoration-none">
                            <div class="card-body">
                                <i class="fas fa-chart-bar fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['dash'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title blockquote">Dashboard</h6>
                                    <figcaption class="blockquote-footer text-white">
                                        Total de <cite title="Dashboard">dashboards</cite> cadastrados.
                                    </figcaption>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($dash, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </a>
                    </div>
                </div><!-- Final Cards Dashboards-->
            </div>

            <div class="row">
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="card bg-success text-white anima-left-delay h-100">
                        <div class="row">
                            <div class="card-body">
                                <i class="fas fa-dolly fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['agCol'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Coleta</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php echo number_format($agCol, 0, ',', '.'); ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="card-body">
                                <i class="fas fa-shipping-fast fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['emRota'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Em Rota</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php echo number_format($emRota, 0, ',', '.'); ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="card bg-danger text-white anima-left h-100">
                        <div class="row">
                            <div class="card-body">
                                <i class="fas fa-random fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['ajustado'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Ajustado</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($ajustado, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="card-body">
                                <i class="fas fa-stream fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['semAj'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Sem ajuste</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($semAj, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="card bg-warning text-white anima-right h-100">
                        <div class="row">
                            <div class="card-body">
                                <i class="fa-solid fa-user-plus fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['userActive'] as $active) {
                                    extract($active);
                                    ?>
                                    <h6 class="card-title">Ativos</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($active, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="card-body">
                                <i class="fa-solid fa-user-minus fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['userInactive'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Inativos</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($userInactive, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="card bg-primary text-white anima-right-delay h-100">
                        <div class="row">
                            <div class="card-body">
                                <i class="fas fa-chart-pie fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['dashAt'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Ativos</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($dashAt, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="card-body">
                                <i class="fas fa-columns fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['dashPen'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Em Analise</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($dashPen, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="card bg-success text-white anima-left-delay h-100">
                        <div class="card-body">
                            <i class="fas fa-people-carry fa-3x"></i>
                            <?php
                            foreach ($this->Dados['select']['entregue'] as $aj) {
                                extract($aj);
                                ?>
                                <h6 class="card-title">Entregue</h6>
                                <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php echo number_format($entregue, 0, ',', '.'); ?></h2>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="card bg-danger text-white anima-left-delay h-100">
                        <div class="row">
                            <div class="card-body">
                                <i class="fas fa-pause fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['pend'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Pendentes</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($pend, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="card-body">
                                <i class="fas fa-star-of-life fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['emAna'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Em Analise</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($emAna, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="card bg-warning text-white anima-right-delay h-100">
                        <div class="card-body">
                            <i class="fas fa-box fa-3x"></i>
                            <?php
                            foreach ($this->Dados['select']['usersOnline'] as $online) {
                                extract($online);
                                ?>
                                <h6 class="card-title">Usuários Online</h6>
                                <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                    if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                        echo number_format($usersOnline, 0, ',', '.');
                                    } else {
                                        echo "0";
                                    }
                                    ?></h2>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="card bg-primary text-white anima-right-delay h-100">
                        <div class="card-body">
                            <i class="fas fa-chart-bar fa-3x"></i>
                            <?php
                            foreach ($this->Dados['select']['dashIna'] as $aj) {
                                extract($aj);
                                ?>
                                <h6 class="card-title">Inativo</h6>
                                <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                    if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                        echo number_format($dashIna, 0, ',', '.');
                                    } else {
                                        echo "0";
                                    }
                                    ?></h2>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--<hr>
            <div class="content mt-5 anima-bottom">
                <div class="container-fluid">
                    <h2 class="display-4 text-center" style="margin-bottom: 40px;">Agosto Premiado</h2>
                    <div class="row justify-content-md-center">
                        <div class="col-12 col-md-12">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe title="Dashboard - Agosto Premiado" width="1140" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=d90fd021-d0b7-4e3b-884b-f5376c08ce58&autoAuth=true&ctid=ae472a64-42b3-4e2d-8fd3-c6957618b09f&config=eyJjbHVzdGVyVXJsIjoiaHR0cHM6Ly93YWJpLWJyYXppbC1zb3V0aC1yZWRpcmVjdC5hbmFseXNpcy53aW5kb3dzLm5ldC8ifQ%3D%3D" frameborder="0" allowFullScreen="true"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        <?php } else { ?>

            <div class="row mb-3">
                <div class="col-lg-4 col-sm-6">
                    <div class="card bg-success text-white anima-left">
                        <a href="<?php
                        if ($_SESSION['adms_niveis_acesso_id'] <= 5) {
                            echo URLADM . 'transferencia/listar-transf/';
                        } else {
                            echo "#";
                        }
                        ?>" class="text-white text-decoration-none">
                            <div class="card-body">
                                <i class="fas fa-truck fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['transf'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title blockquote">Transferências</h6>
                                    <figcaption class="blockquote-footer text-white">
                                        Total de <cite title="Transferências">transferências</cite> solicitadas.
                                    </figcaption>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;">
                                        <?php echo number_format($transf, 0, ',', '.'); ?>
                                    </h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card bg-danger text-white anima-bottom h-100">
                        <a href="<?php
                        if ($_SESSION['adms_niveis_acesso_id'] <= 5) {
                            echo URLADM . 'ajuste/listar-ajuste/';
                        } else {
                            echo '#';
                        }
                        ?>" class="text-white text-decoration-none">
                            <div class="card-body">
                                <i class="fas fa-retweet fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['ajuste'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title blockquote">Ajustes de Estoque</h6>
                                    <figcaption class="blockquote-footer text-white">
                                        Total de <cite title="Ajustes de Estoque">ajustes de estoques</cite> solicitados.
                                    </figcaption> 
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($ajuste, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card bg-warning text-white anima-right h-100">
                        <a href="<?php
                        if ($_SESSION['adms_niveis_acesso_id'] <= 5) {
                            echo URLADM . 'listar-troca/listar-troca/';
                        } else {
                            echo "#";
                        }
                        ?>" class="text-white text-decoration-none">
                            <div class="card-body">
                                <i class="fas fa-boxes fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['troca'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title blockquote">Cadastro - Troca</h6>
                                    <figcaption class="blockquote-footer text-white">
                                        Total de <cite title="Cadastro - Troca">cadastro de produtos</cite> solicitados.
                                    </figcaption>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($troca, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6 mb-3">
                    <div class="card bg-success text-white anima-left h-100">
                        <div class="row">
                            <div class="card-body">
                                <i class="fas fa-dolly fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['agCol'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Coleta</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php echo number_format($agCol, 0, ',', '.'); ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="card-body">
                                <i class="fas fa-shipping-fast fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['emRota'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Em Rota</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php echo number_format($emRota, 0, ',', '.'); ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-3">
                    <div class="card bg-danger text-white anima-bottom h-100">
                        <div class="row">
                            <div class="card-body">
                                <i class="fas fa-random fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['ajustado'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Ajustado</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($ajustado, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="card-body">
                                <i class="fas fa-stream fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['semAj'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Sem ajuste</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($semAj, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-3">
                    <div class="card bg-warning text-white anima-right h-100">
                        <div class="row">
                            <div class="card-body">
                                <i class="fas fa-box-open fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['cad'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Cadastrado</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($cad, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="card-body">
                                <i class="fas fa-archive fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['jaCad'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Já Cadastrado</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($jaCad, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6 mb-3">
                    <div class="card bg-success text-white anima-left h-100">
                        <div class="card-body">
                            <i class="fas fa-people-carry fa-3x"></i>
                            <?php
                            foreach ($this->Dados['select']['entregue'] as $aj) {
                                extract($aj);
                                ?>
                                <h6 class="card-title">Entregue</h6>
                                <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php echo number_format($entregue, 0, ',', '.'); ?></h2>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-3">
                    <div class="card bg-danger text-white anima-bottom h-100">
                        <div class="row">
                            <div class="card-body">
                                <i class="fas fa-pause fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['pend'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Pendentes</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($pend, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="card-body">
                                <i class="fas fa-star-of-life fa-3x"></i>
                                <?php
                                foreach ($this->Dados['select']['emAna'] as $aj) {
                                    extract($aj);
                                    ?>
                                    <h6 class="card-title">Em Analise</h6>
                                    <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                        if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                            echo number_format($emAna, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?></h2>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-3">
                    <div class="card bg-warning text-white anima-right h-100">
                        <div class="card-body">
                            <i class="fas fa-box fa-3x"></i>
                            <?php
                            foreach ($this->Dados['select']['cadPend'] as $aj) {
                                extract($aj);
                                ?>
                                <h6 class="card-title">Pendentes</h6>
                                <h2 class="lead text-right mt-4" style="font-size: 30px !important;"><?php
                                    if ($_SESSION['adms_niveis_acesso_id'] != 6) {
                                        echo number_format($cadPend, 0, ',', '.');
                                    } else {
                                        echo "0";
                                    }
                                    ?></h2>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--<hr>
            <div class="content mt-5 anima-bottom">
                <div class="container-fluid">
                    <h2 class="display-4 text-center" style="margin-bottom: 40px;">Agosto Premiado</h2>
                    <div class="row justify-content-md-center">
                        <div class="col-12 col-md-12">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe title="Dashboard - Agosto Premiado" width="1140" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=d90fd021-d0b7-4e3b-884b-f5376c08ce58&autoAuth=true&ctid=ae472a64-42b3-4e2d-8fd3-c6957618b09f&config=eyJjbHVzdGVyVXJsIjoiaHR0cHM6Ly93YWJpLWJyYXppbC1zb3V0aC1yZWRpcmVjdC5hbmFseXNpcy53aW5kb3dzLm5ldC8ifQ%3D%3D" frameborder="0" allowFullScreen="true"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
    <?php }
    ?>
</div>
</div>