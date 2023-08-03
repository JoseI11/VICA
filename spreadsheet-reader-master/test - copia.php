<?php
/**
 * XLS parsing uses php-excel-reader from http://code.google.com/p/php-excel-reader/
 */
	header('Content-Type: text/plain');

	if (isset($argv[1]))
	{
		$Filepath = $argv[1];
	}
	elseif (isset($_GET['File']))
	{
		$Filepath = $_GET['File'];
	}
	else
	{
		if (php_sapi_name() == 'cli')
		{
			echo 'Please specify filename as the first argument'.PHP_EOL;
		}
		else
		{
			echo 'Please specify filename as a HTTP GET parameter "File", e.g., "/test.php?File=test.xlsx"';
		}
		exit;
	}

	// Excel reader from http://code.google.com/p/php-excel-reader/
	require('php-excel-reader/excel_reader2.php');
	require('SpreadsheetReader.php');
	
	date_default_timezone_set('UTC');

	$StartMem = memory_get_usage();
	/*
	echo '---------------------------------'.PHP_EOL;
	echo 'Starting memory: '.$StartMem.PHP_EOL;
	echo '---------------------------------'.PHP_EOL;
	*/
	try
	{
		$Spreadsheet = new SpreadsheetReader($Filepath);
		$BaseMem = memory_get_usage();

		$Sheets = $Spreadsheet -> Sheets();
		/*
		echo '---------------------------------'.PHP_EOL;
		echo 'Spreadsheets:'.PHP_EOL;
		print_r($Sheets);
		echo '---------------------------------'.PHP_EOL;
		echo '---------------------------------'.PHP_EOL;
		*/
		
		
		foreach ($Sheets as $Index => $Name)
		{
			/*
			echo '---------------------------------'.PHP_EOL;
			echo '*** Sheet '.$Name.' ***'.PHP_EOL;
			echo '---------------------------------'.PHP_EOL;
			*/
			$Time = microtime(true);

			$Spreadsheet -> ChangeSheet($Index);
			$entro = 0;
			foreach ($Spreadsheet as $Key => $Row)
			{
				//echo $Key.': ';
				if ($Row)
				{
					
					if ($Row[0] == "Legajo"){
						$legajo = $Row[1];
						$nomape = $Row[3];
						$entro = 1;
					}
					
					
					if ($entro == 2){
						$aux_horario = explode(" ", $horario);
						$horario = $aux_horario[1] . "-" . $aux_horario[3];
						$hdesde = date("H:i", strtotime($aux_horario[1]));
						$hhasta = date("H:i", strtotime($aux_horario[3]));
						
						$to_time = strtotime($aux_horario[1]);
						$from_time = strtotime($aux_horario[3]);
						$neto = round(abs($to_time - $from_time) / 3600,2);
						if ($neto == 16) $neto = 8;
						
						echo "Legajo: " . $legajo . "\n";
						echo "Nombre y Apellido: " . $nomape . "\n";
						echo "Horario: " . $horario . "\n";
						echo "Desde: " . $hdesde . "\n";
						echo "Hasta: " . $hhasta . "\n";
						echo "Tiempo Neto: " . $neto . "\n";
						echo "Fichada: " . $fichada . "\n\n";
						$entro = 0;					
					}
					if ($entro == 1){
						$horario = $Row[2];
						$fichada = $Row[4];
						$entro = 2;
					}
					/*
					for ($p = 0; $p < count($Row); $p++) {
						$r = $Row[$p];
						
						var_dump(htmlspecialchars(utf8_decode($r)));
					}				
					*/	
					
					//print_r($Row);
				}
				else
				{
					//var_dump($Row);
				}
				/*
				$CurrentMem = memory_get_usage();
		
				echo 'Memory: '.($CurrentMem - $BaseMem).' current, '.$CurrentMem.' base'.PHP_EOL;
				echo '---------------------------------'.PHP_EOL;
		
				if ($Key && ($Key % 500 == 0))
				{
					echo '---------------------------------'.PHP_EOL;
					echo 'Time: '.(microtime(true) - $Time);
					echo '---------------------------------'.PHP_EOL;
				}
				*/
			}
			/*
			echo PHP_EOL.'---------------------------------'.PHP_EOL;
			echo 'Time: '.(microtime(true) - $Time);
			echo PHP_EOL;

			echo '---------------------------------'.PHP_EOL;
			echo '*** End of sheet '.$Name.' ***'.PHP_EOL;
			echo '---------------------------------'.PHP_EOL;
			*/
		}
		
	}
	catch (Exception $E)
	{
		echo $E -> getMessage();
	}
?>
