 <section id="advertisement">
   <div class="container">
     <img src="images/shop/advertisement.jpg" alt="" />
   </div>
 </section>

 <section>
   <div class="container">
     <div class="row">
       <div class="col-sm-3">
         <?php include 'sidebar.php'; ?>
       </div>
       <!--/category-productsr-->

       <div class="col-sm-9 padding-right">
         <div class="features_items">
           <!--features_items-->
           <h2 class="title text-center">Products</h2>
           <?php

            $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
            WHERE pr.`PROID`=p.`PROID` AND  p.`CATEGID` = c.`CATEGID`  AND PROQTY>0 and p.PROSTATS='Available'";

            if (isset($_SESSION['CUSID'])) {
              $userId = $_SESSION['CUSID'];

              if (isset($_POST['search'])) {
                $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                          WHERE pr.`PROID`=p.`PROID` and p.USERID!='" . $userId . "' AND  p.`CATEGID` = c.`CATEGID`  AND PROQTY>0  and P.PROSTATS='Available'
                AND ( `CATEGORIES` LIKE '%{$_POST['search']}%' OR `PRODESC` LIKE '%{$_POST['search']}%' or `PROQTY` LIKE '%{$_POST['search']}%' or `PROPRICE` LIKE '%{$_POST['search']}%')";
              } elseif (isset($_GET['category'])) {
                $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                          WHERE pr.`PROID`=p.`PROID` and p.USERID!='" . $userId . "' AND  p.`CATEGID` = c.`CATEGID`  AND PROQTY>0 and P.PROSTATS='Available' AND  CATEGORIES='{$_GET['category']}'";
              } else {
                $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                          WHERE pr.`PROID`=p.`PROID` and p.USERID!='" . $userId . "' AND  p.`CATEGID` = c.`CATEGID`  AND PROQTY>0  and P.PROSTATS='Available'";
              }
            } else {
              if (isset($_POST['search'])) {
                $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                          WHERE pr.`PROID`=p.`PROID` AND  p.`CATEGID` = c.`CATEGID`  AND PROQTY>0  and P.PROSTATS='Available'
                AND ( `CATEGORIES` LIKE '%{$_POST['search']}%' OR `PRODESC` LIKE '%{$_POST['search']}%' or `PROQTY` LIKE '%{$_POST['search']}%' or `PROPRICE` LIKE '%{$_POST['search']}%')";
              } elseif (isset($_GET['category'])) {
                $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                          WHERE pr.`PROID`=p.`PROID`  AND  p.`CATEGID` = c.`CATEGID`  AND PROQTY>0 and P.PROSTATS='Available' AND  CATEGORIES='{$_GET['category']}'";
              } else {
                $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                          WHERE pr.`PROID`=p.`PROID` AND  p.`CATEGID` = c.`CATEGID`  AND PROQTY>0  and P.PROSTATS='Available'";
              }
            }


            $mydb->setQuery($query);
            $res = $mydb->executeQuery();
            $maxrow = $mydb->num_rows($res);

            if ($maxrow > 0) {
              $cur = $mydb->loadResultList();

              foreach ($cur as $result) {

                $sql2 = "SELECT * from tblcustomer WHERE CUSTOMERID =" . $result->USERID . ";";
                $mydb->setQuery($sql2);
                $cur2 = $mydb->loadResultList();
                foreach ($cur2 as $res2) {

            ?>
                 <form method="POST" action="cart/controller.php?action=add">
                   <input type="hidden" name="PROPRICE" value="<?php echo $result->PRODISPRICE; ?>">
                   <input type="hidden" id="PROQTY" name="PROQTY" value="<?php echo $result->PROQTY; ?>">

                   <input type="hidden" name="PROID" value="<?php echo $result->PROID; ?>">
                   <div class="col-sm-4" style="height:500px">
                     <div class="product-image-wrapper">
                       <div class="single-products">
                         <div class="productinfo text-center">
                           <img src="<?php echo web_root . 'customer/sell/products/' . $result->IMAGES; ?>" alt="" width="300" height="230" />
                           <h2>¥ <?php echo $result->PRODISPRICE; ?></h2>
                           <h5><del>¥ <?php echo $result->ORIGINALPRICE; ?></del></h5>
                           <p><?php echo    $result->PRODESC; ?> || <?php echo    $result->CAMPUS; ?> || <?php echo    $result->BOOKCONDITION; ?> </p>
                           <button type="submit" name="btnorder" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                         </div>
                         <div class="product-overlay">
                           <div class="overlay-content">
                             <h3>Seller Details</h3>
                             <h6 style="color:white">---------------</h6>
                             <p><?php echo $res2->FNAME . " " . $res2->LNAME . " || " . $res2->CITYADD . " || " . $res2->PHONE;  ?> </p>
                             <button type="submit" name="btnorder" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                           </div>
                         </div>
                       </div>
                       <div class="choose">
                         <ul class="nav nav-pills nav-justified">
                           <li>
                             <?php
                              if (isset($_SESSION['CUSID'])) {

                                echo ' <a href="' . web_root . 'customer/controller.php?action=addwish&proid=' . $result->PROID . '" title="Add to wishlist"><i class="fa fa-plus-square"></i>Add to wishlist</a></a>
                            ';
                              } else {
                                echo   '<a href="#" title="Add to wishlist" class="proid"  data-target="#smyModal" data-toggle="modal" data-id="' .  $result->PROID . '"><i class="fa fa-plus-square"></i>Add to wishlist</a></a>
                            ';
                              }
                              ?>

                           </li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </form>
           <?php  }
              }
            } else {

              echo '<h1>No Products Available</h1>';
            } ?>
         </div>
         <!--features_items-->
       </div>
     </div>
   </div>
 </section>