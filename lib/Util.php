<?php

/** 
 * @author - j.o
 * @license propriatery
 * @file - Util.php
 * @usage - utilities objects
 */

class Util {
 function LoadEnv() {
  //$env = parse_ini_file('C:\xampp\htdocs\happyboxfront\.env');
  $env = parse_ini_file(dirname(__DIR__) . '/.env');
  return json_decode(json_encode($env));
 }
 function AppShipping() {
  return $this->LoadEnv()->APP_SHIPPING;
 }
 function AppHome() {
  return $this->LoadEnv()->APP_HOME;
 }
 function AdminHome() {
  return $this->LoadEnv()->APP_ADMIN_HOME;
 }
 function AjaxHome() {
  //return $this->LoadEnv()->APP_CLIENT_HOME . '/ajax.php';
  return $this->LoadEnv()->APP_HOME . '/ajax/ajax.php';
 }
 function AppErrors() {
  return $this->LoadEnv()->APP_ERRORS;
 }
 function PartnerHome() {
  return $this->LoadEnv()->APP_PARTNER_HOME;
 }
 function ClientHome() {
  return $this->LoadEnv()->APP_CLIENT_HOME;
 }
 function AppAPI() {
  return $this->LoadEnv()->APP_API;
 }
 function AppUploads() {
  return $this->LoadEnv()->APP_UPLOADS;
 }
 /** mpesa */
 function AppConsumerKey() {
  return $this->LoadEnv()->APP_MPESA_C_KEY;
 }
 function AppConsumerSecret() {
  return $this->LoadEnv()->APP_MPESA_C_SECRET;
 }
 function AppC2bConsumerKey() {
  return $this->LoadEnv()->APP_MPESA_C2B_C_KEY;
 }
 function AppC2bConsumerSecret() {
  return $this->LoadEnv()->APP_MPESA_C2B_C_SECRET;
 }
 function AppPayBill() {
  return $this->LoadEnv()->APP_MPESA_PAYBILL;
 }
 function AppPassKey() {
  return $this->LoadEnv()->APP_MPESA_PASSKEY;
 }
 function AppMpesaTransType() {
  return $this->LoadEnv()->APP_MPESA_TRANS_TYPE;
 }
 function AppMpesaCallBack() {
  return $this->LoadEnv()->APP_MPESA_CALL_BACK;
 }
 /** jp */
 function JpBusiness() {
  return $this->LoadEnv()->JP_BUSINESS;
 }
 function JpSharedKey() {
  return $this->LoadEnv()->JP_SHARED_KEY;
 }
 function JpReturn() {
  return $this->LoadEnv()->JP_RETURN_URL;
 }
 function JpCancel() {
  return $this->LoadEnv()->JP_CANCEL_URL;
 }
 function JpFail() {
  return $this->LoadEnv()->JP_FAIL_URL;
 }
 /** end jp */
 function AppWellBeing() {
  return $this->LoadEnv()->APP_WB;
 }
 function AppGastronomy() {
  return $this->LoadEnv()->APP_GS;
 }
 function AppSports() {
  return $this->LoadEnv()->APP_SA;
 }
 function AppMpesaConfirmation() {
  return $this->LoadEnv()->APP_MPESA_CONFIRMATION;
 }
 function AppMpesaValidation() {
  return $this->LoadEnv()->APP_MPESA_VALIDATION;
 }

 function AppMpesaEnv() {
  return $this->LoadEnv()->APP_MPESA_ENV;
 }
 function AppC2bPhone() {
  return $this->LoadEnv()->APP_MPESA_C2B_PHONE;
 }
 function AppC2bPayBill() {
  return $this->LoadEnv()->APP_MPESA_C2B_PAYBILL;
 }
 /** maps */
 function MapsUrl() {
  return $this->LoadEnv()->APP_MAPS_URL_LOCATION;
 }
 function MapsKey() {
  return $this->LoadEnv()->APP_MAPS_KEY;
 }
 /** end maps */
 /** sendy */
 function SendyKey() {
  return $this->LoadEnv()->APP_SENDY_KEY;
 }
 function SendyUser() {
  return $this->LoadEnv()->APP_SENDY_USER;
 }
 function SendyUrl() {
  return $this->LoadEnv()->APP_SENDY_URL;
 }
 /** end sendy */
 function contact_data() {
  return explode(',', $this->LoadEnv()->APP_CONTACT_INFO);
 }
 function warehouse() {
  return $this->LoadEnv()->APP_CONTACT_ADDRESS;
 }
 function error_flash($e) {
  return '<p class="alert alert-danger">' . $e . '</p>';
 }
 function success_flash($e) {
  return '<p class="alert alert-success">' . $e . '</p>';
 }
 function isValidPassword($password) {
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number    = preg_match('@[0-9]@', $password);
  $specialChars = preg_match('@[^\w]@', $password);

  if (
   !$uppercase ||
   !$lowercase ||
   !$number ||
   !$specialChars ||
   strlen($password) < 8
  ) {
   return false;
  }
  return true;
 }
 function globalDate($date) {
  return date('d/m/Y', strtotime($date));
 }
 function voucher_div($status) {
  if ($status == 3) {
   return '<td class="hap_success">REDEEMED</td>';
  }
  if ($status == 6) {
   return '<td class="hap_success">ACTIVATED</td>';
  }
  if ($status == 4) {
   return '<td class="hap_danger">CANCELLED</td>';
  }
 }
 function patner_rating($rating_v) {
  if ($rating_v <= 0) {
   return '
            <i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
  }
  $ct = 0;
  $v = explode('.', $rating_v);
  $value = number_format($rating_v, 2);
  $value2 = number_format($rating_v, 0);
  $rating = '';
  $decimal = floatval('0.' . $v[1]);
  $count = 0;
  while ($ct < 5) {
   if ($ct < $value2) {
    $rating .= '<i class="fa fa-star"></i>';
    if ($ct + 1 == $value2) {
     if ($decimal > 0.4) {
      $rating .= '<i class="fa fa-star-half-alt"></i>';
     } elseif ($decimal > 0 && $decimal < 0.5) {
      $rating .= '<i class="fa fa-star-half-alt"></i>';
     }
    }
    $count++;
   } else {
    if ($ct + 1 < 5) {
     $rating .= '<i class="far fa-star"></i>';
    }
   }
   $ct++;
  }
  if ($value2 == 0) {
   $rating .= '<i class="fa fa-star"></i>';
  }
  return $rating;
 }
 function place_autocomplete($id) {
  print '<script>        
        $(document).ready(function () {
            try{
                google.maps.event.addDomListener(window, \'load\', initialize);
            } catch (error) {
                console.log(error.message);
            }
        });
        function initialize() {
            var options = {
                componentRestrictions: {country: "KE"}
            };

            var input = document.getElementById(\'' . $id . '\');
            var autocomplete = new google.maps.places.Autocomplete(input, options);
        }
        </script>';
 }
 function mpesa_process($paybill, $invoice, $amt) {
  return '
        <div class="article_text">
            <p><span style="font-size: 14pt;"><strong>You can also pay as follows</strong></span></p>
            <ol>
                <li>Select <b>"Pay bill"</b> from your Safaricom MPesa Menu.</li>
                <li>Enter HappyBox Business Number <b>"' . $paybill . '"</b>.</li>
                <li>Select "Enter Account Number".</li>
                <li>Enter Order number <b>"' . $invoice . '"</b>.</li>
                <li>Enter Amount <b>"' . floor($amt) . '"</b> </li>
                <li>Enter <b>"PIN"</b> then Press "OK"</li>
                <li>You will then Receive a "Confirmation Message" from MPesa.</li>
            </ol>
        </div>
        ';
 }
 function remove_from_cart($item) {
  $l = 0;
  if (isset($_SESSION['curr_usr_cart'])) {
   foreach ($_SESSION['curr_usr_cart'] as $cart) {
    if ($item = $cart[0]) {
     unset($_SESSION['curr_usr_cart'][$l]);
     return;
    }
    $l++;
   }
  }
  return false;
 }
 function is_in_cart($item) {
  if (isset($_SESSION['curr_usr_cart'])) {
   foreach ($_SESSION['curr_usr_cart'] as $cartt) {
    if ($item == $cartt[0]) {
     return true;
     exit;
    }
   }
  }
  return false;
 }
 function change_cart_box_type($item, $ship_type, $stock) {
  $l = 0;
  //$cart_item = [$item, $qty, $ship_type, $stock];
  $this->unique_cart();
  if (isset($_SESSION['curr_usr_cart'])) {
   foreach ($_SESSION['curr_usr_cart'] as $cart) {
    if ($item == $cart[0]) {
     $current_qty = $cart[1];
     if ($current_qty > $stock && $ship_type == '1') {
      $new_cart = [$item, $current_qty, 2, $stock];
      $_SESSION['curr_usr_cart'][$l] = $new_cart;
      exit(json_encode(['ERR' => 'No enough boxes to service your order']));
     } else {
      $new_cart = [$item, $current_qty, $ship_type, $stock];
      $_SESSION['curr_usr_cart'][$l] = $new_cart;
      return true;
     }
    }
    $l++;
   }
  }
  return false;
 }
 function update_cart_item($item, $qty, $stock) {
  $l = $is_found = 0;
  $this->unique_cart();
  //$cart_item = [$item, $qty, $ship_type, $stock];
  if (isset($_SESSION['curr_usr_cart'])) {
   foreach ($_SESSION['curr_usr_cart'] as $cart) {
    if ($item == $cart[0]) {
     $is_found++;
     // unset($_SESSION['curr_usr_cart'][$l]);
     // $_SESSION['curr_usr_cart'] = array_values($_SESSION['curr_usr_cart']);
     $ship_type = 1;
     $new_qty = $cart[1] + $qty;
     if ($new_qty > $stock) {
      $ship_type = 2;
     }
     if ($new_qty > 10) {
      $new_qty = 10;
     }
     $new_cart = [
      $item, $new_qty, $ship_type, $stock
     ];
     $_SESSION['curr_usr_cart'][$l] = $new_cart;
     // array_push($_SESSION['curr_usr_cart'], $new_cart);
     return true;
    }
    if ($item == $cart[0] && $is_found > 1) {
     unset($_SESSION['curr_usr_cart'][$l]);
    }
    $l++;
   }
  }
  return false;
 }

 function change_cart_item_qty($item, $qty, $stock) {
  $l = $is_found = 0;
  //$cart_item = [$item, $qty, $ship_type, $stock];
  if (isset($_SESSION['curr_usr_cart'])) {
   foreach ($_SESSION['curr_usr_cart'] as $cart) {
    if ($item == $cart[0]) {
     // $ship_type = 1;
     $ship_type = $cart[2];
     $new_qty = $qty;
     if ($new_qty > $stock) {
      // $ship_type = 2;
      $ship_type = $cart[2];
     }
     if ($new_qty > 10) {
      $new_qty = 10;
     }
     $new_cart = [
      $item, $new_qty, $ship_type, $stock
     ];
     $_SESSION['curr_usr_cart'][$l] = $new_cart;
     // return true;
     $is_found++;
    }
    if ($item == $cart[0] && $is_found > 1) {
     unset($_SESSION['curr_usr_cart'][$l]);
    }
    $l++;
   }
  }
  $this->unique_cart();
  return false;
 }
 function unique_cart() {
  $_items = [];
  if (isset($_SESSION['curr_usr_cart'])) {
   foreach ($_SESSION['curr_usr_cart'] as $cart) {
    $_items[] = $cart[0];
   }
  }
  $items_unq = array_unique($_items);

  $loop = 0;
  foreach ($items_unq as $unq) {
   if (in_array($unq, $_SESSION['curr_usr_cart'][$loop])) {
    $_final_cart[] =  $_SESSION['curr_usr_cart'][$loop];
   }
   $loop++;
  }
  return $_SESSION['curr_usr_cart'] = $_final_cart;
 }
 function tb64($path) {
  $type = pathinfo($path, PATHINFO_EXTENSION);
  $data = file_get_contents($path);
  return $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
 }
 function msg_box($ext = '') {
  print '<div style="display:none;margin: 0px auto;text-align: center;width: 44%;" id="' . $ext . 'succ" class="alert alert-success"></div>
        <div style="display:none;margin: 0px auto;text-align: center;width: 44%;" id="' . $ext . 'err" class="alert alert-danger"></div>';
 }
 function redirect_to($to, $t = 0) {
  if ($t > 0) {
   print '<script>window.location.replace("' . $to . '")</script>';
   return;
  }
  header("Location: " . $to);
 }
 function timed_redirect($to) {
  print '<script>
            window.setTimeout(function() {
                window.location.href = "' . $to . '";
            }, 2000);
        </script>';
 }
 function ShowErrors($f = 0) {
  if ($this->AppErrors() == 0) {
   return;
  }
  if ($f == 0) {
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
  } else {
   error_reporting(0);
   error_reporting(E_ALL ^ E_NOTICE);
  }
 }
 function createCode($length = 20) {
  $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
   $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
 }
 function locations_list() {
  return  ['Nairobi', 'Mombasa', 'Nakuru', 'Naivasha', 'Kisumu', 'Lamu', 'Watamu', 'Malindi', 'Kitale'];
 }
 function cartCount() {
  $cnt = [];
  if (isset($_SESSION['curr_usr_cart'])) {
   foreach ($_SESSION['curr_usr_cart'] as $_cart_item) :
    if (isset($_cart_item['order_id'])) {
    } elseif (isset($_cart_item['physical_address'])) {
    } else {
     $cnt[] = 1;
    }
   endforeach;
  }
  return array_sum($cnt);
 }
 function ValidatePasswordStrength($password) {
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number    = preg_match('@[0-9]@', $password);
  $specialChars = preg_match('@[^\w]@', $password);
  if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
   throw new Exception('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
   return false;
  }
  return true;
 }
 function v_search_table($data) {
  $div = '<div class="voucher_result_bar">
            <div class="voucher_no">
                VOUCHER NUMBER
            </div> 
            <div class="voucher_no_value ">
                ' . $data[0] . '
            </div>
            <div class="voucher_status">
                STATUS
            </div>
            <div class="voucher_status_value">
                ' . $this->get_v_status_name($data[1]) . '
            </div>
            <div class="voucher_partner">
                PARTNER
            </div>
            <div class="voucher_partner_val col-md-3 border_right">
                ' . $data[2] . '
            </div>
            <div class="voucher_partner2 col-md-3">
            ' . $data[3] . ' 
            </div>
        </div>';
  return $div;
 }
 function Show($toshow) {
  print '<pre>';
  print_r($toshow);
  print '</pre>';
 }
 function cust_buyer_keys() {
  return [
   'customer_buyer_id_0',
   'customer_buyer_id_1',
   'customer_buyer_id_2',
   'customer_buyer_id_3'
  ];
 }
 function cust_user_keys() {
  return [
   'customer_user_id_0',
   'customer_user_id_1',
   'customer_user_id_2',
   'customer_user_id_3'
  ];
 }
 function box_keys() {
  return [
   'box_internal_id_0',
   'box_internal_id_1'
  ];
 }
 function indirect_cols() {
  return [
   'customer_buyer_id_0',
   'customer_buyer_id_1',
   'customer_buyer_id_2',
   'customer_buyer_id_3',
   'customer_user_id_0',
   'customer_user_id_1',
   'customer_user_id_2',
   'customer_user_id_3',
   'partner_internal_id',
   'box_internal_id_0',
   'box_internal_id_1'
  ];
 }
 function report_headers($cols) {
  $h = '<thead><tr>';
  foreach ($this->report_cols() as $k => $v) {
   if (in_array($k, $cols)) {
    $h .= '<th>' . $v . '</th>';
   }
  }
  $h .= '</tr></thead>';
  return $h;
 }
 function get_v_status_name($v) {
  if ($v == 1) {
   return 'In stock';
  } elseif ($v == 2) {
   return 'Purchased';
  } elseif ($v == 3) {
   return 'Redeemed';
  } elseif ($v == 4) {
   return 'Cancelled';
  } elseif ($v == 5) {
   return 'Expired';
  } elseif ($v == 6) {
   return 'Activated';
  } else {
   return 'N/A';
  }
 }
 function report_body($results, $cols, $user_ob, $box_ob, $token) {
  $b = '<tbody>';
  $n_a = 'N/A';
  foreach ($results as $result) :
   $b .= '<tr>';
   foreach ($this->report_cols() as $k => $v) {
    if (array_key_exists($k, $result) && in_array($k, $cols)  && !in_array($k, $this->indirect_cols())) {
     if ($k == 'box_voucher_status') {
      $b .= '<td>' . $this->get_v_status_name($result[$k]) . '</td>';
     } else {
      $value = !empty($result[$k]) ? $result[$k] : 'N/A';
      $b .= '<td>' . $value . '</td>';
     }
    } elseif (in_array($k, $this->indirect_cols()) && in_array($k, $cols)) {
     if (in_array($k, $this->cust_buyer_keys())) {
      $cust_buyer_id = $result['customer_buyer_id'];
      $cust_data = json_decode($user_ob->get_details_byidf($cust_buyer_id))->data;
      if ($k == 'customer_buyer_id_0') {
       $n = $cust_data->fname . '' . $cust_data->mname;
       $cname = !empty($n) ? $n : 'N/A';
       $b .= '<td>' . $cname . '</td>';
      } elseif ($k == 'customer_buyer_id_1') {
       $cname = !empty($cust_data->sname) ? $cust_data->sname : 'N/A';
       $b .= '<td>' . $cname . '</td>';
      } elseif ($k == 'customer_buyer_id_2') {
       $email = !empty($cust_data->email) ? $cust_data->email : 'N/A';
       $b .= '<td>' . $email . '</td>';
      } elseif ($k == 'customer_buyer_id_3') {
       $phone = !empty($cust_data->phone) ? $cust_data->phone : 'N/A';
       $b .= '<td>' . $phone . '</td>';
      }
     } elseif (in_array($k, $this->cust_user_keys())) {
      $cust_user_id = $result['customer_user_id'];
      $cust_data = json_decode($user_ob->get_details_byidf($cust_user_id))->data;
      if ($k == 'customer_user_id_0') {
       $n = $cust_data->fname . '' . $cust_data->mname;
       $cname = !empty($n) ? $n : 'N/A';
       $b .= '<td>' . $cname . '</td>';
      } elseif ($k == 'customer_user_id_1') {
       $cname = !empty($cust_data->sname) ? $cust_data->sname : 'N/A';
       $b .= '<td>' . $cname . '</td>';
      } elseif ($k == 'customer_user_id_2') {
       $email = !empty($cust_data->email) ? $cust_data->email : 'N/A';
       $b .= '<td>' . $email . '</td>';
      } elseif ($k == 'customer_user_id_3') {
       $phone = !empty($cust_data->phone) ? $cust_data->phone : 'N/A';
       $b .= '<td>' . $phone . '</td>';
      }
     } elseif (in_array($k, $this->box_keys())) {
      $box_internal_id = $result['box_internal_id'];
      $bbb_ = $box_ob->get_byidf($token, $box_internal_id);
      $box_data = json_decode($bbb_)->data;
      if ($k == 'box_internal_id_0') {
       $bname = !empty($box_data->name) ? $box_data->name : $n_a;
       $b .= '<td>' . $bname . '</td>';
      } elseif ($k == 'box_internal_id_1') {
       $bprice = !empty($box_data->price) ? $box_data->price : 'N/A';
       $b .= '<td> KES ' . $bprice . '</td>';
      }
     } elseif ($k == 'partner_internal_id') {
      $partner_internal_id = $result['partner_internal_id'];
      $partner_data = json_decode($user_ob->get_details_byidf($partner_internal_id))->data;
      $bname = !empty($partner_data->business_name) ? $partner_data->business_name : 'N/A';
      $b .= '<td>' . $bname . '</td>';
     }
    } else {
    }
   }
   $b .= '</tr>';
  endforeach;
  $b .= '</tbody>';
  return $b;
 }
 function build_report_table($results, $cols, $user, $box, $token) {
  $cols = explode(',', $cols);
  $table = '<div class="table-responsive"><table id="report_id" class="table table_data1 table-bordered">';
  $table .= $this->report_headers($cols);
  $table .= $this->report_body($results, $cols, $user, $box, $token);
  $table .= '</table></div>';
  return $table;
 }
 function report_cols() {
  $r  = [
   'order_number' => 'Order Number',
   'customer_buyer_id_0' => 'Customer Buyer Name',
   'customer_buyer_id_1' => 'Customer Buyer Surname',
   'customer_buyer_id_2' => 'Customer Buyer Email',
   'customer_buyer_id_3' => 'Customer Buyer Phone',
   'customer_payment_method' => 'Customer Buyer Payment Method',
   'box_delivery_address' => 'Box Delivery Address',
   'box_purchase_date' => 'Box Puchase Date',
   'box_validity_date' => 'Box Validity Date',
   'customer_buyer_invoice' => 'Customer Buyer Invoice Number',
   'box_barcode' => 'Box Barcode',
   'box_internal_id_0' => 'Box Name',
   'box_voucher' => 'Voucher Code',
   'box_voucher_new' => 'New Voucher Code',
   'box_voucher_status' => 'Voucher Status',
   'voucher_activation_date' => 'Voucher Activation Date',
   'customer_user_id_0' => 'Customer User Name',
   'customer_user_id_1' => 'Customer User Surname',
   'customer_user_id_2' => 'Customer User Email',
   'customer_user_id_3' => 'Customer User Phone',
   'redeemed_date' => 'Redeemed Date',
   'cancellation_date' => 'Cancellation Date',
   'booking_date' => 'Booking Date',
   'box_internal_id_1' => 'Box Price',
   'partner_pay_due_date' => 'Partner Reimbursment Due Date',
   'partner_pay_effec_date' => 'Partner Reimbursment Effective Date',
   'partner_pay_amount' => 'Partner Reimbursment',
   'partner_internal_id' => 'Partner Identity',
   'partner_invoice' => 'Partner Invoice number'
  ];
  return $r;
 }
 function get_media_types() {
  return ['Image', '3D Image', 'PDF Booklet', 'Video File'];
 }
 function is_partner() {
  if (json_decode($_SESSION['usr'])->user->is_partner) {
   return true;
  }
  return false;
 }
 function is_client() {
  if (json_decode($_SESSION['usr'])->user->is_client) {
   return true;
  }
  return false;
 }
 function is_admin() {
  if (json_decode($_SESSION['usr'])->user->is_admin) {
   return true;
  }
  return false;
 }
 function modal_click($id) {
  print '
        <script>
            var link = document.getElementById("' . $id . '");
            link.click();
        </script>
        ';
 }
 function format_box_services($input, $current_ptn = null) {
  //return $input;
  $rtn = array();
  foreach ($input as $_data) :
   $l = explode('~~~', $_data);
   if ($l[0] == json_decode($_SESSION['usr_info'])->data->internal_id) {
    $rtn[] = $l[2];
   }
  endforeach;
  return $rtn;
 }
 function ptn_v_validity($data, $box_data, $obj = null) {
  if ($box_data[0] == 'Invalid' && !is_null($obj)) {
   if ($box_data[2] == 1) {
    return '<div style="margin: 0px auto;text-align: center;width: 44%;" class="alert alert-danger">Voucher code is invalid. Do not redeem it.</div>';
   }
   return '<div style="margin: 0px auto;text-align: center;width: 44%;" class="alert alert-danger">' . $obj->message . '</div>';
  }
  $options_ = '';
  foreach ($this->format_box_services($box_data[3]) as $_option) :
   $options_ .= '<option value="' . ucwords(strtolower($_option)) . '">' . ucwords(strtolower($_option)) . '</option>';
  endforeach;
  $formid = "'" . "redeem_v" . "'";
  $_table = '<div class="row text-center">
        <div class="voucher_result_bar validity_bar">
          <div class="voucher_no">
              VOUCHER NUMBER
          </div> 
          <div class="voucher_no_value mobb_right">
              ' . $data[0] . '
          </div>
          <div class="voucher_status">
              STATUS
          </div>
          <div class="voucher_status_value mobb_right">
          ' . $this->get_v_status_name($data[1]) . '
          </div>
           <div class="voucher_status_value mobile_view mob_bold">
        BOX NAME | DESCRIPTION
          </div>
          <div class="box_name_select col-md-4">
            <select name="rservice" id="rservice" class="redeem-select">
                               <option value="nn">' . $box_data[0] . '</option> 
                ' . $options_ . '

            </select>
          </div>
          <div class="voucher_status_value mobile_view mob_bold">
        ENTER A BOOKING DATE
          </div>
          <div class="booking_date col-md-2 border_right nomargin_lr">
              <span class=""> <img src="../shared/img/icons/icn-calendar-blue.svg" class="booking_date_input"/></span>
              <input type="hidden" name="voucher" value="' . $data[0] . '">
              <input type="hidden" name="partner_pay_amount" value="' . $box_data[4] . '">
              <input type="hidden" name="partner" value="' . $box_data[2] . '">
              <input type="text" id="booking_date" name="booking_date" class="form-control " placeholder="Enter booking date">
          </div>
          <button type="button" onclick="redeem_voucher(' . $formid . ')" class="voucher_partner2 col-md-2 hap_success">REDEEM VOUCHER</button>
        <div> 
      </div>';
  return $_table;
 }

 function ship_type_form($item, $type) {
  $e_box = $p_box = '';
  if ($type == 2) {
   $e_box = 'checked="checked"';
  } elseif ($type == 1) {
   $p_box = 'checked="checked"';
  }
  $p_box_id = "'pbx__" . $item . "'";
  $e_box_id = "'ebx__" . $item . "'";
  $form = '
        <form name="frm_' . $item . '" id="frm_' . $item . '">
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" value="pbox__' . $item . '" onclick="change_ship_type(' . $p_box_id . ')" class="form-check-input" id="pbx__' . $item . '" name="' . $item . '" ' . $p_box . '><b>Physical Delivery *</b>
                    <br><small>Delivered via courier to your door</small>
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" value="ebox__' . $item . '" onclick="change_ship_type(' . $e_box_id . ')" class="form-check-input" id="ebx__' . $item . '" name="' . $item . '" ' . $e_box . '><b>E-Box **</b>
                    <br><small>Delivered via email</small>
                </label>
            </div>
        </form>';
  return $form;
 }
 function letterHead($content) {
  return $html = '
        <html>
        <head>
            <style>
                @page { margin: 0px; }
                /** Define now the real margins of every page in the PDF **/
                body {
                    margin-top: 3cm;
                    margin-left: 100px;
                    margin-right: 100px;
                    margin-bottom: 2cm;
                }
                .header {
                    position: fixed;
                    top: 0cm;
                    left: 0cm;
                    right: 0cm;
                    height: 3cm;
                }
                .footer {
                    position: fixed; 
                    bottom: 0cm; 
                    left: 0cm; 
                    right: 0cm;
                    height: 2cm;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <img src="' . $this->tb64($this->AdminHome() . '/img/header.png') . '" width="100%" height="100%"/>
            </div>
            <div class="footer">
                <img src="' . $this->tb64($this->AdminHome() . '/img/footer.png') . '" width="100%" height="100%"/>
            </div>
            <main>
                ' . $content . '
            </main>
        </body>
    </html>
        ';
 }
}
