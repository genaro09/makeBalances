$(document).ready(function() {
  $("#verSA").click(function(){
    var annio = $("#annio").val();
    var mes = $("#mes").val();
    $.ajax({
      url: '../src/ajax_response.php',
      type: 'POST',
      data: {
        opc:1,
        annio: annio,
        mes: mes
      },
      beforeSend: function(){
        //respAlert("info","Comprobando..")
      },
      success: function(data){
        data = data.split(",");
        switch (data[0]) {
          case '0':
            $("#changeValue").html(data[1]);
            break;
          case '1':
            $("#changeValue").html(data[1]);
            /*
            setTimeout(function() {
                redireccionar("Suspension.php");
            }, 3000);
            */
            break;
          case '2':
            //respAlert("warning",""+data[1]);
            break;
          default:
            alert("No logro enviar los datos");
            break;
        }
      }
    })
  });



});
