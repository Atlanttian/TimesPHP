<?php  include('server/jogadores.php'); ?>
<!DOCTYPE html>
<?php 
    if (isset($_GET['time'])){
        $idtime = $_GET['time'];
    }else {
        $_SESSION['erro'] = true;
        $_SESSION['message'] = "Não foi possivel acessar os jogadores, tente novamente!"; 
        header('location: index.php');
        die();
    }
    if (isset($_GET['edit_jogador'])){
        $idjogador = $_GET['edit_jogador'];
		$update = true;
		$record = mysqli_query($db, Select($idtime, $idjogador));

        if (mysqli_num_rows($record) == 1 ) {
            $n = mysqli_fetch_array($record);
            $nome = $n['nome'];
            $posicao = $n['posicao'];
			$status = $n['status'];
		}
	}
?>
<html>
<head>
	<title>Jogadores</title>
    <link rel="stylesheet" type="text/css" href="/src/css.css">
</head>
<body>
    <div>
        <a href="index.php" class="nav">Times</a>
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

    <form class="form" method="post" action="server/jogadores.php" >
        <input type="hidden" name="idtime" value="<?php echo $idtime; ?>">
        <input type="hidden" name="idjogador" value="<?php echo $idjogador; ?>">
		<div class="input-group">
			<label>Nome</label>
			<input type="text" name="nome" value="<?php echo $nome ?>" maxlength="100">
		</div>
        <div class="input-group">
			<label>Posicao</label>
			<select name="posicao" >
                <option value=0 <?=$posicao == 0 ? ' selected' : '';?> disabled hidden> Selecione </option>
                <option value=1 <?=$posicao == 1 ? ' selected' : '';?>>Atacante</option>
                <option value=2 <?=$posicao == 2 ? ' selected' : '';?>>Goleiro</option>
                <option value=3 <?=$posicao == 3 ? ' selected' : '';?>>Meio de Campo</option>
                <option value=4 <?=$posicao == 4 ? ' selected' : '';?>>Zagueiro</option>
            </select>
		</div>
        <div class="input-group">
			<label>Situacao</label>
			<select name="status" >
                <option value="null" <?=$status == null ? ' selected' : '';?> disabled hidden> Selecione </option>
                <option value=0 <?=$status == 0 ? ' selected' : '';?>>Principal</option>
                <option value=1 <?=$status == 1 ? ' selected' : '';?>>Reserva</option>
            </select>
		</div>
		<div class="input-group">
            <?php if ($update == true): ?>
                <button class="btn" type="submit" name="update-jogador" style="background: #556B2F;" >Atualizar</button>
            <?php else: ?>
                <button class="btn" type="submit" name="save-jogador" >Salvar</button>
            <?php endif ?>
		</div>
	</form>

    <?php $results = mysqli_query($db, SelectLimit($idtime));?>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Posicao</th>
                <th>Situacao</th>
                <th colspan="2">Ações</th>
            </tr>
        </thead>
        
        <?php while ($row = mysqli_fetch_array($results)) { ?>
            <tr>
                <td><?php echo $row['nome']; ?></td>
                <td>
                    <?php 
                        if($row['posicao'] == 1){
                            echo "Atacante";
                        }else if($row['posicao'] == 2){
                            echo "Goleiro";
                        }else if($row['posicao'] == 3){
                            echo "Meio de Campo";
                        }else if($row['posicao'] == 4){
                            echo "Zagueiro";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        if($row['status'] == 0){
                            echo "Principal";
                        }else if($row['status'] == 1){
                            echo "Reserva";
                        }
                    ?>
                </td>
                <td style="width:60px;">
                    <a href="jogador.php?time=<?php echo $row['idtime']; ?>&edit_jogador=<?php echo $row['idjogador']; ?>" class="edit_btn" >Editar</a>
                </td>
                <td style="width:70px;">
                    <a href="server/jogadores.php?time=<?php echo $row['idtime']; ?>&del_jogador=<?php echo $row['idjogador']; ?>" class="del_btn">Deletar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>