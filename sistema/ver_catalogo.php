<?php

/** Set default timezone (will throw a notice otherwise) */
date_default_timezone_set('Asia/Kolkata');

include '../src/PHPExcel/IOFactory.php';
include '../src/funciones.php';
if(isset($_FILES['file']['name'])){

	$file_name = $_FILES['file']['name'];
	$ext = pathinfo($file_name, PATHINFO_EXTENSION);

	//Checking the file extension
	if($ext == "xls" || $ext == "xlsx"){

			$file_name = $_FILES['file']['tmp_name'];
			$inputFileName = $file_name;

		//  Read your Excel workbook
		try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
		} catch (Exception $e) {
			die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
			. '": ' . $e->getMessage());
		}
		//  Get worksheet dimensions
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

		//  Loop through each row of the worksheet in turn

    //revisar que todo este en orden
		for ($row = 1; $row <= $highestRow; $row++) {
			//  Read a row of data into an array
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
			NULL, TRUE, FALSE);
			//echoing every cell in the selected row for simplicity. You can save the data in database too.
      $flag=1;//todo bien
      $countColum=0;
      $cat_codigo="";
      $cat_nombre="";
      $cat_valorDeTipo=0;
      $cat_jerarquia=0;
      $cat_cuenta_referencia=0;
      $cat_id_caracter=0;
      $estado=0;
			foreach($rowData[0] as $k=>$v){
        if($countColum<6){
          if (empty($v)) {
            //echo "-----------<br>Esta vacia<br>------------------<br>";
          }else {
            switch ($countColum) {
              case '0':
                $cat_codigo=$v;
                break;
              case '1':
                $cat_nombre=$v;
                break;
              case '2':
                $valorDeTipo=getIdIfExistTipo($v);
                if($valorDeTipo[0]){
                  $cat_valorDeTipo=$valorDeTipo[1];
                }else {
                  echo " Se encontro un error en el tipo. fila: ".$row;
                  $flag=0;
                  die();
                }
                break;
              case '3':
                if(is_numeric($v)){
                  $cat_jerarquia=$v;
                }else {
                  echo " La jerarquia tiene que ser numerica. fila: ".$row;
                  $flag=0;
                  die();
                }
                break;
              case '4':
                $cat_cuenta_referencia=$v;
                break;
              case '5':
              $valorDeTipo=getIdIfExistCaracter($v);
                if($valorDeTipo[0]){
                  $cat_id_caracter=$valorDeTipo[1];
                }else {
                  echo " Se encontro un error en el caracter. fila: ".$row;
                  $flag=0;
                  die();
                }
                break;
              default:
                # code...
                break;
            }
          }
        }
        $countColum++;
      }
		}
    if ($flag==1) {
      echo "cargando... <br>";
      //si todo salio bien guardar
      ini_set('max_execution_time', 300); //300 seconds = 5 minutes
      for ($row = 1; $row <= $highestRow; $row++) {
        //  Read a row of data into an array
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
        NULL, TRUE, FALSE);
        //echoing every cell in the selected row for simplicity. You can save the data in database too.
        $flag=1;//todo bien
        $countColum=0;
        $cat_codigo="";
        $cat_nombre="";
        $cat_valorDeTipo=0;
        $cat_jerarquia=0;
        $cat_cuenta_referencia=0;
        $cat_id_caracter=0;
        foreach($rowData[0] as $k=>$v){
          if($countColum<6){
            if (empty($v)) {
              //echo "-----------<br>Esta vacia<br>------------------<br>";
            }else {
              switch ($countColum) {
                case '0':
                  $cat_codigo=$v;
                  break;
                case '1':
                  $cat_nombre=$v;
                  break;
                case '2':
                  $valorDeTipo=getIdIfExistTipo($v);
                  $cat_valorDeTipo=$valorDeTipo[1];
                  break;
                case '3':
                  $cat_jerarquia=$v;
                  break;
                case '4':
                  $cat_cuenta_referencia=$v;
                  break;
                case '5':
                  $valorDeTipo=getIdIfExistCaracter($v);
                  $cat_id_caracter=$valorDeTipo[1];
                  break;
                default:
                  # code...
                  break;
              }
            }
          }
          $countColum++;
        }
        //echo $cat_codigo." ".$cat_nombre." ".$cat_valorDeTipo." ".$cat_jerarquia." ".$cat_cuenta_referencia." ".$cat_id_caracter."<br>";
        if(!empty($cat_codigo)){
          if(insertCatalogoCuentas($cat_codigo,$cat_nombre,$cat_valorDeTipo,$cat_jerarquia,$cat_cuenta_referencia,$cat_id_caracter)){
              $estado=1;
          }else {
            echo "error en la base se quedo hasta:".$row;
            die();
          }
        }
        //$estado=insertCatalogoCuentas($cat_codigo,$cat_nombre,$cat_valorDeTipo,$cat_jerarquia,$cat_cuenta_referencia,$cat_id_caracter);

      }
    }

    if($estado==1){
      echo "El catalogo se subio correctamente";
    }


	}

	else{
		echo '<p style="color:red;">Please upload file with xlsx or xls extension only</p>';
	}

}
?>
