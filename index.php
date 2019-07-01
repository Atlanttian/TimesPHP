<?php  include('server/times.php'); ?>
<!DOCTYPE html>
<?php 
    if (isset($_GET['edit_time'])){
		$idtime = $_GET['edit_time'];
		$update = true;
		$record = mysqli_query($db, Select($idtime));

        if (mysqli_num_rows($record) == 1 ) {
			$n = mysqli_fetch_array($record);
            $nome = $n['nome'];
            $serie = $n['serie'];
			$endereco = $n['endereco'];
		}
	}
?>
<html>
<head>
	<title>Times</title>
    <link rel="stylesheet" type="text/css" href="/src/css.css">
</head>
<body>
    <div>
        <a href="consulta.php" class="nav">Consulta</a>
    </div>
    <?php if (isset($_SESSION['message'])): ?>
        <?php $isError = isset($_SESSION['erro']); ?>
        <div class="<?php echo ($isError ? "erro" : "ok") ?>">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
                if(isset($_SESSION['erro'])){
                    unset($_SESSION['erro']);
                }
            ?>
        </div>
    <?php endif ?>

    <form class="form" method="post" action="server/times.php" >
        <input type="hidden" name="idtime" value="<?php echo $idtime; ?>">
		<div class="input-group">
			<label>Nome</label>
			<input type="text" name="nome" value="<?php echo $nome ?>" maxlength="100">
		</div>
        <div class="input-group">
			<label>Serie</label>
			<select name="serie" >
                <option value="" value="" <?=$serie == "" ? ' selected' : '';?> disabled hidden> Selecione </option>
                <option value="A" <?=$serie == "A" ? ' selected' : '';?>>A</option>
                <option value="B" <?=$serie == "B" ? ' selected' : '';?>>B</option>
                <option value="C" <?=$serie == "C" ? ' selected' : '';?>>C</option>
            </select>
		</div>
		<div class="input-group">
			<label>Endereço</label>
			<input type="text" name="endereco" value="<?php echo $endereco ?>" maxlength="150">
		</div>
		<div class="input-group">
            <?php if ($update == true): ?>
                <button class="btn" type="submit" name="update-time" style="background: #556B2F;" >Atualizar</button>
            <?php else: ?>
                <button class="btn" type="submit" name="save-time" >Salvar</button>
            <?php endif ?>
		</div>
	</form>

    <?php $results = mysqli_query($db, SelectLimit());?>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Serie</th>
                <th style="text-align: left;">Endereço</th>
                <th colspan="3">Ações</th>
            </tr>
        </thead>
        
        <?php while ($row = mysqli_fetch_array($results)) { ?>
            <tr>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['serie']; ?></td>
                <td style="text-align: left;"><?php echo $row['endereco']; ?></td>
                <td style="width:60px;">
                    <a href="index.php?edit_time=<?php echo $row['idtime']; ?>" class="edit_btn" >Editar</a>
                </td>
                <td style="width:90px;">
                    <a href="jogador.php?time=<?php echo $row['idtime']; ?>" class="jogador_btn" >Jogadores</a>
                </td>
                <td style="width:70px;">
                    <a href="server/times.php?del_time=<?php echo $row['idtime']; ?>" class="del_btn">Deletar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>