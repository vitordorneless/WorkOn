<script src="../js/JQuery/jquery-1.11.1.min.js"></script>
<script>
    $(document).ready(function () {        

        $("#form").submit(function () {
            return false;
        });
        $("#envia").click(function () {
            envia_form();
        });
        function envia_form() {
            $("#conteudo_CASSI").empty();
            var data = $("#data").val();
            var data_dmed = $("#data_dmed").val();
            var rppss = $("#rppss").val();
            var cpf_rppss = $("#cpf_rppss").val();
            var brppss = $("#brppss").val();
            var cpf_brppss = $("#cpf_brppss").val();
            var dn = $("#dn").val();
            var valor = $("#valor").val();
            var recibo = $("#recibo").val();

            if ($("#data").val() === '')
            {
                $("#data_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(9000),
                        $("#data").focus();
                return false;
            } else {
                $("#data_error").empty();
            }

            if ($("#data_dmed").val() === '')
            {
                $("#data_dmed_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(9000),
                        $("#data_dmed").focus();
                return false;
            } else {
                $("#data_dmed_error").empty();
            }

            if ($("#rppss").val() === '')
            {
                $("#rppss_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(9000),
                        $("#rppss").focus();
                return false;
            } else {
                $("#rppss_error").empty();
            }

            if ($("#cpf_rppss").val() === '')
            {
                $("#cpf_rppss_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(9000),
                        $("#cpf_rppss").focus();
                return false;
            } else {
                $("#cpf_rppss_error").empty();
            }
            
            if ($("#cpf_rppss").val() === '')
            {
                $("#cpf_rppss_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(9000),
                        $("#cpf_rppss").focus();
                return false;
            } else {
                $("#cpf_rppss_error").empty();
            }
            
            if ($("#brppss").val() === '')
            {
                brppss = "MESMO";
            }
            
            if ($("#cpf_brppss").val() === '')
            {
                cpf_brppss = 0;
            }
            
            if ($("#dn").val() === '')
            {
                dn = 0;
            }
            
            if ($("#valor").val() === '')
            {
                valor = 0;
            }
            
            if ($("#recibo").val() === '')
            {
                recibo = 0;
            }

            $.ajax({
                type: "POST",
                dataType: "HTML",
                url: "../Controller/dmed_incluir.php",
                data: "data=" + data + "&data_dmed=" + data_dmed + "&rppss=" + rppss + "&cpf_rppss=" + cpf_rppss
                        + "&brppss=" + brppss + "&cpf_brppss=" + cpf_brppss + "&dn=" + dn + "&valor=" + valor 
                        + "&recibo=" + recibo,
                beforeSend: function () {
                    $("#conteudo_CASSI").html("<img src='../../images/loading/load.gif' class='img-rounded img-responsive'>");
                },
                success: function (response) {
                    $("#conteudo_CASSI").html(response),
                            $("#form")[0].reset();
                },
                error: function () {
                    alert("Ocorreu um erro durante a requisição");
                }
            });
        }
    });
</script>
<div class="row">
    <div class="widget">
        <div class="widget-header transparent">    
            <h2>Incluir DMED</h2>
            <div class="additional-btn">                
                <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                <a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
            </div>
        </div>			
        <div class="widget-content padding">
            <div id="basic-form">
                <form id="form" method="POST">                                        
                    <div class="form-group">
                        <label for="label_data_cadastro">Data:</label>
                        <input type="date" class="form-control" id="data" name="data">
                        <div class="form-inline" id="data_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="label_data_cadastro">Data DMED:</label>
                        <input type="date" class="form-control" id="data_dmed" name="data_dmed">
                        <div class="form-inline" id="data_dmed_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="label_data_cadastro">RPPSS:</label>
                        <input type="text" class="form-control" id="rppss" name="rppss">
                        <div class="form-inline" id="rppss_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="label_data_cadastro">CPF RPPSS:</label>
                        <input type="text" class="form-control" id="cpf_rppss" name="cpf_rppss">
                        <div class="form-inline" id="cpf_rppss_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="label_data_cadastro">BRPPSS:</label>
                        <input type="text" class="form-control" id="brppss" name="brppss">
                        <div class="form-inline" id="brppss_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="label_data_cadastro">CPF BRPPSS:</label>
                        <input type="text" class="form-control" id="cpf_brppss" name="cpf_brppss">
                        <div class="form-inline" id="cpf_brppss_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="label_data_cadastro">Data Nascimento:</label>
                        <input type="date" class="form-control" id="dn" name="dn">
                        <div class="form-inline" id="dn_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="label_data_cadastro">Valor:</label>
                        <input type="text" class="form-control" id="valor" name="valor" placeholder="Sem pontos ou vírgulas">
                        <div class="form-inline" id="valor_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="label_data_cadastro">Recibo:</label>
                        <input type="text" class="form-control" id="recibo" name="recibo">
                        <div class="form-inline" id="recibo_error"></div>
                    </div>                    
                    <button class="btn btn-primary btn-dropbox pull-right" id="envia" type="submit">Adicionar <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span></button>
                </form>
            </div>
        </div>
    </div>
    <div class="widget">
        <div class="widget-content padding">
            <div id="conteudo_CASSI"></div>
        </div>        
    </div>
</div>