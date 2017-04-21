<html>
  <head>
    <link href="../app/css/bootstrap.min.css" rel="stylesheet">


  </head>
  <body style="overflow-x:hidden;">
    <div class="row">
      <?php include '../src/menu.php'; ?>
      <form enctype="multipart/form-data" action="ver_catalogo.php" method="post" >
        <div class="col-md-12" style="height:100%;weight:100%;background-color:#f1f2f2;">
          <div style="padding-top:90px;">
            <div class="row">
              <div class="col-md-4" style="padding-left:30px;">
                <h3>Desea subir el catalogo</h3>
              </div>
              <div class="col-md-4">
                <label class="form-label span3" for="file">File</label>
	               <input type="file" name="file" id="file" required />
              </div>
              <div class="col-md-2" style="padding-top:20px;">
                <button type="submit" class="btn btn-primary">Subir Excel</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>


    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- <script type="text/javascript" src="../app/js/bootstrap-filestyle.min.js"> </script> -->
    <script src="../app/js/jquery-3.1.1.min.js"></script>
    <script src="../app/js/bootstrap.min.js"></script>
    <script src="../app/js/main.js"></script>
  </body>
</html>
