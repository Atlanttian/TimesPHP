<?php 
	session_start();
	include('db.php');

	// initialize variables
	$nome = "";
	$serie = "";
	$endereco = "";
	$idtime = 0;
	$update = false;

	if (isset($_POST['save-time'])) {

		if(isset($_POST['serie']) && $_POST['nome'] != "" && $_POST['endereco'] != ""){
			$nome = $_POST['nome'];
			$serie = $_POST['serie'];
			$endereco = $_POST['endereco'];

			mysqli_query($db, "INSERT INTO time (nome, serie,  endereco) VALUES ('$nome', '$serie', '$endereco')"); 
			$_SESSION['message'] = "Time Salvo"; 
			header('location: ../../index.php');
		}else{
			$_SESSION['erro'] = true;
			$_SESSION['message'] = "Algum Campo não preenchido"; 
			header('location: ../../index.php');
		}
	} else if (isset($_POST['update-time'])) {
		$idtime = $_POST['idtime'];
		if(isset($_POST['serie']) && $_POST['nome'] != "" && $_POST['endereco'] != ""){
			$nome = $_POST['nome'];
			$serie = $_POST['serie'];
			$endereco = $_POST['endereco'];
		
			mysqli_query($db, "UPDATE time SET nome='$nome', serie='$serie', endereco='$endereco' WHERE idtime=$idtime");
			$_SESSION['message'] = "Time $nome Atualizado!"; 
			header('location: ../../index.php');
		}else{
			$_SESSION['erro'] = true;
			$_SESSION['message'] = "Algum Campo não preenchido"; 
			header('location: ../../index.php?edit_time='.$idtime);
		}
	} else if (isset($_GET['del_time'])) {
		$idtime = $_GET['del_time'];
		mysqli_query($db, "DELETE FROM time WHERE idtime=$idtime");
		$_SESSION['message'] = "Time Excluido!"; 
		header('location: ../../index.php');
	}

	function SelectLimit($limit = 0){
		$select = "SELECT idtime, nome, serie, endereco FROM time";
		if($limit > 0){
			$select .= " limit $limit";
		}
		return $select;
	}

	function Select($id){
		return "SELECT idtime, nome, serie, endereco FROM time WHERE idtime=$id";
	}
