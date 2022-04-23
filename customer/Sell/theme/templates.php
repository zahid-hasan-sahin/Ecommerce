<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $title; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo web_root; ?>customer/sell/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo web_root; ?>customer/sell/css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo web_root; ?>customer/sell/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo web_root; ?>customer/sell/css/sb-admin-2.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="<?php echo web_root; ?>customer/sell/font/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo web_root; ?>customer/sell/font/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- DataTables CSS -->
    <link href="<?php echo web_root; ?>customer/sell/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- datetime picker CSS -->
    <link href="<?php echo web_root; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo web_root; ?>css/datepicker.css" rel="stylesheet" media="screen">

    <link href="<?php echo web_root; ?>customer/sell/css/costum.css" rel="stylesheet">

    <link href="<?php echo web_root; ?>customer/sell/css/ekko-lightbox.css" rel="stylesheet">
</head>


<?php

if (!isset($_SESSION['CUSID'])) {
    //redirect(web_root . "customer/indexe.php");
}
?>

<?php
$userId = $_SESSION['CUSID'];
$query = "SELECT * FROM tblsummary WHERE ORDEREDSTATS = 'Pending' and USERID='" . $userId . "';";
$mydb->setQuery($query);
$cur = $mydb->executeQuery();
$rowscount = $mydb->num_rows($cur);
$res = isset($rowscount) ? $rowscount : 0;

if ($res > 0) {
    $order = '<span style="color:red;">(' . $res . ')</span>';
} else {
    $order = '<span> (' . $res . ')</span>';
}
?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top  " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo web_root; ?>customer/sell/index.php">Janobe E-Commerce</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-plus fa-fw"></i> New <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo web_root; ?>customer/sell/products/index.php?view=add"><i class="fa fa-barcode fa-fw"></i> Product</a>
                        </li>
                        <li><a href="<?php echo web_root; ?>customer/sell/category/index.php?view=add"><i class="fa fa-list-alt  fa-fw"></i> Category</a>
                        </li>

                        <li><a href="<?php echo web_root; ?>customer/sell/user/index.php?view=add"><i class="fa fa-user  fa-fw"></i> User</a>
                        </li>

                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <?php
                $user = new User();
                $singleuser = $user->single_user($_SESSION['CUSID']);

                ?>
                <!-- /.dropdown -->

    </div>


    </ul>
    <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">


                <!--     <li>
                            <a href="<?php echo web_root; ?>customer/sell/index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li> -->

                <li>
                    <a href="<?php echo web_root; ?>customer/sell/products/index.php"><i class="fa fa-barcode fa-fw"></i>Products </a>

                </li>
                <li>
                    <a href="<?php echo web_root; ?>customer/sell/orders/index.php"><i class="fa fa-reorder fa-fw"></i> Orders <?php echo $order; ?></a>
                </li>



                <li>
                    <a href="<?php echo web_root; ?>customer/sell/settings/index.php"><i class="fa fa-list-alt fa-fw"></i> Setting </a>

                </li>
                <!--   <li>
                             <a href="<?php echo web_root; ?>customer/sell/autonumber/index.php" ><i class="fa fa-list-alt fa-fw"></i>  Autonumber </a>
            
                        </li> -->





            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="usermodal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">×</button>

                    <h4 class="modal-title" id="myModalLabel">Profile Image.</h4>
                </div>

                <form action="<?php echo web_root; ?>customer/sell/user/controller.php?action=photos" enctype="multipart/form-data" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="rows">
                                <div class="col-md-12">
                                    <div class="rows">
                                        <img title="profile image" width="500" height="360" src="<?php echo web_root . 'customer/sell/user/' . $singleuser->USERIMAGE ?>">

                                    </div>
                                </div><br />
                                <div class="col-md-12">
                                    <div class="rows">
                                        <div class="col-md-8">

                                            <input type="hidden" name="MIDNO" id="MIDNO" value="<?php echo $_SESSION['CUSID']; ?>">
                                            <input name="MAX_FILE_SIZE" type="hidden" value="1000000"> <input id="photo" name="photo" type="file">
                                        </div>

                                        <div class="col-md-4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" type="button">Close</button> <button class="btn btn-primary" name="savephoto" type="submit">Upload Photo</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div id="page-wrapper">

        <div class="row">

            <div class="col-lg-12">

                <?php
                if ($title <> 'Dashboard') {
                    echo   '<p class="breadcrumb" style="margin-top: 8px;"> 
                        <a href="index.php" title="' . $title . '" >' . $title . '</a> 
                        ' . (isset($header) ? ' / ' . $header : '') . '  </p>';
                } ?>

                <?php check_message();  ?>


                <?php require_once $content; ?>

            </div>
            <!-- /.col-lg-12 -->

        </div>
        <!-- /.row -->

    </div>
    <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->




    <!-- jQuery -->
    <script src="<?php echo web_root; ?>customer/sell/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo web_root; ?>customer/sell/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo web_root; ?>customer/sell/js/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="<?php echo web_root; ?>customer/sell/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo web_root; ?>customer/sell/js/dataTables.bootstrap.min.js"></script>

    <script type="text/javascript" src="<?php echo web_root; ?>js/bootstrap-datepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?php echo web_root; ?>js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?php echo web_root; ?>js/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo web_root; ?>customer/sell/js/ekko-lightbox.js"></script>
    <script src="<?php echo web_root; ?>customer/sell/js/sb-admin-2.js"></script>

    <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>customer/sell/js/janobe.js"></script>
    <script type="text/javascript">
        $(document).on("click", ".PROID", function() {
            // var id = $(this).attr('id');
            var proid = $(this).data('id')
            // alert(proid)
            $(".modal-body #proid").val(proid)

        });
    </script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            var t = $('#example').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                // "sort": false,
                //ordering start at column 1
                "order": [
                    [6, 'desc']
                ]
            });

            t.on('order.dt search.dt', function() {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });




        $(document).ready(function() {
            $('#dash-table').DataTable({
                responsive: true,
                "sort": false
            });

        });



        $('.date_pickerfrom').datetimepicker({
            format: 'mm/dd/yyyy',
            startDate: '01/01/2000',
            language: 'en',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0

        });


        $('.date_pickerto').datetimepicker({
            format: 'mm/dd/yyyy',
            startDate: '01/01/2000',
            language: 'en',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0

        });
        // $(function() {
        //         var dates = $( "#date_pickerfrom, #date_pickerto" ).datepicker({                                   
        //             defaultDate:'',
        //             changeMonth: true,
        //             numberOfMonths: 1,
        //             onSelect: function( selectedDate ) {
        //             var now =Date();
        //                 var option = this.id == "from" ? "minDate" : "maxDate",
        //                     instance = $(this).data("datepicker"),
        //                     date = $.datepicker.parseDate(
        //                         instance.settings.dateFormat ||
        //                         $.datepicker._defaults.dateFormat,
        //                         selectedDate, instance.settings );
        //                 dates.not( this ).datepicker( "option", option, date );
        //             }
        //         });


        $('#date_picker').datetimepicker({
            format: 'mm/dd/yyyy',
            language: 'en',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            changeMonth: true,
            changeYear: true,
            yearRange: '1945:' + (new Date).getFullYear()
        });
    </script>


</body>
<footer>
    <p style="text-align: center;font-weight: bold;">Copyright &copy; Bachelor of Science and Entrepreneurs </p>
</footer>

</html>