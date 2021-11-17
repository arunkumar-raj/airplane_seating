<?php error_reporting(0); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Airplane booking</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top"><img src="assets/img/navbar-logo.svg" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#aeroplane">Aeroplane booking</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading">Welcome To Boooking!</div>
                <div class="masthead-heading text-uppercase">It's Nice To Meet You</div>
                <a class="btn btn-primary btn-xl text-uppercase" href="#aeroplane">Booking</a>
            </div>
        </header>

        <?php 
            require('airplane_seating.php');
            $error = '';
            if(isset($_POST['seating_arrangement'])){
                $seat_values  = $_POST['seating_arrangement'];
                $passenger  = (int)$_POST['passenger'];
                $parse_value = json_decode($seat_values);
                
                if(is_array($parse_value)){
                    $check_array = array_column($parse_value, '1');
                    if(!is_array($check_array)){
                        $error .= "Check the seating arangement value";
                    }
                }else{
                    $error .= "Check the seating arangement value";
                }
                
                if(!is_int($passenger) || $passenger==''){
                    $error .= "Check the Passenger entered value";
                }

                if($error=='' && is_array($parse_value)){
                    $seating_array = $parse_value;
                    $get_plane = new AirplaneSeating;
                    $plane = $get_plane->seating_arrangements($seating_array,$passenger);
                }

            }
        ?>

        <!-- Aeroplane-->
        <section class="page-section" id="aeroplane">
            <div class="container">

                <form  method="post" action="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <!-- Name input-->
                                <input class="form-control" id="seating_arrangement" name="seating_arrangement" type="text" value="<?php echo @$_POST['seating_arrangement']; ?>" placeholder="Seating Arrangement" />
                                <div>Example seating arrangement: [[3,2], [4,3], [2,3], [3,4]]</div>
                            </div>
                            <div class="form-group">
                                <!-- Name input-->
                                <input class="form-control" id="passenger" name="passenger" type="number" value="<?php echo @$_POST['passenger']; ?>" placeholder="passenger"/>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button-->
                    <div class="text-center">
                        <button type="submit" value="Submit" class="btn btn-primary btn-md text-uppercase" id="submit">Submit </button>
                    </div>
                </form>

                <?php if ($error != ''){ ?>
                    <div class="alert alert-warning">
                        <strong>Warning!</strong> <?php echo $error; ?>
                    </div>
                <?php } ?>
                
                <table class="table">
                    <thead>
                        <tr>
                        <?php if(isset($plane) && is_array($plane)){
                            foreach($plane as $key=> $flight){?>
                                <th scope="col"><?php echo $key;?> </th>
                            <?php
                            }
                        }
                        ?>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php if(isset($plane) && is_array($plane)){ 
                        foreach($plane as $key=> $flight){
                        ?>
                        <tr>
                            <?php 
                            foreach($flight as $row_val){ 
                                ?>
                                <td>
                                    <?php 
                                    if(is_array($row_val))
                                        foreach($row_val as $val){
                                            $get_val = explode('-',$val);
                                        ?>
                                        <div class="aero_seats <?php echo $get_val[1]; ?>"><?php echo ($get_val[0] != 0)?$get_val[0]:'X'; ?></div>
                                        <?php
                                        }
                                    else
                                        echo '&nbsp;';
                                    ?>
                                </td>
                            <?php } ?>
     
                        </tr>
                        <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
                
            </div>
        </section>
        
    
        <!-- Footer-->
        <footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-start"></div>
                    <div class="col-lg-4 my-3 my-lg-0">
                        <a class="btn btn-dark btn-social mx-2" href="https://www.linkedin.com/in/arun-kumar-raj/"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                   
                </div>
            </div>
        </footer>
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

    </body>
</html>
