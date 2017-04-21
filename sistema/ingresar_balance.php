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
      $id_catalogo_cuenta="";
      $monto=0;
      $estado=0;
			foreach($rowData[0] as $k=>$v){
        if($countColum<3){
          if (empty($v)) {
            //echo "-----------<br>Esta vacia<br>------------------<br>";
          }else {
            switch ($countColum) {
              case '0':
                $valorDeCatalogo=getIfExistCatalogoCuentas($v);
                if($valorDeCatalogo[0]){
                  $id_catalogo_cuenta=$valorDeCatalogo[1];
                }else {
                  echo " Se encontro un error, la cuenta no existe. fila: ".$row;
                  $flag=0;
                  die();
                }
                break;
              case '1':
                if (is_numeric($v)) {
                  $monto=$v;
                }else {
                  echo " La Monto tiene que ser numerica. fila: ".$row;
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
      //Primero ingresemos el mes y el annio
      $mesAIngresar=$_POST["mes"];
      $annioAIngresar=$_POST["annio"];
      $resultadoDeBalanceMensual=insertBalanceMensual($mesAIngresar,$annioAIngresar);
      if($resultadoDeBalanceMensual[0]){
        //fin
        $id_balance_mensual=$resultadoDeBalanceMensual[1];
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
          $id_catalogo_cuenta="";
          $monto=0;
          foreach($rowData[0] as $k=>$v){
            if($countColum<3){
              if (empty($v)) {
                //echo "-----------<br>Esta vacia<br>------------------<br>";
              }else {
                switch ($countColum) {
                  case '0':
                    $id_catalogo_cuenta=getIfExistCatalogoCuentas($v);
                    $id_catalogo_cuenta=$id_catalogo_cuenta[1];
                    break;
                  case '1':
                    $monto=$v;
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
          if(!empty($id_catalogo_cuenta)){
            if(insertBalanceMensualColumnas($id_balance_mensual,$id_catalogo_cuenta,$monto)){
                $estado=1;
            }else {
              echo "error en la base se quedo hasta:".$row;
              die();
            }
          }
          //$estado=insertCatalogoCuentas($cat_codigo,$cat_nombre,$cat_valorDeTipo,$cat_jerarquia,$cat_cuenta_referencia,$cat_id_caracter);

        }
      }else {
        echo "No se pudo ingresar el balance mensual";
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
