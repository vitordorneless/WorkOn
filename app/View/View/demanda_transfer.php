<?php
session_start();
?>
<div id="refresca_cassi_solicitante">
    <script src="../js/JQuery/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../tools/DataTables/media/css/jquery.dataTables.css">
    <style type="text/css" class="init"></style>
    <script type="text/javascript" language="javascript" src="../../tools/DataTables/media/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="../../tools/DataTables/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function () {
            $('#funcionarios').DataTable({"language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"}});
        });
    </script>    
    <div class="row">
        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header">
                    <h2><strong>Transferir </strong>Demandas para Execução</h2>                    
                    <div class="additional-btn">                        
                        <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>                        
                    </div>                    
                </div>
                <div class="widget-content">                    
                    <br>
                    <div class="table-responsive">
                        <form class='form-horizontal' role='form'>
                            <table id="funcionarios" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Proprietário</th>
                                        <th>Setor</th>                                        
                                        <th>Executante</th>
                                        <th>Demanda</th>
                                        <th>Prazo</th>
                                        <th>Status</th>
                                        <th>&nbsp;</th>
                                        <th>Venc.</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Proprietário</th>
                                        <th>Setor</th>                                        
                                        <th>Executante</th>
                                        <th>Demanda</th>
                                        <th>Prazo</th>
                                        <th>Status</th>                                        
                                        <th>&nbsp;</th>
                                        <th>Venc.</th>
                                        <th>Ação</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    include '../config/database_mysql.php';
                                    $pdo = Database::connect();
                                    function __autoload($file) {
                                        if (file_exists('../Model/' . $file . '.php'))
                                            require_once('../Model/' . $file . '.php');
                                        else
                                            exit('O arquivo ' . $file . ' nÃ£o foi encontrado!');
                                    }
                                    $querie = new Queries();
                                    $user = new Usuarios();
                                    $array_user = $user->Dados_User($_SESSION['user_id']);
                                    $date_default = new DateTime();
                                    $hoje = $date_default->format('Y-m-d');
                                    foreach ($pdo->query($querie->listar_demanda_executante($_SESSION['user_id'])) as $value) {
                                        $qq = $pdo->prepare($querie->listar_criador($value['id_user_abertura']));
                                        $qq->execute();
                                        $data_criador = $qq->fetch(PDO::FETCH_ASSOC);
                                        $qqq = $pdo->prepare($querie->listar_responsavel($value['id_responsavel']));
                                        $qqq->execute();
                                        $data_responsavel = $qqq->fetch(PDO::FETCH_ASSOC);
                                        $qqqq = $pdo->prepare($querie->listar_executante($value['executantes']));
                                        $qqqq->execute();
                                        $data_executante = $qqqq->fetch(PDO::FETCH_ASSOC);
                                        $qqqqq = $pdo->prepare($querie->listar_setores_usuarios($value['id_user_abertura_setor']));
                                        $qqqqq->execute();
                                        $data_setor = $qqqqq->fetch(PDO::FETCH_ASSOC);
                                        $qqqqqq = $pdo->prepare($querie->listar_demanda_list($value['id_demanda']));
                                        $qqqqqq->execute();
                                        $data_demanda = $qqqqqq->fetch(PDO::FETCH_ASSOC);
                                        $qqqqqqq = $pdo->prepare($querie->status_list($value['id_status']));
                                        $qqqqqqq->execute();
                                        $data_status = $qqqqqqq->fetch(PDO::FETCH_ASSOC);
                                        $qqqqqqqq = $pdo->prepare($querie->status_prazo($value['id_prazo']));
                                        $qqqqqqqq->execute();
                                        $data_prazo = $qqqqqqqq->fetch(PDO::FETCH_ASSOC);
                                        $dt_ult_alt = new DateTime($value['data_ultima_alteracao']);
                                        switch ($data_prazo['tipo']) {
                                            case 'horas':
                                                $dt_ult_alt->add(new DateInterval("PT" . $data_prazo['prazo'] . "H"));
                                                $comparador = $dt_ult_alt->format('Y-m-d');
                                                break;
                                            case 'dias':
                                                $dt_ult_alt->add(new DateInterval("P" . $data_prazo['prazo'] . "D"));
                                                $comparador = $dt_ult_alt->format('Y-m-d');
                                                break;
                                            case 'semanas':
                                                $dt_ult_alt->add(new DateInterval("P" . $data_prazo['prazo'] . "W"));
                                                $comparador = $dt_ult_alt->format('Y-m-d');
                                                break;
                                            case 'meses':
                                                $dt_ult_alt->add(new DateInterval("P" . $data_prazo['prazo'] . "M"));
                                                $comparador = $dt_ult_alt->format('Y-m-d');
                                                break;
                                        }
                                        $prazo_demanda = new DateTime($comparador); 
                                        $hooje = new DateTime($hoje);
                                        if ($prazo_demanda < $hooje) {
                                            $semaforo = '<center><i class="fa fa-frown-o"></i></center>';
                                            $aviso = 'Vencida: '.$prazo_demanda->format('d/m/Y');
                                        } else if ($prazo_demanda > $hooje) {
                                            $semaforo = '<center><i class="fa fa-smile-o"></i></center>';
                                            $aviso = 'No Prazo: '.$prazo_demanda->format('d/m/Y');
                                        } else if ($prazo_demanda == $hooje) {
                                            $semaforo = '<center><i class="fa fa-meh-o"></center>';
                                            $aviso = 'Venc. Hoje: '.$prazo_demanda->format('d/m/Y');
                                        }
                                        echo '<tr>';
                                        echo '<td>' . $data_criador['nome_extenso'] . '</td>';
                                        echo '<td>' . $data_setor['setor'] . '</td>';                                        
                                        echo '<td>' . $data_executante['nome_extenso'] . '</td>';
                                        echo '<td>' . $data_demanda['tipo_demanda'] . '</td>';
                                        echo '<td>' . $data_prazo['prazim'] . '</td>';
                                        echo '<td>' . $data_status['status'] . '</td>';
                                        echo '<td>' . $semaforo . '</td>';
                                        echo '<td><small><strong> ' . $aviso . '</strong></small></td>';                                        
                                        echo '<td><a href="demanda_transfer_see.php?id=' . $value['id'] . '" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-dropbox">Transferir Executante <span class="glyphicon glyphicon-save" aria-hidden="true"></span></a></td>';
                                        echo '</tr>';
                                    }
                                    Database::disconnect();
                                    ?>
                                </tbody>
                            </table>
                        </form>
                    </div>                    
                    <div class="modal large" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content"></div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>