<section id="slider">
  <!--slider-->
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div id="slider-carousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#slider-carousel" data-slide-to="1"></li>
            <li data-target="#slider-carousel" data-slide-to="2"></li>
          </ol>

          <div class="carousel-inner">
            <div class="item active">
              <div class="col-sm-6">
                <h1><span style="color:green">Online Flea Market</span></h1>
                <h2>For Foreign Students in YZU</h2>
                <p>Created By MD ASADUZZAMAN RUMON <br> Software Engineering, Yangzhou University. </p>

              </div>
              <div class="col-sm-6">
                <img src="images/home/home1.png" class="girl img-responsive" alt="" />

              </div>
            </div>
            <div class="item">
              <div class="col-sm-6">
                <h1><span style="color:green">Online Flea Market</span></h1>
                <h2>For Foreign Students in YZU</h2>
                <p>Created By MD ASADUZZAMAN RUMON <br> Software Engineering, Yangzhou University. </p>

              </div>
              <div class="col-sm-6">
                <img src="images/home/home2.png" class="girl img-responsive" alt="" />

              </div>
            </div>

            <div class="item">
              <div class="col-sm-6">
                <h1><span style="color:green">Online Flea Market</span></h1>
                <h2>For Foreign Students in YZU</h2>
                <p>Created By MD ASADUZZAMAN RUMON <br> Software Engineering, Yangzhou University.</p>

              </div>
              <div class="col-sm-6">
                <img src="images/home/home3.png" class="girl img-responsive" alt="" />

              </div>
            </div>

          </div>

          <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>
        </div>

      </div>
    </div>
  </div>
</section>
<!--/slider-->

<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <?php include 'sidebar.php'; ?>
      </div>

      <div class="col-sm-9 padding-righ">
        <div class="features_items">
          <!--features_items-->
          <h2 class="title text-center">Features Items</h2>

          <?php

          $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
            WHERE pr.`PROID`=p.`PROID`  AND  p.`CATEGID` = c.`CATEGID`  AND PROQTY>0 and p.PROSTATS='Available' ORDER BY RAND()";


          if (isset($_SESSION['CUSID'])) {
            $userId = $_SESSION['CUSID'];
            $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
            WHERE pr.`PROID`=p.`PROID` and p.USERID!='" . $userId . "' AND  p.`CATEGID` = c.`CATEGID`  AND PROQTY>0 and p.PROSTATS='Available' ORDER BY RAND()";
          }

          $mydb->setQuery($query);
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
                        <?php
                        $str =  $result->PRODESC . " || " . $result->CAMPUS . "||" . $result->BOOKCONDITION;
                        ?>
                        <p><?php echo   $str ?> </p>
                        <button type="submit" name="btnorder" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                      </div>
                      <div class="product-overlay">
                        <div class="overlay-content">
                          <h2>Seller Details</h2>
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
          <?php
            }
          } ?>

        </div>
        <!--features_items-->

        <div class="recommended_items">
          <!--recommended_items-->
          <h2 class="title text-center">recommended items</h2>

          <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="item active">
                <?php
                $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                WHERE pr.`PROID`=p.`PROID`  AND   p.`CATEGID` = c.`CATEGID`  AND PROQTY>0 and p.PROSTATS='Available' ORDER BY RAND() limit 3 ";

                if (isset($_SESSION['CUSID'])) {
                  $userId = $_SESSION['CUSID'];
                  $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                   WHERE pr.`PROID`=p.`PROID` and p.USERID!='" . $userId . "' AND  p.`CATEGID` = c.`CATEGID`  AND PROQTY>0 and p.PROSTATS='Available' ORDER BY RAND() limit 3";
                }


                $mydb->setQuery($query);
                $cur = $mydb->loadResultList();

                foreach ($cur as $result) {
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

                        </div>
                      </div>
                    </div>
                  </form>
                <?php } ?>
              </div>
              <div class="item">
                <?php
                $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                WHERE pr.`PROID`=p.`PROID` AND  p.`CATEGID` = c.`CATEGID`  AND PROQTY>0 and p.PROSTATS='Available' ORDER BY RAND() limit 3";
                if (isset($_SESSION['CUSID'])) {
                  $userId = $_SESSION['CUSID'];
                  $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                   WHERE pr.`PROID`=p.`PROID` and p.USERID!='" . $userId . "' AND  p.`CATEGID` = c.`CATEGID`  AND PROQTY>0 and p.PROSTATS='Available' ORDER BY RAND() limit 3";
                }



                $mydb->setQuery($query);
                $cur = $mydb->loadResultList();


                foreach ($cur as $result) {
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

                        </div>
                      </div>
                    </div>
                  </form>
                <?php } ?>
              </div>
            </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
              <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
        </div>
        <!--/recommended_items-->

      </div>
    </div>
  </div>
</section>