<div id="refresca_tst_tipo_agendamento">
    <script src="../js/JQuery/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../tools/DataTables/media/css/jquery.dataTables.css">
    <style type="text/css" class="init"></style>
    <script type="text/javascript" language="javascript" src="../../tools/DataTables/media/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="../../tools/DataTables/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function () {
            $('#funcionarios').DataTable();
        });
    </script>    
    <div class="row">
        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header">
                    <h2><strong>Listar </strong>Envelopes Enviado aos Médicos</h2>
                    <div class="additional-btn">
                        <a href="#" class="hidden reload"><i class="icon-ccw-1"></i></a>
                        <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                        <a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
                    </div>                    
                </div>
                <div class="widget-content">                    
                    <br>
                    <div class="table-responsive">
                        <form class='form-horizontal' role='form'>
                            <table id="funcionarios" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Médico</th>
                                        <th>Protocolo</th>
                                        <th>Envio</th>                                        
                                        <th>Retorno</th>
                                        <th>Forma de Envio</th>                                        
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Médico</th>
                                        <th>Protocolo</th>
                                        <th>Envio</th>                                        
                                        <th>Retorno</th>
                                        <th>Forma de Envio</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    include '../config/database_mysql.php';
                                    include '../../class/ayuadame.php';
                                    $pdo = Database::connect();
                                    $sql = "select id_medico, protocolo, data_envio_loja, id_forma_envio, data_retorno from wal_envelope where status in (1) order by protocolo desc";
                                    foreach ($pdo->query($sql) as $value) {

                                        $sql_unidade = 'select nome_extenso from usuarios where id in (' . $value['id_medico'] . ')';
                                        $qq = $pdo->prepare($sql_unidade);
                                        $qq->execute();
                                        $data = $qq->fetch(PDO::FETCH_ASSOC);                                        
                                        switch ($value['id_forma_envio']) {
                                            case 1:
                                                $envio = 'Correio Comum';
                                                break;
                                            case 2:
                                                $envio = 'Sedex';
                                                break;
                                            case 3:
                                                $envio = 'Carta Registrada';
                                                break;                                            
                                            case 4:
                                                $envio = 'Motoboy';
                                                break;
                                            case 5:
                                                $envio = 'Outros';
                                                break;
                                        }

                                        echo '<tr>';
                                        echo '<td>' . $data['nome_extenso'] . '</td>';
                                        echo '<td>' . $value['protocolo'] . '</td>';
                                        echo '<td>' . transformaEmDataBrasileira($value['data_envio_loja']) . '</td>';
                                        echo '<td>' . transformaEmDataBrasileira($value['data_retorno']) . '</td>';
                                        echo '<td>' . $envio . '</td>';
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
                    <div class="modal large" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content"></div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>