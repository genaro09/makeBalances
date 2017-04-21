<?php
include_once 'cn.php';

function getIdIfExistTipo($nombre_tipo){
  $cnx=cnx();
  $flag=FALSE;
  $id="";
  $query=sprintf("SELECT * FROM cat_tipo where nombre='%s'",mysqli_real_escape_string($cnx,$nombre_tipo));
  $resul=mysqli_query($cnx,$query);
  $row=mysqli_fetch_array($resul);
  if($row[0]!=""){
    $flag=TRUE;
    $id=$row["id_tipo"];
  }
  mysqli_close($cnx);
  return [$flag,$id];
}
function getNombreCuenta($codigo){
    $cnx=cnx();
    $Nombre="No existe la cuenta";
    $query=sprintf("SELECT * FROM cat_catalogo_cuentas where cuenta='%s'",mysqli_real_escape_string($cnx,$codigo));
    $resul=mysqli_query($cnx,$query);
    $row=mysqli_fetch_array($resul);
    if($row[0]!=""){
      $Nombre=$row["nombre_cuenta"];
    }
    mysqli_close($cnx);
    return $Nombre;
}

  function printThisColum($cod,$valorTot,$text){
  echo "<tr>";
  echo "<td>".getNombreCuenta($cod).$text."</td>";
  for ($mes=0; $mes < 12; $mes++) {
    echo "<td>".$valorTot[$mes]."</td>";
  }
  echo "</tr>";
}
function getColumFromCod($codigo,$annio){
  $cnx=cnx();
  $valorMes=0.00;
  $valorAcumulado=0.00;
  $arrayPorMes = array();
  $query=sprintf("SELECT cat_catalogo_cuentas.nombre_cuenta,cat_catalogo_cuentas.cuenta,bl_balance_mensual.annio,bl_balance_mensual.mes,bl_balance_mensual_columnas.monto from cat_catalogo_cuentas INNER JOIN bl_balance_mensual_columnas INNER JOIN bl_balance_mensual WHERE cat_catalogo_cuentas.cuenta='%s' and cat_catalogo_cuentas.id_catalogo_cuenta=bl_balance_mensual_columnas.id_catalogo_cuenta and bl_balance_mensual_columnas.id_balance_mensual=bl_balance_mensual.id_balance_mensual and bl_balance_mensual.annio='%s' ORDER BY bl_balance_mensual.mes ASC",mysqli_real_escape_string($cnx,$codigo),mysqli_real_escape_string($cnx,$annio));
  $resul=mysqli_query($cnx,$query);
  while ($row=mysqli_fetch_array($resul)) {
    # code...
    if($valorAcumulado<1){
      $valorMes=abs($row["monto"]);
    }else {
      $valorMes=abs($row["monto"])-$valorAcumulado;
    }
    $arrayPorMes[$row["mes"]]=$valorMes;
    $valorAcumulado=$valorAcumulado+$valorMes;
  }
  mysqli_close($cnx);
  return $arrayPorMes;
}

function getIdIfExistCaracter($caracter){
  $cnx=cnx();
  $flag=FALSE;
  $id="";
  $query=sprintf("SELECT * FROM cat_caracter where caracter='%s'",mysqli_real_escape_string($cnx,$caracter));
  $resul=mysqli_query($cnx,$query);
  $row=mysqli_fetch_array($resul);
  if($row[0]!=""){
    $flag=TRUE;
    $id=$row["id_caracter"];
  }
  mysqli_close($cnx);
  return [$flag,$id];
}

function insertCatalogoCuentas($cuenta,$nombre_cuenta,$id_tipo,$jerarquia,$cuenta_referencia,$id_caracter){
  $cnx=cnx();
  $query=sprintf("INSERT INTO cat_catalogo_cuentas(cuenta,nombre_cuenta,id_tipo,jerarquia,cuenta_referencia,id_caracter) VALUES ('%s','%s','%s','%s','%s','%s')",
		mysqli_real_escape_string($cnx,$cuenta),
		mysqli_real_escape_string($cnx,$nombre_cuenta),
		mysqli_real_escape_string($cnx,$id_tipo),
		mysqli_real_escape_string($cnx,$jerarquia),
		mysqli_real_escape_string($cnx,$cuenta_referencia),
		mysqli_real_escape_string($cnx,$id_caracter));
  $estado = mysqli_query($cnx,$query);
  mysqli_close($cnx);
  return $estado;
}

function getIsBalanceMensualExist($mes,$annio){
  $cnx=cnx();
  $flag=FALSE;
  $id="";
  $query=sprintf("SELECT * FROM bl_balance_mensual where mes='%s' and annio='%s' ",mysqli_real_escape_string($cnx,$mes),mysqli_real_escape_string($cnx,$annio));
  $resul=mysqli_query($cnx,$query);
  $row=mysqli_fetch_array($resul);
  if($row[0]!=""){
    $flag=TRUE;
    $id=$row["id_balance_mensual"];
  }
  mysqli_close($cnx);
  return [$flag,$id];
}
function insertBalanceMensualColumnas($id_balance_mensual,$id_catalogo_cuenta,$monto){
  $cnx=cnx();
  $query=sprintf("INSERT INTO bl_balance_mensual_columnas(id_balance_mensual,id_catalogo_cuenta,monto) VALUES ('%s','%s','%s')",
		mysqli_real_escape_string($cnx,$id_balance_mensual),
		mysqli_real_escape_string($cnx,$id_catalogo_cuenta),
		mysqli_real_escape_string($cnx,$monto));
  $estado = mysqli_query($cnx,$query);
  mysqli_close($cnx);
  return $estado;
}

function getIfExistCatalogoCuentas($cuenta){
  $cnx=cnx();
  $flag=FALSE;
  $id="";
  $query=sprintf("SELECT * FROM cat_catalogo_cuentas where cuenta='%s' ",mysqli_real_escape_string($cnx,$cuenta));
  $resul=mysqli_query($cnx,$query);
  $row=mysqli_fetch_array($resul);
  if($row[0]!=""){
    $flag=TRUE;
    $id=$row["id_catalogo_cuenta"];
  }
  mysqli_close($cnx);
  return [$flag,$id];
}

function insertBalanceMensual($mes,$annio){
  $cnx=cnx();
  $id="";
  $query=sprintf("INSERT INTO bl_balance_mensual(mes,annio) VALUES ('%s','%s')",
		mysqli_real_escape_string($cnx,$mes),
		mysqli_real_escape_string($cnx,$annio));
  $estado = mysqli_query($cnx,$query);
  if ($estado) {
    $estado=FALSE;
    $query=sprintf("SELECT * FROM bl_balance_mensual where mes='%s' and annio='%s' ",mysqli_real_escape_string($cnx,$mes),mysqli_real_escape_string($cnx,$annio));
    $resul=mysqli_query($cnx,$query);
    $row=mysqli_fetch_array($resul);
    if($row[0]!=""){
      $estado=TRUE;
      $id=$row["id_balance_mensual"];
    }
  }
  mysqli_close($cnx);
  return [$estado,$id];
}
function getTheEquation($Data){
  $arrayResult = array();
  for ($mes=0; $mes < 12; $mes++) {
    $substracT=0;
    for ($i=0; $i < sizeof($Data) ; $i++) {
      if (empty($Data[$i][$mes]))
        $Data[$i][$mes]=0;
      if ($i>0) {
        $substracT=$substracT+abs($Data[$i][$mes]);
      }
    }
    $arrayResult[$mes]=$Data[0][$mes]-$substracT;
  }
  return $arrayResult;
}
function makeTable($NombreTabla,$annio,$Data){
  echo '
  <table id="'.$NombreTabla.'" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size:	12px;">
    <thead>
        <tr>
            <th>Cuenta</th>
            <th>Enero</th>
            <th>Febrero</th>
            <th>Marzo</th>
            <th>Abril</th>
            <th>Mayo</th>
            <th>Junio</th>
            <th>Julio</th>
            <th>Agosto</th>
            <th>Septiembre</th>
            <th>Octubre</th>
            <th>Noviembre</th>
            <th>Diciembre</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
          <th>Cuenta</th>
          <th>Enero</th>
          <th>Febrero</th>
          <th>Marzo</th>
          <th>Abril</th>
          <th>Mayo</th>
          <th>Junio</th>
          <th>Julio</th>
          <th>Agosto</th>
          <th>Septiembre</th>
          <th>Octubre</th>
          <th>Noviembre</th>
          <th>Diciembre</th>
        </tr>
    </tfoot>
    <tbody>
  ';
  for ($i=0; $i < sizeof($Data); $i++) {
    echo "<tr>";
    if($Data[$i][1]==0){
      echo "<td>".$Data[$i][0]."</td>";
    }else {
      echo "<td>".getNombreCuenta($Data[$i][1]).$Data[$i][0]."</td>";
    }
    for ($j=0; $j < sizeof($Data[$i][2]); $j++) {
      echo "<td>".$Data[$i][2][$j]."</td>";
    }
    echo "</tr>";
  }
  echo '
    </tbody>
  </table>
  ';

}

 ?>
