<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="assets/bootstrap3/css/bootstrap.css" rel="stylesheet">
    <link href="assets/bootstrap-tour/css/bootstrap-tour.min.css" rel="stylesheet">
  </head>

  <body>
    <br>
    <div class="container">
      <div class="row">

        <!-- satu -->
        <div class="col-md-4">
          <div class="panel panel-default" id="panel1">
            <div class="panel-heading">
              <h3 class="panel-heading">judul 1 </h3>
            </div>
            <div class="panel-body">
              content 1
            </div>
          </div>
        </div>
        <!-- satu -->

        <!-- dua -->
        <div class="col-md-4">
          <div class="panel panel-default" id="panel2">
            <div class="panel-heading">
              <h3 class="panel-heading">judul 2 </h3>
            </div>
            <div class="panel-body">
              content 2
            </div>
          </div>
        </div>
        <!-- dua -->

        <!-- tiga -->
        <div class="col-md-4">
          <div class="panel panel-default" id="panel3">
            <div class="panel-heading">
              <h3 class="panel-heading">judul 3 </h3>
            </div>
            <div class="panel-body">
              content 3
            </div>
          </div>
        </div>
        <!-- tiga -->

        <!-- empat -->
        <div class="col-md-4">
          <div class="panel panel-default" id="panel4">
            <div class="panel-heading">
              <h3 class="panel-heading">judul 4 </h3>
            </div>
            <div class="panel-body">
              content 4
            </div>
          </div>
        </div>
        <!-- empat -->

      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/bootstrap3/js/jquery.min.js"></script>
    <script src="assets/bootstrap3/js/bootstrap.min.js"></script>
    <script src="assets/bootstrap-tour/js/bootstrap-tour.min.js"></script>
    <script>
      // Instance the tour
      var tour = new Tour({
        // name:'sukses family',
        backdrop:true,
        steps: [{
          element: "#panel1",
          title: "new user",
          content: "pertama klik ini 1"
        },{
          element: "#panel2",
          title: "new user",
          content: "kemudia ini 2"
        },{
          element: "#panel3",
          title: "new user",
          content: "lanjut ini  3"
        },{
          element: "#panel4",
          title: "new user",
          content: "dan ini 4"
        }]
      });

      // Initialize the tour
      tour.init();

      // Start the tour
      tour.start();
    </script>
  </body>
</html>
