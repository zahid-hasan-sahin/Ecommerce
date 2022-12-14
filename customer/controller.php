<?php
require_once("../include/initialize.php");

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add':
		doInsert();
		break;

	case 'edit':
		doEdit();
		break;



	case 'delete':
		doDelete();
		break;



	case 'processorder':
		processorder();
		break;

	case 'addwish':
		addwishlist();
		break;

	case 'wishlist':
		processwishlist();
		break;

	case 'photos':
		doupdateimage();
		break;

	case 'changepassword':
		doChangePassword();
		break;
}


function doInsert()
{
	global $mydb;
	if (isset($_POST['submit'])) {


		$customer = new Customer();
		$customer->FNAME 			= $_POST['FNAME'];
		$customer->LNAME 			= $_POST['LNAME'];
		$customer->CITYADD  		= $_POST['CITYADD'];
		$customer->GENDER 			= $_POST['GENDER'];
		$customer->PHONE 			= $_POST['PHONE'];
		$customer->CUSUNAME			= $_POST['CUSUNAME'];
		$customer->CUSPASS			= sha1($_POST['CUSPASS']);
		$customer->DATEJOIN 		= date('Y-m-d h-i-s');
		$customer->TERMS 			= 1;
		$customer->create();


		$email = trim($_POST['CUSUNAME']);
		$h_upass = sha1(trim($_POST['CUSPASS']));


		//it creates a new objects of member
		$user = new Customer();
		//make use of the static function, and we passed to parameters
		$res = $user->cusAuthentication($email, $h_upass);


		if (!isset($_POST['proid']) || (isset($_POST['proid']) && empty($_POST['proid']))) {
			echo "<script> alert('You are now successfully registered. It will redirect to your order details.'); </script>";
			redirect(web_root . "index.php?q=orderdetails");
		} else {
			$proid = $_GET['proid'];
			$id = mysqli_insert_id();
			$query = "INSERT INTO `tblwishlist` (`PROID`, `CUSID`, `WISHDATE`, `WISHSTATS`)  VALUES ('{$proid}','{$id}','" . DATE('Y-m-d') . "',0)";
			$mydb->setQuery($query);
			$mydb->executeQuery();
			echo "<script> alert('You are now successfully registered. It will redirect to your profile.'); </script>";
			redirect(web_root . "index.php?q=profile");
		}
	}
}

function doEdit()
{
	if (isset($_POST['save'])) {



		$customer = new Customer();
		// $customer->CUSTOMERID 		= $_POST['CUSTOMERID'];
		$customer->FNAME 			= $_POST['FNAME'];
		$customer->LNAME 			= $_POST['LNAME'];
		// $customer->MNAME 			= $_POST['MNAME'];
		// $customer->CUSHOMENUM 		= $_POST['CUSHOMENUM'];
		// $customer->STREETADD		= $_POST['STREETADD'];
		// $customer->BRGYADD 			= $_POST['BRGYADD'] ;			
		$customer->CITYADD  		= $_POST['CITYADD'];
		// $customer->PROVINCE 		= $_POST['PROVINCE'];
		// $customer->COUNTRY 			= $_POST['COUNTRY'];
		$customer->GENDER 			= $_POST['GENDER'];
		$customer->PHONE 			= $_POST['PHONE'];
		// $customer->ZIPCODE 			= $_POST['ZIPCODE']; 
		$customer->CUSUNAME			= $_POST['CUSUNAME'];
		// $customer->CUSPASS			= sha1($_POST['CUSPASS']);	
		$customer->update($_SESSION['CUSID']);


		message("Accounts has been updated!", "success");
		redirect(web_root . 'index.php?q=profile');
	}
}


function doDelete()
{

	if (isset($_SESSION['U_ROLE']) == 'Customer') {

		if (isset($_POST['selector']) == '') {
			message("Select the records first before you delete!", "error");
			redirect(web_root . 'index.php?page=9');
		} else {

			$id = $_POST['selector'];
			$key = count($id);

			for ($i = 0; $i < $key; $i++) {

				$order = new Order();
				$order->delete($id[$i]);

				message("Order has been Deleted!", "info");
				redirect(web_root . "index.php?q='product'");
			}
		}
	} else {

		if (isset($_POST['selector']) == '') {
			message("Select the records first before you delete!", "error");
			redirect('index.php');
		} else {

			$id = $_POST['selector'];
			$key = count($id);

			for ($i = 0; $i < $key; $i++) {

				$customer = new Customer();
				$customer->delete($id[$i]);

				$user = new User();
				$user->delete($id[$i]);

				message("Customer has been Deleted!", "info");
				redirect('index.php');
			}
		}
	}
}


function processorder()
{
	global $mydb;


	//	$_SESSION['ORDEREDNUM'] = $_POST['ORDEREDNUM'];


	// $autonumber = New Autonumber();
	// $res = $autonumber->set_autonumber('ordernumber');


	$count_cart = count($_SESSION['gcCart']);



	$s[-1] = 1;
	$us[-1] = 1;
	$on[-1] = 1;

	$tot = 0;
	if (!empty($_SESSION['gcCart'])) {
		$count_cart = @count($_SESSION['gcCart']);
		for ($j = 0; $j < $count_cart; $j++) {
			$query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
					   WHERE pr.`PROID`=p.`PROID` AND  p.`CATEGID` = c.`CATEGID`  and p.PROID='" . $_SESSION['gcCart'][$j]['productid'] . "'";
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			foreach ($cur as $result) {
				if (!isset($s[$result->USERID])) {
					$s[$result->USERID]  = 0;
				}
				$s[$result->USERID] = $s[$result->USERID] + $_SESSION['gcCart'][$j]['price'];
				$us[$_SESSION['gcCart'][$j]['price']] = $result->USERID;
			}
		}
	}

	foreach ($s as $key => $value) {
		if ($key == -1) {
			continue;
		}
		$autonumber = new Autonumber();
		$res2 = $autonumber->set_autonumber('ordernumber');
		echo $key . " " . $value . " " . $res2->AUTO . ",";
		$summary = new Summary();
		$summary->ORDEREDDATE 	= date("Y-m-d h:i:s");
		$summary->CUSTOMERID		= $_SESSION['CUSID'];
		$summary->ORDEREDNUM  	= $res2->AUTO;
		$on[$key] =  $res2->AUTO;
		$summary->DELFEE  		= $_POST['PLACE'];
		$summary->PAYMENTMETHOD	= $_POST['paymethod'];
		$summary->PAYMENT 		= $value;
		$summary->ORDEREDSTATS 	= 'Pending';
		$summary->CLAIMEDDATE		= $_POST['CLAIMEDDATE'];
		$summary->ORDEREDREMARKS 	= 'Your order is on process.';
		$summary->HVIEW 			= 0;
		$summary->USERID 			= $key;
		$summary->create();
		$autonumber->auto_update('ordernumber');
	}

	for ($i = 0; $i < $count_cart; $i++) {


		$order = new Order();
		$order->PROID		    = $_SESSION['gcCart'][$i]['productid'];
		$order->ORDEREDQTY		= $_SESSION['gcCart'][$i]['qty'];
		$order->ORDEREDPRICE	= $_SESSION['gcCart'][$i]['price'];
		$order->ORDEREDNUM		= $on[$us[$_SESSION['gcCart'][$i]['price']]];
		$order->create();

		$product = new Product();
		$product->qtydeduct($_SESSION['gcCart'][$i]['productid'], $_SESSION['gcCart'][$i]['qty']);
		$productId = $_SESSION['gcCart'][$i]['productid'];

		$query = "SELECT USERID FROM `tblproduct` where PROID='" . $productId . "';";
		$mydb->setQuery($query);
		$cur = $mydb->loadResultList();
	}


	unset($_SESSION['gcCart']);
	unset($_SESSION['orderdetails']);

	message("Order created successfully!", "success");
	redirect(web_root . "index.php?q=profile");
}


function processwishlist()
{
	global $mydb;
	if (isset($_GET['wishid'])) {

		$query = "UPDATE `tblwishlist` SET `WISHSTATS`=1  WHERE `WISHLISTID`=" . $_GET['wishid'];
		$mydb->setQuery($query);
		$res = $mydb->executeQuery();
		if (isset($res)) {
			message("Product has been removed in your wishlist", "success");
			redirect(web_root . "index.php?q=profile");
		}
	}
}


function addwishlist()
{
	global $mydb;

	$proid = $_GET['proid'];
	$id = $_SESSION['CUSID'];

	$query = "SELECT * FROM `tblwishlist` WHERE  CUSID=" . $id . " AND `PROID` =" . $proid;
	$mydb->setQuery($query);
	$res = $mydb->executeQuery();
	$maxrow = $mydb->num_rows($res);

	if ($maxrow > 0) {
		message("Product is already added to your wishlist", "error");
		redirect(web_root . "index.php?q=profile");
	} else {
		$query = "INSERT INTO `tblwishlist` (`PROID`, `CUSID`, `WISHDATE`, `WISHSTATS`)  VALUES ('{$proid}','{$id}','" . DATE('Y-m-d') . "',0)";
		$mydb->setQuery($query);
		$mydb->executeQuery();

		message("Product has been added to your wishlist", "success");
		redirect(web_root . "index.php?q=profile");
	}
}
function doupdateimage()
{

	$errofile = $_FILES['photo']['error'];
	$type = $_FILES['photo']['type'];
	$temp = $_FILES['photo']['tmp_name'];
	$myfile = $_FILES['photo']['name'];
	$location = "customer_image/" . $myfile;


	if ($errofile > 0) {
		message("No Image Selected!", "error");
		redirect(web_root . "index.php?q=profile");
	} else {

		@$file = $_FILES['photo']['tmp_name'];
		@$image = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
		@$image_name = addslashes($_FILES['photo']['name']);
		@$image_size = getimagesize($_FILES['photo']['tmp_name']);

		if ($image_size == FALSE) {
			message(web_root . "Uploaded file is not an image!", "error");
			redirect(web_root . "index.php?q=profile");
		} else {
			//uploading the file
			move_uploaded_file($temp, "customer_image/" . $myfile);


			$customer = new Customer();
			$customer->CUSPHOTO 		= $location;
			$customer->update($_SESSION['CUSID']);

			redirect(web_root . "index.php?q=profile");
		}
	}
}


function doChangePassword()
{
	if (isset($_POST['save'])) {
		# code...
		$customer = new Customer();
		$customer->CUSPASS			= sha1($_POST['CUSPASS']);
		$customer->update($_SESSION['CUSID']);


		message("Password has been updated!", "success");
		redirect(web_root . 'index.php?q=profile');
	}
}
