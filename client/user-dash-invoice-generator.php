<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Order.php');
require_once('../lib/Box.php');
require_once('../lib/Picture.php');
require_once('../lib/Inventory.php');
$util = new Util();
$user = new User();
if (!$util->is_client()) {
 header('Location: user-login.php');
}
$picture = new Picture();
$util->ShowErrors(1);
$box = new Box();
$token = json_decode($_SESSION['usr'])->access_token;
$order_ = new Order($token);
$user_info = json_decode($_SESSION['usr_info']);
$my_list_ = $order_->get_bycustomer($user_info->data->internal_id);
$my_list_ = json_decode($my_list_, true)['data'];
// $util->Show($my_list_);

$selected_order_id = filter_input(INPUT_GET, "order");
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="utf-8">
 <meta name="description" content="">
 <meta name="author" content="">
 <title>HappyBox :: Invoice Generator</title>

 <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; 
 ?>
</head>

<body class="invoice_body">
<?php
if (count($my_list_)) {
 foreach ($my_list_ as $_list) :
  $current_order_id = $_list['order_id'];
  if ($selected_order_id == $current_order_id) {
   // echo '<pre>';
   // print_r($_list);
   // echo '</pre>';
   ?>
   <!-- Invoice Page -->
   <div id="printable" style="width:595.28pt;height:841.89pt;margin:30px auto;padding:0;overflow-x:hidden;background:#fff;">
    <div style="width:90%;margin:auto;padding-top:12px;padding-bottom:12px;" class="mob_100">
     <table style="width:100%;border:none;" cellspacing="0" cellpadding="0">
      <tr>
       <td style="width:50%;vertical-align:middle;border:none;"><span style="color:#c20a2b;font-size:49px;font-weight:bold;">INVOICE</span></td>
       <td style="vertical-align:middle;border:none;" align="right"><a href="<?= $util->ClientHome() ?>/" target="_blank"><img src="<?= $util->AppHome() ?>/shared/img/happy_logo.png" alt="" style=" width:auto;float:right;height:70px;" /></a></td>
      </tr>
     </table>
    </div>
    <div style="width:90%;margin:auto;padding-top:12px;padding-bottom:12px;" class="mob_100">
     <table style="width:100%;border:none;margin-bottom:50px;" cellspacing="0" cellpadding="0">
      <tr>
       <td style="width:35%;margin-bottom:8px;height: 26px;background:#00acb3;color:white;font-weight:bold;padding:7px 30px;border-radius:7px;border:none;"> BILL FROM </td>
       <td style="width:30%;border:none;"></td>
       <td style="width:35%;margin-bottom:8px;background:#00acb3;height:26px;color:white;font-weight:bold;padding:7px 30px;border-radius:7px;border:none;" align="right"> BILL TO </td>
      </tr>
      <tr>
       <td style="width:35%;vertical-align:top;border:none;"><span style="font-size:20px;font-weight:bold;">HAPPYBOX</span><br>
        <span>P.O. BOX 30275 – Nairobi 00100</span><br>
        <span><strong>PIN No.</strong> P051767160R</span>
       </td>
       <td style="width:30%;border:none;"></td>
       <td style="width:35%;vertical-align:top;border:none;" align="right"><span style="font-size:20px;font-weight:bold;"><?= $user_info->data->fname . " " . $user_info->data->sname ?></span><br>
        <span><?= $user_info->data->location ?></span>
       </td>
      </tr>
     </table>
     <div style="width:100%;" id="invoiceData">
      <table class="table purchase_hist table-bordered" id="<?= $current_order_id ?>">
       <tr class="purch_hist_tr_td">
        <td class="b">ORDER NUMBER</td>
        
        <td colspan="4" class="invisible_table" style="background-color:#FFF;"></td>
        <td><?= $current_order_id ?></td>
       </tr>
       <tr class="purch_hist_tr_td">
         <!-- <th class="b col_1">IMAGE</th>-->
        <th>BOX NAME</th>
        <th>BOX NUMBER</th>
        <!-- <th>VOUCHER CODE</th> -->
        <th>PURCHASE DATE</th>
        <th>BOX TYPE</th>
        <th>QUANTITY</th>
        <th class="purc_last_td">COST</th>
       </tr>
       <?php
       $this_order = $current_order_id;
       $order_full = json_decode($_list['order_string'], true);
       $draft_cart = [];
       $bx_internal_id = "";
       foreach ($order_full as $_cart_item) :
        if (isset($_cart_item['order_id'])) {
        } elseif (isset($_cart_item['physical_address'])) {
        } else {
         $draft_cart[] = $_cart_item;
         $bx_internal_id = $_cart_item[0];
         $_box_data = json_decode($box->get_byidf('00', $_cart_item[0]))->data;
         $_b_cost = floor($_cart_item[1] * $_box_data->price);
         $_media = $picture->get_byitem('00', $_cart_item[0]);
         $_media = json_decode($_media, true)['data'];
         $_3d = 'shared/img/Box_Mockup_01-200x200@2x.png';
         foreach ($_media as $_mm) {
          if ($_mm['type'] == '2') {
           $_3d = $_mm['path_name'];
          }
         }
         if ($_cart_item[2] == 2) {
          /** ebox */
          ?>
          <tr>
           <!--<td class="purch_img"><img style="max-width:100px;" class="img-fluid d-block mx-auto purch_his_img" src="<?= $util->tb64($_3d) ?>"></td>-->
           <td class="purch_blue_td"><b><?= $_box_data->name ?></b></td>
           <td class="purch_blue_td"><b><?= $_box_data->internal_id ?></b></td>

           <!-- <td class="purch_blue_td"><b><?= $_box_data->id ?></b></td>-->
           <td class=""><b><?= date('d/m/Y', strtotime($_list['updated_at'])) ?></b></td>


           <!-- <td class="purch_blue_td"><b><?= date('d/m/Y', strtotime($_list['updated_at'])) ?></b></td>-->

           <td>E-box</td>
           <td><?= $_cart_item[1] ?></td>
           <td>KES <?= number_format($_b_cost, 2) ?></td>
          </tr>
         <?php
         } else {
         ?>
          <tr>
           <td class="purch_img"><img style="max-width:100px;" class="img-fluid d-block mx-auto purch_his_img" src="<?= $util->tb64($_3d) ?>"></td>
           <td class="purch_blue_td"><b><?= $_box_data->name ?></b></td>

           <td class="purch_blue_td"><b><?= $_box_data->internal_id ?></b></td>

           <td class=""><b><?= date('d/m/Y', strtotime($_list['updated_at'])) ?></b></td>

           <!--<td class="purch_blue_td"><b><?= $_box_data->internal_id ?></b></td>-->
           <!--  <td class="purch_blue_td"><b><?= date('d/m/Y', strtotime($_list['updated_at'])) ?></b></td>-->
           <td>Physical Box</td>
           <td><?= $_cart_item[1] ?></td>
           <td>KES <?= number_format($_b_cost, 2) ?></td>
          </tr>
          <?php
         }
        }
       endforeach;
       ?>
       <tr class="">
        <td colspan="5" class="td_noborder">
         <input type="hidden" name="internal_id" value='<?= $bx_internal_id ?>' />
        </td>
        <?php
        // unset($draft_cart);
        ?>
        <td colspan="3" align="right" class="td_no_pad">
         <table>
          <tr>
           <td>SUB TOTAL (Incl. VAT)</td>
           <td class="purc_last_td">KES <?= number_format($_list['subtotal'], 2) ?></td>
          </tr>
          <tr>
           <td>SHIPPING</td>
           <td>KES <?= number_format($_list['shipping_cost'], 2) ?></td>
          </tr>
          <tr class="bold_txt">
           <td>TOTAL PRICE (Incl. VAT)</td>
           <td>KES <?= number_format($_list['order_totals'], 2) ?></td>
          </tr>
         </table>
        </td>
       </tr>
      </table>
     </div>
     <table style="width:100%;border:none;margin-top:50px;border:none;" cellspacing="0" cellpadding="0">
      <tr>
       <td style="border:none;" align="right"><span style=" text-align:left;font:normal normal bold 20px/45px Segoe Script;letter-spacing:0px;color:#FFFFFF;text-shadow:0px 3px 6px #00000029;background:#00acb3;border-radius:6px;padding:2px 8px;">Thank you for your business! </span></td>
      </tr>
     </table>
     <div style="width:100%;margin:auto;color:#999999;padding-top:70px;text-align:center;" class="mob_100">
      <p> If you have any questions about this invoice, please contact us <br>
       by email <a href="mailto:customerservices@happybox.ke" style="color:#999999;">customerservices@happybox.ke</a> or by phone <a style="color:#999999;" href="tel:254112454540">+254 112 454 540 </a> </p>
     </div>
    </div>
   </div>
   <!-- End Invoice Page -->
<?php
  }
 endforeach;
}
?>

 <!-- Bootstrap core JavaScript -->
 <?php include '../shared/partials/js.php'; 
 ?>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-alpha.12/dist/html2canvas.js"></script>
 <script>
  $(document).ready(function() {
   html2canvas(document.getElementById("printable")).then(canvas => {
    var imgData = canvas.toDataURL("image/jpeg", 1);
    var pdf = new jsPDF("p", "pt", "a4");
    var pageWidth = pdf.internal.pageSize.getWidth();
    var pageHeight = pdf.internal.pageSize.getHeight();

    pdf.addImage(imgData, 'JPEG', 0, 30, pageWidth, pageHeight);
    pdf.save("INV-<?= $selected_order_id ?>.pdf");
   });
  });
 </script>
</body>

</html>