<html>
  <head>
    <link href="../app/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body style="overflow-x:hidden;">
    <div class="row">
      <?php include '../src/menu.php'; ?>
      <div class="col-md-12" style="height:100%;weight:100%;background-color:#f1f2f2;">
        <div style="padding-top:90px;">
          <div class="row">
            <div class="col-md-2">
              <select class="form-control" id="annio">
                <?php
                  $year=date("Y");
                  for ($i=$year+50; $i > date("Y"); $i--) {
                    echo "<option value='".$i."'>".$i."</option>";
                  }
                  echo "<option value='".$year."' selected>".$year."</option>";
                  for ($i=$year-1; $i > 1995; $i--) {
                    echo "<option value='".$i."'>".$i."</option>";
                  }
                 ?>
              </select>
            </div>
            <div class="col-md-2">
              <select class="form-control" id="mes">
                <?php
                  $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                  for ($i=0; $i < sizeof($meses) ; $i++) {
                    echo "<option value='".$i."'>".$meses[$i]."</option>";
                  }

                 ?>
              </select>
            </div>
            <div class="col-md-4">
              <button id="verSA" type="button" class="btn btn-primary">Ver</button>
            </div>
          </div>
          <div class="row">
            <div id="changeValue">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../app/js/jquery-3.1.1.min.js"></script>
    <script src="../app/js/bootstrap.min.js"></script>
    <script src="../app/js/main.js"></script>
  </body>
</html>
