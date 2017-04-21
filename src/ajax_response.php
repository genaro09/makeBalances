<?php
include '../src/funciones.php';
$cod=$_POST["opc"];
switch ($cod) {
  case '1':
    $mes=$_POST["mes"];
    $annio=$_POST["annio"];
    $BMensual=getIsBalanceMensualExist($mes,$annio);
    if ($BMensual[0]==0) {
      $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
      $html='
        <form enctype="multipart/form-data" action="ingresar_balance.php" method="post" >
          <div class="col-md-10" style="height:100%;weight:100%;background-color:#f1f2f2;">
            <div style="padding-top:90px;">
              <div class="row">
                <div class="col-md-12" style="padding-left:30px;">
                  <h3> Mes:'.$meses[$mes].' Año:'.$annio.'</h3>
                </div>
                <div class="col-md-4" style="padding-left:30px;">
                  <h3>Desea ingresar el balance de este mes</h3>
                </div>
                <div class="col-md-4">
                  <label class="form-label span3" for="file">File</label>
                   <input type="file" name="file" id="file" required />
                </div>
                <div class="col-md-2" style="padding-top:20px;">
                  <input type="hidden" name="mes" value="'.$mes.'">
                  <input type="hidden" name="annio" value="'.$annio.'">
                  <input type="hidden" name="idBalanceActual" value="'.$BMensual[1].'">
                  <button type="submit" class="btn btn-primary">Subir Excel</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      ';
      echo "1,".$html;
    }else {
      echo "0, <br><br><div style='margin-left:20px'><h4>Ya Existe el balance de este mes</h4></div>";
    }
    break;

  default:
    echo "error";
    break;
}














 ?>
