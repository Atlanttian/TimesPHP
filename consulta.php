<?php  include('server/consultas.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Consultas</title>
    <link rel="stylesheet" type="text/css" href="/src/css.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("form").submit(function(e) { 
                var val = $("button[type=submit][clicked=true]").val();
                if(val == "search"){
                    e.preventDefault();
                    var ser = $('form').serialize() + "&" + val;
                    $.ajax({
                        type: 'post',
                        url: 'server/consultas.php',
                        data: ser,
                        success: function (data) {
                            $("#data").html(data);
                        }
                    });
                }
            });
            $("form button[type=submit]").click(function() {
                $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
                $(this).attr("clicked", "true");
            });
        });
      
    </script>
</head>
<body>
    <div>
        <a href="index.php" class="nav">Times</a>
    </div>
    <form style="text-align:center;" method="post" action="server/consultas.php">
        <div class="form search">
        <label style="text-align: center;">Time</label>
            <div class="input-group">
                <label>Nome</label>
                <input type="text" name="nome-time" maxlength="100">
            </div>
            <div class="input-group">
                <label>Serie</label>
                <select name="serie-time" >
                    <option value="" selected> Selecione </option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                </select>
            </div>
            <div class="input-group">
                <label>Endereço</label>
                <input type="text" name="endereco-time" maxlength="150">
            </div>
        </div>
        <div class="form search">
            <label style="text-align: center;">Jogador</label>
            <div class="input-group">
                <label>Nome</label>
                <input type="text" name="nome-jogador" maxlength="100">
            </div>
            <div class="input-group">
                <label>Posicao</label>
                <select name="posicao-jogador" >
                    <option value="" selected> Selecione </option>
                    <option value=1>Atacante</option>
                    <option value=2>Goleiro</option>
                    <option value=3>Meio de Campo</option>
                    <option value=4>Zagueiro</option>
                </select>
            </div>
            <div class="input-group">
                <label>Situacao</label>
                <select name="status-jogador" >
                    <option value="" selected> Selecione </option>
                    <option value=0>Principal</option>
                    <option value=1>Reserva</option>
                </select>
            </div>
        </div>
        <div class="input-group">
            <button class="btn" type="submit" value="search" name="search" style="background: #556B2F;" >Pesquisar</button>
            <button class="btn" type="submit" value="excel" name="excel" style="background: #556B2F;" >Excel</button>
        </div>
    </form>
    <div id="data">
    </div>
</body>
</html>