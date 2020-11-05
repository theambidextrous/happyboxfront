<?php
// Require composer autoload
require_once __DIR__ . '/mpdf/vendor/autoload.php';

// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf([
    'format' => 'A4',
    'margin_left' => 0,
    'margin_right' => 0,
    'margin_top' => 0,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0,
]);

$mpdf->SetDisplayMode('fullpage');

//Get HTML page contents
$html = file_get_contents('evoucher2.php');

// Write some HTML code:
$mpdf->WriteHTML($html);
// Output a PDF file directly to the browser
$mpdf->Output();
$mpdf->Output('testevoucher.pdf', \Mpdf\Output\Destination::FILE);
