<script src="../js/JQuery/jquery-1.11.1.min.js"></script><!--sempre chamar, com jquery ui o $ajax nÃ£o funciona-->
<script>
    $(document).ready(function () {

        $('#bandeira').change(function () {
            $('#setor').load('../Controller/combo_bandeira_setor.php?bandeira=' + $('#bandeira').val());
        });

        $('#setor').change(function () {
            $('#cargo').load('../Controller/combo_bandeira_cargo_editar.php?setor=' + $('#setor').val() + '&bandeira=' + $('#bandeira').val());
        });

        $("#form").submit(function () {
            return false;
        });
        $("#envia").click(function () {
            $("#conteudo_lateral").empty();
            $("#conteudo_superior").empty();
            envia_form();
        });
        function envia_form() {
            $("#conteudo_periodico").empty();
            var bandeira = $("#bandeira").val();
            var setor = $("#setor").val();
            var cargo = $("#cargo").val();
            
            
            if ($("#bandeira").val() === '0')
            {
                $("#error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(4000),
                        $("#bandeira").focus();
                return false;
            } else {
                $("#error").empty();
            }
            
            if ($("#setor").val() === 'na')
            {
                $("#error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(4000),
                        $("#setor").focus();
                return false;
            } else {
                $("#error").empty();
            }
            
            if ($("#cargo").val() === 'na')
            {
                $("#error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(4000),
                        $("#cargo").focus();
                return false;
            } else {
                $("#error").empty();
            }

            $.ajax({
                type: "POST",
                dataType: "HTML",
                url: "../Controller/definir_riscos_bandeira_editar.php",
                data: "bandeira=" + bandeira + "&setor=" + setor + "&cargo=" + cargo,
                beforeSend: function () {
                    $("#conteudo_periodico").html("<img src='../../images/loading/load.gif' class='img-rounded img-responsive' id='imgpos'>");
                },
                success: function (response) {
                    $("#conteudo_periodico").html(response),
                    $('#exame_clinico').prop("checked", true);
                },
                error: function () {
                    alert("Ocorreu um erro durante a requisição");
                }
            });
        }
    });
</script>
<style type="text/css">
    #imgpos {
        position:absolute;
        left:667px;
    }
</style>
<div class="widget">
    <div class="widget-header transparent">
        <h2><strong>Listar Setores</strong><acronym title="Informe os campos para otimizar o resultado!!!"> Walmart</acronym></h2>
        <div class="additional-btn">            
            <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>            
        </div>
    </div>
    <div class="widget-content padding">
        <div class="form-inline">
            <form id="form" method="POST">
                <div class="form-group">
                    <label>Bandeira:</label>
                    <select class="form-control" id="bandeira" name="bandeira" required autofocus="autofocus">
                        <option selected value="0">
                            Selecione...
                        </option>
                        <?php
                        function __autoload($file) {
                            if (file_exists('../Model/' . $file . '.php'))
                                require_once('../Model/' . $file . '.php');
                            else
                                exit('O arquivo ' . $file . ' não foi encontrado!');
                        }

                        $querie = new Queries();
                        include '../config/database_mysql.php';
                        $pdo = Database::connect();
                        foreach ($pdo->query($querie->listar_bandeiras()) as $value) {
                            echo '<option value="' . $value['id'] . '">' .$value['bandeira'] . '</option>';
                        }
                        Database::disconnect();
                        ?>
                    </select>
                    <div class="form-inline" id="error"></div>
                </div>
                <div class="form-group">
                    <label>Setor(es):</label>
                    <select class="form-control" id="setor" name="setor" required>
                        <option selected value="na">
                            Aguardando...
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Cargo(s):</label>
                    <select class="form-control" id="cargo" name="cargo">
                        <option selected value="na">
                            Aguardando...
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-dropbox" id="envia" type="submit">Editar Riscos e Exames Complementares para este cargo<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
                </div>            
            </form>
        </div>
    </div>        
</div>
<div class="panel panel-footer" id="conteudo_periodico"></div>