<?php 
	session_start();
    $db = mysqli_connect('localhost', 'root', 'rootpassword', 'ProjectVHSYS', '3306');
    
    if(isset($_POST['search']))
    {
        $output = "";

        $nometime = $_POST['nome-time'];
        $serietime = $_POST['serie-time'];
        $enderecotime = $_POST['endereco-time'];
        $nomejogador = $_POST['nome-jogador'];
        $posicaojogador = $_POST['posicao-jogador'];
        $statusjogador = $_POST['status-jogador'];

        $sql = GetSQL($nometime, $serietime, $enderecotime, $nomejogador, $posicaojogador, $statusjogador);

        $results = mysqli_query($db, $sql);
        if(mysqli_num_rows($results) > 0){
            $output .= '<table> <thead> <tr>';
            $output .= '<th>Nome Time</th> <th>Serie</th> <th style="text-align: left;">Endereço</th> <th>Nome Jogador</th> <th>Posição</th> <th>Situação</th>';
            $output .= '</tr> </thead>';
        }
        while ($row = mysqli_fetch_array($results)) {
            $output .= '<tr>';

            $output .= '<td>'.$row['nome_time'].'</td>';
            $output .= '<td>'.$row['serie'].'</td>';
            $output .= '<td>'.$row['endereco'].'</td>';
            $output .= '<td>'.$row['nome_jogador'].'</td>';
            $output .= '<td>'.$row['posicao'].'</td>';
            $output .= '<td>'.$row['status'].'</td>';
            $output .= '</tr>';
        }
        die($output);
    }else if(isset($_POST['excel'])){
        $filename = "webreport.csv";

        $nometime = $_POST['nome-time'];
        $serietime = $_POST['serie-time'];
        $enderecotime = $_POST['endereco-time'];
        $nomejogador = $_POST['nome-jogador'];
        $posicaojogador = $_POST['posicao-jogador'];
        $statusjogador = $_POST['status-jogador'];

        $sql = GetSQL($nometime, $serietime, $enderecotime, $nomejogador, $posicaojogador, $statusjogador);

        $results = mysqli_query($db, $sql);

        header("Content-Type: application/csv");    
        header("Content-Disposition: attachment; filename=$filename");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $sep = ",";
        $resultt = mysqli_query($db, $sql);
        while ($property = mysqli_fetch_field($resultt)) { //fetch table field name
            echo $property->name."\t";
        }

        print("\n");    

        while($row = mysqli_fetch_row($resultt))  //fetch_table_data
        {
            $schema_insert = "";
            for($j=0; $j< mysqli_num_fields($resultt);$j++)
            {
                if(!isset($row[$j]))
                    $schema_insert .= "NULL".$sep;
                elseif ($row[$j] != "")
                    $schema_insert .= (strpos($row[$j], $sep) !== false ? '"'.$row[$j].'"' : $row[$j] ).$sep; //
                else
                    $schema_insert .= "".$sep;
            }
            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
            print "\n";
        }
    }

    function GetSQL($nometime, $serietime, $enderecotime, $nomejogador, $posicaojogador, $statusjogador){
        $sql = "SELECT time.nome as nome_time, time.serie, time.endereco, jogador.nome as nome_jogador, jogador.posicao, jogador.status FROM time LEFT JOIN jogador ON(jogador.idtime = time.idtime) ";
        if($nometime != "" || $serietime != "" || $enderecotime != "" || $nomejogador != "" || $posicaojogador != "" || $statusjogador != ""){
            $hasAnd = false;
            $sql .= "WHERE";

            if($nometime != ""){
                $sql .= ' time.nome like "%$nometime%" ';
                $hasAnd = true;
            }
            if($serietime != ""){
                $sql .= ($hasAnd ? " AND " : "");
                $sql .= " time.serie = $serietime ";
                $hasAnd = true;
            }
            if($enderecotime != ""){
                $sql .= ($hasAnd ? " AND " : "");
                $sql .= ' time.endereco like "%$enderecotime%" ';
                $hasAnd = true;
            }
            if($nomejogador != ""){
                $sql .= ($hasAnd ? " AND " : "");
                $sql .= ' jogador.nome like "%$nomejogador%" ';
                $hasAnd = true;
            }
            if($posicaojogador != ""){
                $sql .= ($hasAnd ? " AND " : "");
                $sql .= " jogador.posicao = $posicaojogador ";
                $hasAnd = true;
            }
            if($statusjogador != ""){
                $sql .= ($hasAnd ? " AND " : "");
                $sql .= " jogador.status = $statusjogador ";
            }
        }
        return $sql;
    }