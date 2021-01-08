<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Box.php');
require_once('../lib/Inventory.php');
require_once('../pdfer/autoload.inc.php');
require_once('../softoffice/autoload.php');
$util = new Util();
$user = new User();
$inventory = new Inventory();
$util->ShowErrors(1);
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
$box = new Box();
use Dompdf\Dompdf;
// instantiate and use the dompdf class
if(isset($_POST['downloadit'])){
    $dompdf = new Dompdf();
    $dompdf->loadHtml($util->letterHead($_SESSION['barcode_rows'][0]));
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream(str_replace(' ', '-', $_SESSION['barcode_rows'][1]) . '.pdf');
}
// print $util->letterHead($_SESSION['barcode_rows'][0]);
// exit;

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: Admin Portal</title>
        <!-- Bootstrap core CSS -->
        <?php include 'admin-partials/css.php'; ?>
        <style>
            .admin-barcode{
                color: #c20a2b!important;
                text-decoration: none!important;
                border-bottom: solid 2px #c20a2b!important;
            }
            .dt-buttons, .dataTables_filter{
                display:none!important;
            }
        </style>
    </head>

    <body>

        <!-- Navigation -->
        <?php include 'admin-partials/nav.php'; ?>


        <section class="container section_padding_top top_menu">
            <div class="row">
                <div class="col-md-12">
                <?php include 'admin-partials/mid-nav.php'; ?>
                </div>

            </div>
        </section>
        <!--end discover our selection-->
        <section class=" top_blue_bar ">
            <div class="container">
                <div class="row">
                    <div class="col-6 section_title">
                        <h3>BARCODES</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="#" data-toggle="modal" data-target="#generate_box" >GENERATE BARCODES</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12 ">
                        <div class="table-responsive">
                            <?php
                            // print $util->letterHead('hello');
                                $title = 'No Barcodes. Generate some.';
                                $barcode_rows = '
                                <table class="table table_data1 table-bordered" id="report_id">
                                    <thead>
                                        <tr>
                                            <th>Barcode</th>
                                            <th>Voucher</th>
                                            <th>Box Name</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody></table>';
                                if (isset($_POST['generate'])) {
                                    $barcode_rows = '
                                        <form method="post">
                                            <button class="btn btn_view_report" type="submit" name="downloadit" value="Download Codes"> Download PDF</button>
                                        </form>
                                        <table class="table table_data1 table-bordered" id="report_id">
                                            <thead>
                                                <tr>
                                                    <th style="padding:10px;width:40%;">Barcode</th>
                                                    <th style="padding:10px;width:20%;">Voucher</th>
                                                    <th style="padding:10px;width:30%;">Box Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                    if( $_POST['codetype'] != 'nn' && $_POST['boxname'] != 'nn'){
                                        $vtype = 0;
                                        if($_POST['limit']){
                                            $vtype = 1;
                                        }
                                        $box_string = explode('~~', $_POST['boxname']);
                                        $box_name = $box_string[1];
                                        $body = [
                                            'box_internal_id' =>  $box_string[0],
                                            'stock_type' => $vtype
                                        ];
                                        $barcode_type = $_POST['codetype'];
                                        $payload = $inventory->findbarcodes($body);
                                        $vouchers = json_decode($payload, true)['data'];
                                        if(count($vouchers)){
                                            $title = $box_name;
                                            foreach ($vouchers as $_voucher) {
                                                $source = $inventory->barcode_source($_voucher['box_barcode'], $barcode_type);
                                                $src = json_decode($source, true)['source'];
                                                //
                                                $barcode_rows .= '<tr>';
                                                $barcode_rows .= '<td style="padding:10px;text-align:center;"><img src="'.$src.'" alt="'.$box_name.' bar code"/></td>';
                                                $barcode_rows .= '<td style="padding:10px;text-align:center;">'.$_voucher['box_voucher'].'</td>';
                                                $barcode_rows .= '<td style="padding:10px;text-align:center;">'.$box_name.'</td>';
                                                $barcode_rows .= '</tr>';
                                            }
                                        }else{
                                            $title = 'No vouchers found that meet your search criteria';
                                        }
                                        // $util->Show($vouchers);
                                    }
                                    // $title = null;
                                    $barcode_rows .= '</tbody></table>';
                                    $_SESSION['barcode_rows'][0] = $barcode_rows;
                                    $_SESSION['barcode_rows'][1] = $box_name;
                                }
                            ?>
                            <h1><?=$title?></h1>
                            <?=$barcode_rows?>
                        </div>
                    </div>
                 </div>
            </div>
        </section>

<br><br><br>
 <?php include 'admin-partials/footer.php'; ?>
<!-- Bootstrap core JavaScript -->
<?php include 'admin-partials/js.php'; ?>
<div class="modal fade" id="generate_box">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
        <div class="modal-body text-center">
          <div class="col-md-12 text-center forgot-dialogue-borderz">
            <h4 class="">Generate Barcodes</h4>
            <div>
                <form class="filter_form" method="post">
                    <div class="form-group row">
                        <label for="BoxType" class="col-form-label">Box Name</label><br>
                        <select class="form-control" name="boxname" id="">
                            <option value="nn">Select box name</option>
                            <?php 
                                $boxes = json_decode($box->get($token), true)['data'];
                                foreach( $boxes as $ppp ){
                                        print '<option value="'.$ppp['internal_id'].'~~'.$ppp['name'].'">'.$ppp['name'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="BoxType" class="col-form-label">Barcode Type</label><br>
                        <select class="form-control" name="codetype" id="">
                            <option value="nn">Select Barcode Type</option>
                            <option value="C39">C39</option>
                            <option value="C39+">C39+</option>
                            <option value="C39E">C39E</option>
                            <option value="C39E+">C39E+</option>
                            <option value="C93">C93</option>
                            <!-- <option value="S25">S25</option>
                            <option value="S25+">S25+</option>
                            <option value="I25">I25</option>
                            <option value="MSI+">MSI+</option>
                            <option value="POSTNET">POSTNET</option>
                            <option value="QRCODE">QRCODE</option>
                            <option value="PDF417">PDF417</option>
                            <option value="DATAMATRIX">DATAMATRIX</option> -->
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="form-check-inline">
                            <label class="form-check-label" style="color:#000">
                                <input type="checkbox" checked name="limit" class="form-check-input" value="1">Apply Only to vouchers Instock
                            </label>
                        </div>
                    </div>
                    <hr>
                    <div class=" row">
                        <div class="col-md-12 text-right text-white">
                            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                            <button type="submit" name="generate" class="btn btn_view_report">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
      </div>
      </div>
    </div>
  </div>
  <!-- end popup -->
 </body>
 <script>
    $(document).ready(function() {
        $('#report_id').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                // 'copyHtml5',
                // 'excelHtml5',
                // 'csvHtml5'
                'pdfHtml5'
            ]
        } );
    } );
    </script>
</html>
