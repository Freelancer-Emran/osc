<?php
    // title define and Page define for active class in sidebar
    define('TITLE', 'Admin | Assets');
    define('PAGE', 'assets');
    // database connection
    include('../dbConnection.php');
    // start login session
    session_start();
    if (isset($_SESSION['is_adminLogin'])) {
        // $_SESSION['aEmail'] = $aemail;
    } else {
        echo "<script>location.href='adminLogin.php';</script>";
    } // end login session

?>

<!-- header part -->
<?php include('adminHead.php'); ?>
<!-- Start assets part -->

<!-- start 2nd column technician -->
<div class="col-sm-8 col-xl-10 col-md-9 py-5 text-center">
        <div class="mx-5">
            <p class="text-light bg-dark p-2">List Of Product/Parts Details</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product ID.</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Available</th>
                        <th>Total</th>
                        <th>Original Cost Each</th>
                        <th>Selling Cost Each</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql="SELECT * FROM technician_t";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {?>


                        <tr>
                            <td><?= $row['tech_id']; ?></td>
                            <td><?= $row['tech_name']; ?></td>
                            <td><?= $row['tech_city']; ?></td>
                            <td><?= $row['tech_mobile']; ?></td>
                            <td><?= $row['tech_email']; ?></td>
                            <td class="d-flex align-items-center justify-content-center">
                                <form class='me-1' action='editTechnician.php' method='post'>
                                    <input type='hidden' name='editID' value='<?= $row['tech_id']; ?>'>
                                    <button class='btn btn-warning' type='submit' name='viewBtn'><i class='fas fa-edit'></i></button>
                                </form>

                                <form action='' method='post'>
                                    <input type='hidden' name='deleteID' value='<?= $row['tech_id']; ?>'>
                                    <button class='btn btn-danger' type='button' name='delete' data-bs-toggle='modal' data-bs-target='#user<?= $row['tech_id']; ?>'><i class='far fa-trash-alt'></i></button>
                                </form>
                            </td>
                        </tr>


    <!-- start delete Modal part -->

    <div class="modal fade" id="user<?php if(isset($row['tech_id'])){echo $row['tech_id'];}?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Requester ID <?php if(isset($row['tech_id'])){echo "(" . $row['tech_id'] . ")";}?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center p-1">
                Are You Sure Permanently Deleted Requester ID?
            <?php //echo $row['std_id'];?>
            </div>
            <div class="modal-footer p-1">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            <!-- <button type="submit" class="btn btn-danger" name='delete' value="Yes">Yes</button> -->
            <form action='' method='post'>
                <input type='hidden' value='<?php echo $row['tech_id']; ?>' name='deleteID'>
                <input type='submit' value='Yes' name='deleteBtn' class='btn btn-danger btn-sm'>
            </form>
            <!-- <a class="btn btn-danger" href="">Yes</a> -->
            </div>
        </div>
        </div>
    </div>
    
    <!-- end delete Modal part -->

                    <?php            
                            }
                        } else {
                            echo '<div class="col-sm-6 text-center bg-danger rounded-3 text-light p-3">
                                No Technician Found.
                            </div>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php // start delete query part
    
    if (isset($_REQUEST['deleteBtn'])) {
        $sql="DELETE FROM technician_tb where tech_id = {$_REQUEST['deleteID']}";
        
        if ($conn->query($sql) == true) {
            echo '<div class="col-sm-6 col-md-5 col-xl-3 alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; right: 10px; top: 10%; z-index: 1;">
            <span class="me-2" id="counter"></span>
                Technician (' . "{$_REQUEST['deleteID']}" . ') Deleted Successfully.
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>';

            echo '<meta http-equiv="refresh" content="0; url=?closed">';
        } else {
            echo '<div class="col-sm-6 col-md-5 col-xl-3 alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; right: 10px; top: 10%; z-index: 1;">
            <span class="me-2" id="counter"></span>
                Unable to Technician (' . "{$_REQUEST['deleteID']}" . ') Deleted.
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>';
            } 
        }
    ?>  <!-- End delete query part -->

<!-- end 2nd column technician -->

<!-- End assets part -->
    
    <!--Start Alert box script-->
    <script> 
        setTimeout(() => {
            // location.href = 'session.php'
            $('.alert').fadeOut();
        }, 5000);

        let count = 5
        var stop = setInterval(() => {

            if (count <= 0) {
                clearInterval(stop)
                // $('.alert').fadeOut();
            }

            count--
            counter.innerHTML = count;
            counter.style.color = "blue";

        }, 1000);
    </script> <!--End Alert box script-->

<!-- back to row div for insert data in table Therefore direct footer part adjust -->
<!-- footer part -->
</div> <!-- End Row -->
        <div class="float-end mx-5 my-3 position-fixed" style="top:80vh; right:10px"> <!-- start plus icon -->
            <form action="insertProduct.php" method="post">
                <button class="btn btn-danger" data-bs-toggle="tooltip" title="Add Product" data-bs-placement="top">
                    <i class="fas fa-plus fa-2x text-light"></i>
                </button>
            </form>
        </div>  <!-- end plus icon -->
    </div> <!-- End left sidebar container -->

    <!-- jquery link -->
    <script src="../js/jquery-3.5.1.min.js"></script>
    <!-- bootstrap link -->
    <script src="../js/bootstrap.bundle.min.js"></script>
    <!-- font awesome link -->
    <script src="../js/all.min.js"></script>

    <!-- Start Tooltip script-->
    <script type="text/javascript">
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl){
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    </script> <!-- End Tooltip script-->
    
</body>
</html>

