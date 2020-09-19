<?php
require_once 'softoffice/autoload.php';

$phpWord = new \PhpOffice\PhpWord\PhpWord();

$section = $phpWord->addSection();
$header = array('size' => 16, 'bold' => true);
$tableStyle = [
    'borderColor' => '006699',
    'borderSize'  => 6,
    'cellMargin'  => 50
];
$imgStyle = [
    'width' => 100,
    'height' => 100,
    'marginTop' => -1,
    'marginLeft' => -1,
    'wrappingStyle' => 'behind'
];
$imgData = "https://icons.iconarchive.com/icons/hopstarter/sleek-xp-basic/256/Barcode-icon.png";
$rows = 10;
$cols = 5;
$section->addText('HappyBox Inventory Barcodes', $header);
$table = $section->addTable($tableStyle);
for ($r = 1; $r <= 8; $r++) {
    $table->addRow();
    $table->addCell(1750)->addImage($imgData, $imgStyle);
    $table->addCell(1750)->addText("the value hre");
    $table->addCell(1750)->addText("the value hre");
}
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save(time().'helloWorld.docx');
?>