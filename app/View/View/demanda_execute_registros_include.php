<?php
error_reporting(E_ALL);
include '../config/database_mysql.php';
function __autoload($file) {
    if (file_exists('../Model/' . $file . '.php'))
        require_once('../Model/' . $file . '.php');
    else
        exit('O arquivo ' . $file . ' no foi encontrado!');
}
$pdo = Database::connect();
$evento = new Demandas();
$tipo_demanda = new Demandas_Tipos();
$user = new Usuarios();
$querie = new Queries();
$array = $evento->Dados_Demandas(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
$array_user = $user->Dados_User($array['id_user_abertura']);
$array_executante = $user->Dados_User($array['executantes']);
$array_demanda = $tipo_demanda->Dados_Demandas($array['id_demanda']);
?>
<script src="../js/JQuery/jquery-1.11.1.min.js"></script>
<script>
    $(document).ready(function () {

        $("#fechar_modal").click(function () {
            $("#refresca_cassi_solicitante").load('demanda_execute_list.php');
        });

        $(document).on('keydown', function (e) {
            if (e.keyCode === 27) {
                $("#refresca_cassi_solicitante").load('demanda_execute_list.php');
            }
        });        
        $("#form").submit(function () {
            return false;
        });
        $("#envia").click(function () {
            envia_form();
        });
        function envia_form() {
            $("#conteudo_CASSI").empty();
            var id = $("#id").val();
            var id_executante = $("#id_executante").val();
            var copyemail = $("#copyemail").val();
            var status = $("#status").val();            
            var cpf_dependente = $("#cpf_dependente").val();
            var nome_dependente = $("#nome_dependente").val();
            var cpf_dependente1 = $("#cpf_dependente1").val();
            var nome_dependente1 = $("#nome_dependente1").val();
            var cpf_dependente2 = $("#cpf_dependente2").val();
            var nome_dependente2 = $("#nome_dependente2").val();
            var cpf_dependente3 = $("#cpf_dependente3").val();
            var nome_dependente3 = $("#nome_dependente3").val();
            var cpf_dependente4 = $("#cpf_dependente4").val();
            var nome_dependente4 = $("#nome_dependente4").val();
            var cpf_dependente5 = $("#cpf_dependente5").val();
            var nome_dependente5 = $("#nome_dependente5").val();
            var cpf_dependente6 = $("#cpf_dependente6").val();
            var nome_dependente6 = $("#nome_dependente6").val();
            var cpf_dependente7 = $("#cpf_dependente7").val();
            var nome_dependente7 = $("#nome_dependente7").val();
            var cpf_dependente8 = $("#cpf_dependente8").val();
            var nome_dependente8 = $("#nome_dependente8").val();
            var empresa = $("#empresa").val();
            var nome_ativo = $("#nome_ativo").val();
            var cpf_ativo = $("#cpf_ativo").val();            
            var mail1 = $("#mail1").val() === '' ? 'na' : $("#mail1").val();
            var mail2 = $("#mail2").val() === '' ? 'na' : $("#mail2").val();
            var mail3 = $("#mail3").val() === '' ? 'na' : $("#mail3").val();
            var mail4 = $("#mail4").val() === '' ? 'na' : $("#mail4").val();
            var mail5 = $("#mail5").val() === '' ? 'na' : $("#mail5").val();
            var mail6 = $("#mail6").val() === '' ? 'na' : $("#mail6").val();
            var mail7 = $("#mail7").val() === '' ? 'na' : $("#mail7").val();

            if ($("#copyemail").val() === '')
            {
                copyemail = "No Informado";
            }

            if ($("#nome_dependente").val() === '')
            {
                nome_dependente = "No Informado";
            }

            if ($("#cpf_dependente").val() === '')
            {
                cpf_dependente = "00000000000";
            }

            if ($("#nome_dependente1").val() === '')
            {
                nome_dependente1 = "No Informado";
            }

            if ($("#cpf_dependente1").val() === '')
            {
                cpf_dependente1 = "00000000000";
            }

            if ($("#nome_dependente2").val() === '')
            {
                nome_dependente2 = "No Informado";
            }

            if ($("#cpf_dependente2").val() === '')
            {
                cpf_dependente2 = "00000000000";
            }

            if ($("#nome_dependente3").val() === '')
            {
                nome_dependente3 = "No Informado";
            }

            if ($("#cpf_dependente3").val() === '')
            {
                cpf_dependente3 = "00000000000";
            }

            if ($("#nome_dependente4").val() === '')
            {
                nome_dependente4 = "No Informado";
            }

            if ($("#cpf_dependente4").val() === '')
            {
                cpf_dependente4 = "00000000000";
            }

            if ($("#nome_dependente5").val() === '')
            {
                nome_dependente5 = "No Informado";
            }

            if ($("#cpf_dependente5").val() === '')
            {
                cpf_dependente5 = "00000000000";
            }

            if ($("#nome_dependente6").val() === '')
            {
                nome_dependente6 = "No Informado";
            }

            if ($("#cpf_dependente6").val() === '')
            {
                cpf_dependente6 = "00000000000";
            }

            if ($("#nome_dependente7").val() === '')
            {
                nome_dependente7 = "No Informado";
            }

            if ($("#cpf_dependente7").val() === '')
            {
                cpf_dependente7 = "00000000000";
            }

            if ($("#nome_dependente8").val() === '')
            {
                nome_dependente8 = "No Informado";
            }

            if ($("#cpf_dependente8").val() === '')
            {
                cpf_dependente8 = "00000000000";
            }            

            if ($("#empresa").val() === 'na')
            {
                $("#empresa_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>Informe...</div>").hide(90005),
                        $("#empresa").focus();
                return false;
            } else {
                $("#empresa_error").empty();
            }

            if ($("#nome_ativo").val() === '')
            {
                nome_ativo = "No Informado";
            }

            if ($("#cpf_ativo").val() === '')
            {
                cpf_ativo = "00000000000";
            }

            $.ajax({
                type: "POST",
                dataType: "HTML",
                url: "../Controller/demanda_execute_registros_include.php",
                data: "id_executante=" + id_executante + "&copyemail=" + copyemail + "&status=" + status + "&id=" + id +
                        "&cpf_dependente=" + cpf_dependente + "&nome_dependente=" + nome_dependente + "&cpf_dependente1=" + cpf_dependente1 + "&nome_dependente1=" + nome_dependente1 +
                        "&cpf_dependente2=" + cpf_dependente2 + "&nome_dependente2=" + nome_dependente2 + "&cpf_dependente3=" + cpf_dependente3 + "&nome_dependente3=" + nome_dependente3 +
                        "&cpf_dependente4=" + cpf_dependente4 + "&nome_dependente4=" + nome_dependente4 + "&cpf_dependente5=" + cpf_dependente5 + "&nome_dependente5=" + nome_dependente5 +
                        "&cpf_dependente6=" + cpf_dependente6 + "&nome_dependente6=" + nome_dependente6 + "&cpf_dependente7=" + cpf_dependente7 + "&nome_dependente7=" + nome_dependente7 +
                        "&cpf_dependente8=" + cpf_dependente8 + "&nome_dependente8=" + nome_dependente8 +
                        "&mail1=" + mail1 + "&mail2=" + mail2 +
                        "&mail3=" + mail3 + "&mail4=" + mail4 +
                        "&mail5=" + mail5 + "&mail6=" + mail6 +
                        "&mail7=" + mail7 + "&empresa=" + empresa + "&nome_ativo=" + nome_ativo + "&cpf_ativo=" + cpf_ativo,
                beforeSend: function () {
                    $("#conteudo_CASSI").html("<img src='../../images/loading/load.gif' class='img-rounded img-responsive' id='imgpos'>");
                },
                success: function (response) {
                    $("#conteudo_CASSI").html(response),
                    $("#form")[0].reset(),
                    $("#refresca_cassi_solicitante").load('demanda_execute_list.php');
                },
                error: function () {
                    alert("Ocorreu um erro durante a requisio");
                }
            });
        }
    });
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="fechar_modal">&times;</button>
    <h4 class="modal-title">Executar Demanda</h4>
</div>			
<div class="modal-body">
    <form id="form" method="POST">
        <div class="form-group">
            <label for="label_nome_medico">Proprietário:</label>
            <input type="text" class="form-control" value="<?php echo $array_user['nome_extenso']; ?>" disabled="disabled">            
            <input type="hidden" id="id" name="id" value="<?php echo $array['id']; ?>">            
        </div>        
        <div class="form-group">
            <label for="label_nome_medico">Executante:</label>
            <input type="text" class="form-control" value="<?php echo $array_executante['nome_extenso']; ?>" disabled="disabled">
            <input type="hidden" id="id_executante" name="id_executante" value="<?php echo $array_executante['id']; ?>">            
        </div>
        <div class="form-group">
            <label for="label_nome_medico">Demanda:</label>
            <input type="text" class="form-control" value="<?php echo $array_demanda['tipo_demanda']; ?>" disabled="disabled">            
        </div>
        <div class="form-group">
            <label>CPF Associado (ativo): </label>
            <input class="form-control" id="cpf_ativo" name="cpf_ativo" maxlength="11" type="text">
        </div>
        <div class="form-group">
            <label>Nome Associado (ativo): </label>
            <input class="form-control" id="nome_ativo" name="nome_ativo" type="text">
        </div>
        <div class="form-group">
            <label>Empresa: </label>
            <select class="span3" id="empresa" name="empresa" required>
                <option selected value="na" >
                    Selecione...
                </option>
                <?php
                foreach ($pdo->query($querie->demandas_empresas_combo()) as $value) {                    
                    echo '<option value="' . $value['valuess'] . '">' . $value['optionn'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label>CPF Dependente: </label>
            <input class="form-control" id="cpf_dependente" name="cpf_dependente" maxlength="11" type="text"/>
        </div>                    
        <div class="form-group">
            <label>Nome Dependente: </label>
            <input class="form-control" id="nome_dependente" name="nome_dependente" type="text"/>            
        </div>        
        <div class="form-group">
            <label>CPF Dependente: </label>
            <input class="form-control" id="cpf_dependente1" name="cpf_dependente1" maxlength="11" type="text"/>
        </div>                    
        <div class="form-group">
            <label>Nome Dependente: </label>
            <input class="form-control" id="nome_dependente1" name="nome_dependente1" type="text"/>                        
        </div>
        <div class="form-group">
            <label>CPF Dependente: </label>
            <input class="form-control" id="cpf_dependente2" name="cpf_dependente2" maxlength="11" type="text"/>
        </div>                    
        <div class="form-group">
            <label>Nome Dependente: </label>
            <input class="form-control" id="nome_dependente2" name="nome_dependente2" type="text"/>                        
        </div>
        <div class="form-group">
            <label>CPF Dependente: </label>
            <input class="form-control" id="cpf_dependente3" name="cpf_dependente3" maxlength="11" type="text"/>
        </div>                    
        <div class="form-group">
            <label>Nome Dependente: </label>
            <input class="form-control" id="nome_dependente3" name="nome_dependente3" type="text"/>                        
        </div>                        
        <div class="form-group">
            <label>CPF Dependente: </label>
            <input class="form-control" id="cpf_dependente4" name="cpf_dependente4" maxlength="11" type="text"/>
        </div>
        <div class="form-group">
            <label>Nome Dependente: </label>
            <input class="form-control" id="nome_dependente4" name="nome_dependente4" type="text"/>                        
        </div>                

        <div class="form-group">
            <label>CPF Dependente: </label>
            <input class="form-control" id="cpf_dependente5" name="cpf_dependente5" maxlength="11" type="text"/>
        </div>                    
        <div class="form-group">
            <label>Nome Dependente: </label>
            <input class="form-control" id="nome_dependente5" name="nome_dependente5" type="text"/>                        
        </div>            
        <div class="form-group">
            <label>CPF Dependente: </label>
            <input class="form-control" id="cpf_dependente6" name="cpf_dependente6" maxlength="11" type="text"/>
        </div>                    
        <div class="form-group">
            <label>Nome Dependente: </label>
            <input class="form-control" id="nome_dependente6" name="nome_dependente6" type="text"/>                        
        </div>            
        <div class="form-group">
            <label>CPF Dependente: </label>
            <input class="form-control" id="cpf_dependente7" name="cpf_dependente7" maxlength="11" type="text"/>
        </div>                    
        <div class="form-group">
            <label>Nome Dependente: </label>
            <input class="form-control" id="nome_dependente7" name="nome_dependente7" type="text"/>                        
        </div>
        <div class="form-group">
            <label>CPF Dependente: </label>
            <input class="form-control" id="cpf_dependente8" name="cpf_dependente8" maxlength="11" type="text"/>
        </div>
        <div class="form-group">
            <label>Nome Dependente: </label>
            <input class="form-control" id="nome_dependente8" name="nome_dependente8" type="text"/>                        
        </div>                
        <div class="form-group">
            <label for="label_obs">Observações:</label>
            <textarea class="form-control" name="copyemail" id="copyemail" rows="10"><?php echo $array['copy_email']; ?></textarea>
            <div class="form-inline" id="copyemail_error"></div>
        </div>
        <div class="form-group">
            <label>Email: </label>
            <input class="form-control" id="mail1" name="mail1" type="email"/>
        </div>
        <div class="form-group">
            <label>Email: </label>
            <input class="form-control" id="mail2" name="mail2" type="email"/>
        </div>
        <div class="form-group">
            <label>Email: </label>
            <input class="form-control" id="mail3" name="mail3" type="email"/>
        </div>
        <div class="form-group">
            <label>Email: </label>
            <input class="form-control" id="mail4" name="mail4" type="email"/>
        </div>
        <div class="form-group">
            <label>Email: </label>
            <input class="form-control" id="mail5" name="mail5" type="email"/>
        </div>
        <div class="form-group">
            <label>Email: </label>
            <input class="form-control" id="mail6" name="mail6" type="email"/>
        </div>
        <div class="form-group">
            <label>Email: </label>
            <input class="form-control" id="mail7" name="mail7" type="email"/>
        </div>
        <div class="form-group">
            <label for="label_funcao_medico">Status:</label>
            <select class="form-control" id="status" name="status">
                <option value="na">
                    Selecione...
                </option>
                <?php
                foreach ($pdo->query($querie->status_list_all()) as $value) {
                    $option = $value['id'] == $array['id_status'] ? 'value="' . $value['id'] . '" selected' : 'value="' . $value['id'] . '"';
                    echo '<option ' . $option . '>' . $value['status'] . '</option>';
                }
                ?>
            </select>
            <div class="form-inline" id="status_error"></div>
        </div>
<?php Database::disconnect(); ?>
        <button class="btn btn-primary" id="envia" type="submit">Executar Demanda <span class="glyphicon glyphicon-save" aria-hidden="true"></span></button>
    </form>
</div>
<div class="modal-footer">
    <div id="conteudo_CASSI"></div>
</div>