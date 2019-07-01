<?php 
	session_start();
	include('db.php');

	// initialize variables
	$idtime = 0;
	$idjogador = 0;
	$nome = "";
	$posicao = 0;
	$status = null;
	$update = false;

	if (isset($_POST['save-jogador'])) {
		$idtime = $_POST['idtime'];
		if(isset($_POST['posicao']) && $_POST['nome'] != "" && isset($_POST['status'])){
			$nome = $_POST['nome'];
			$posicao = $_POST['posicao'];
			$status = $_POST['status'];

			mysqli_query($db, "INSERT INTO jogador (idtime, nome, posicao, status) VALUES ( $idtime, '$nome', $posicao, $status)"); 
			$_SESSION['message'] = "Jogador Salvo"; 
			header('location: ../../jogador.php?time='.$idtime);
		}else{
			$_SESSION['erro'] = true;
			$_SESSION['message'] = "Algum Campo não preenchido"; 
			header('location: ../../jogador.php?time='.$idtime);
		}
	} else if (isset($_POST['update-jogador'])) {
		$idtime = $_POST['idtime'];
		$idjogador =  $_POST['idjogador'];
		if(isset($_POST['posicao']) && $_POST['nome'] != "" && isset($_POST['status'])){
			$nome = $_POST['nome'];
			$posicao = $_POST['posicao'];
			$status = $_POST['status'];
		
			mysqli_query($db, "UPDATE jogador SET nome='$nome', posicao=$posicao, status=$status WHERE idtime=$idtime and idjogador=$idjogador");
			$_SESSION['message'] = "Jogador $nome Atualizado!"; 
			header('location: ../../jogador.php?time='.$idtime);
		}else{
			$_SESSION['erro'] = true;
			$_SESSION['message'] = "Algum Campo não preenchido"; 
			header('location: .../../jogador.php?time='.$idtime.'edit_jogador='.$idjogador);
		}
	} else if (isset($_GET['time'], $_GET['del_jogador'])) {
		$idtime = $_GET['time'];
		$idjogador = $_GET['del_jogador'];
		mysqli_query($db, "DELETE FROM jogador WHERE idtime=$idtime and idjogador=$idjogador");
		$_SESSION['message'] = "Jogador Excluido!"; 
		header('location: ../../jogador.php?time='.$idtime);
	}

	function SelectLimit($time, $limit = 0){
		$select = "SELECT idtime, idjogador, nome, posicao, status FROM jogador WHERE idtime=$time";
		if($limit > 0){
			$select .= " limit $limit";
		}
		return $select;
	}

	function Select($time, $id){
		return "SELECT idtime, idjogador, nome, posicao, status FROM jogador WHERE idtime=$time and idjogador=$id";
	}
