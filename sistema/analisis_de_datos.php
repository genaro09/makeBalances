<html>
  <head>
    <link href="../app/css/bootstrap.min.css" rel="stylesheet">
    <link href="../app/css/dataTables.bootstrap.min.css" rel="stylesheet">

  </head>
  <body style="width:100%;">
    <div class="row">
      <?php include '../src/menu.php'; ?>
      <?php include '../src/funciones.php'; ?>
      <div class="col-md-12" style="margin-left:10px;background-color:#f1f2f2;">
        <div style="padding-top:40px;">
          <div class="row" style="padding:2%;">
            <div class="col-md-12">
              <h1>Analisis de los datos</h1>
            </div>
            <br>
            <br>
            <br>
            <br>
            <?php
                      $annio="2017";
                      $codHC="4101-0100-01";
                      $cod1HC="4103-0100-01";
                      $cod2HC="4104-0100-00";
                      //esto no se esta revisando si existe el codigo
                      $arregloCodHC=getColumFromCod($codHC,$annio);
                      $arregloCodHC2=getColumFromCod($cod1HC,$annio);
                      $arregloCodHC3=getColumFromCod($cod2HC,$annio);
                      $valorTotHC=getTheEquation(array($arregloCodHC,$arregloCodHC2,$arregloCodHC3));
                      $codMM="4101-0100-02";
                      $codMM1="4103-0100-02";
                      $codMM2="4104-0200-00";
                      //esto no se esta revisando si existe el codigo
                      $arregloCodMM=getColumFromCod($codMM,$annio);
                      $arregloCodMM2=getColumFromCod($codMM1,$annio);
                      $arregloCodMM3=getColumFromCod($codMM2,$annio);
                      $valorTotMM=getTheEquation(array($arregloCodMM,$arregloCodMM2,$arregloCodMM3));
                      $codMA="4101-0100-03";
                      $codMA1="4103-0100-03";
                      $codMA2="4103-0300-00";
                      //esto no se esta revisando si existe el codigo
                      $arregloCodMA=getColumFromCod($codMA,$annio);
                      $arregloCodMA2=getColumFromCod($codMA1,$annio);
                      $arregloCodMA3=getColumFromCod($codMA2,$annio);
                      $valorTotMA=getTheEquation(array($arregloCodMA,$arregloCodMA2,$arregloCodMA3));
                      $codMPM="4101-0100-04";
                      $codMPM1="4103-0100-04";
                      $codMPM2="4103-0400-00";
                      //esto no se esta revisando si existe el codigo
                      $arregloCodMPM=getColumFromCod($codMPM,$annio);
                      $arregloCodMPM2=getColumFromCod($codMPM1,$annio);
                      $arregloCodMPM3=getColumFromCod($codMPM2,$annio);
                      $valorTotMPM=getTheEquation(array($arregloCodMPM,$arregloCodMPM2,$arregloCodMPM3));
                      $codOI="4300-0000-00";
                      //esto no se esta revisando si existe el codigo
                      $arregloCodOI=getColumFromCod($codOI,$annio);
                      $valorTotOI=getTheEquation(array($arregloCodOI));
                      //a imprimir todas las columnas
                      //Make the total
                      $TotalVN = array();
                      //echo "<tr><td>Total</td>";
                      $TotDeVN=0.00;
                      for ($mes=0; $mes < 12; $mes++) {
                        $TotalVN[$mes]=$valorTotHC[$mes]+$valorTotMM[$mes]+$valorTotMA[$mes]+$valorTotMPM[$mes]+$valorTotOI[$mes];
                        $TotDeVN=$TotDeVN+$TotalVN[$mes];
                        //echo "<td>".$TotalVN[$mes]."</td>";
                      }

                      //Habana Cigar
                      $codCDOHC="5101-0100-01";
                      //esto no se esta revisando si existe el codigo
                      $arregloCDVHC=getColumFromCod($codCDOHC,$annio);
                      $valorTotCDVHC=getTheEquation(array($arregloCDVHC));
                      //Multiplaza
                      $codCDOMM="5101-0200-02";
                      //esto no se esta revisando si existe el codigo
                      $arregloCDOMM=getColumFromCod($codCDOMM,$annio);
                      $valorTotCDOMM=getTheEquation(array($arregloCDOMM));
                      //Aeropuerto
                      $codCDOMA="5101-0300-03";
                      //esto no se esta revisando si existe el codigo
                      $arregloCDOMA=getColumFromCod($codCDOMA,$annio);
                      $valorTotCDOMA=getTheEquation(array($arregloCDOMA));
                      //Plaza Madrid
                      $codCDOMPM="5101-0400-04";
                      //esto no se esta revisando si existe el codigo
                      $arregloCDOMPM=getColumFromCod($codCDOMPM,$annio);
                      $valorTotCDOMPM=getTheEquation(array($arregloCDOMPM));

                      //Para ir a imprimir
                      for ($mes=0; $mes < 12; $mes++) {
                        //agregando los demas detalles
                        $valorTotHC[$mes]=$valorTotHC[$mes]."<br><p style='font-size:10px'>%".number_format((float)(($valorTotHC[$mes]/$TotalVN[$mes])*100), 2, '.', '')."</p>";
                        $valorTotMM[$mes]=$valorTotMM[$mes]."<br><p style='font-size:10px'>%".number_format((float)(($valorTotMM[$mes]/$TotalVN[$mes])*100), 2, '.', '')."</p>";
                        $valorTotMA[$mes]=$valorTotMA[$mes]."<br><p style='font-size:10px'>%".number_format((float)(($valorTotMA[$mes]/$TotalVN[$mes])*100), 2, '.', '')."</p>";
                        $valorTotMPM[$mes]=$valorTotMPM[$mes]."<br><p style='font-size:10px'>%".number_format((float)(($valorTotMPM[$mes]/$TotalVN[$mes])*100), 2, '.', '')."</p>";
                        $valorTotOI[$mes]=$valorTotOI[$mes]."<br><p style='font-size:10px'>%".number_format((float)(($valorTotOI[$mes]/$TotalVN[$mes])*100), 2, '.', '')."</p>";
                        $valorTotHC[$mes]=$valorTotHC[$mes]."<p style='font-size:10px'>%".number_format((float)(($valorTotHC[$mes]/$TotDeVN)*100), 2, '.', '')."</p>";
                        $valorTotMM[$mes]=$valorTotMM[$mes]."<p style='font-size:10px'>%".number_format((float)(($valorTotMM[$mes]/$TotDeVN)*100), 2, '.', '')."</p>";
                        $valorTotMA[$mes]=$valorTotMA[$mes]."<p style='font-size:10px'>%".number_format((float)(($valorTotMA[$mes]/$TotDeVN)*100), 2, '.', '')."</p>";
                        $valorTotMPM[$mes]=$valorTotMPM[$mes]."<p style='font-size:10px'>%".number_format((float)(($valorTotMPM[$mes]/$TotDeVN)*100), 2, '.', '')."</p>";
                        $valorTotOI[$mes]=$valorTotOI[$mes]."<p style='font-size:10px'>%".number_format((float)(($valorTotOI[$mes]/$TotDeVN)*100), 2, '.', '')."</p>";
                      }
                      $Data = array();
                      $textAux="
                      <br><p style='font-size:9px'>%sobre total ingreso mensual</p>
                      <p style='font-size:9px'>%sobre total ingreso anual</p>
                      ";
                      $Data[0]=array("Total","0",$TotalVN);//No tiene nombre de cuenta
                      $Data[1]=array($textAux,$codHC,$valorTotHC);
                      $Data[2]=array($textAux,$codMM,$valorTotMM);
                      $Data[3]=array($textAux,$codMA,$valorTotMA);
                      $Data[4]=array($textAux,$codMPM,$valorTotMPM);
                      $Data[5]=array($textAux,$codOI,$valorTotOI);

                      echo '
                      <div class="col-md-12">
                        <h4>Analisis de los ingresos</h4>
                      ';
                      makeTable("example",$annio,$Data);
                      echo '
                        <div class="row" style="height:50px;">
                        </div>
                      </div>
                      ';
                      //a imprimir todas las columnas
                      //Make the total
                      $TotalCDO = array();
                      for ($mes=0; $mes < 12; $mes++) {
                        $TotalCDO[$mes]=$valorTotCDVHC[$mes]+$valorTotCDOMM[$mes]+$valorTotCDOMA[$mes]+$valorTotCDOMPM[$mes];
                        //agregando los demas detalles
                        $valorTotCDVHC[$mes]=$valorTotCDVHC[$mes]."<br><p style='font-size:10px'>%".number_format((float)(($valorTotCDVHC[$mes]/$TotalCDO[$mes])*100), 2, '.', '')."</p>";
                        $valorTotCDOMM[$mes]=$valorTotCDOMM[$mes]."<br><p style='font-size:10px'>%".number_format((float)(($valorTotCDOMM[$mes]/$TotalCDO[$mes])*100), 2, '.', '')."</p>";
                        $valorTotCDOMA[$mes]=$valorTotCDOMA[$mes]."<br><p style='font-size:10px'>%".number_format((float)(($valorTotCDOMA[$mes]/$TotalCDO[$mes])*100), 2, '.', '')."</p>";
                        $valorTotCDOMPM[$mes]=$valorTotCDOMPM[$mes]."<br><p style='font-size:10px'>%".number_format((float)(($valorTotCDOMPM[$mes]/$TotalCDO[$mes])*100), 2, '.', '')."</p>";
                      }
                      $Data = array();
                      $textAux="
                      <br><p style='font-size:9px'>%sobre el total de costos</p>
                      ";
                      $Data[0]=array("Total","0",$TotalCDO);//No tiene nombre de cuenta
                      $Data[1]=array($textAux,$codCDOHC,$valorTotCDVHC);
                      $Data[2]=array($textAux,$codCDOMM,$valorTotCDOMM);
                      $Data[3]=array($textAux,$codCDOMA,$valorTotCDOMA);
                      $Data[4]=array($textAux,$codCDOMPM,$valorTotCDOMPM);
                      echo '
                      <div class="col-md-12">
                        <h4>Analisis de costos de venta</h4>
                      ';
                      makeTable("example2",$annio,$Data);
                      echo '
                        <div class="row" style="height:50px;">
                        </div>
                      </div>
                      ';


                     ?>
            </div>

          </div>
        </div>
      </div>
    </div>


    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../app/js/jquery-3.1.1.min.js"></script>
    <script src="../app/js/bootstrap.min.js"></script>

    <script src="../app/js/jquery.dataTables.min.js"></script>
    <script src="../app/js/dataTables.bootstrap.min.js"></script>
    <script src="../app/js/main.js"></script>
    <script>
    $(document).ready(function() {
      $('#example').DataTable();
      $('#example2').DataTable();
    } );
    </script>
  </body>
</html>
