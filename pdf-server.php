<?php 
/*
header("Content-Type: image");

$file = 'image/'.$_GET["file"] .".pdf";
header("Content-Disposition: image; filename=" . urlencode($file));   
header("Content-Type: image");
header("Content-Type: image");
header("Content-Description: File Transfer");            
header("Content-Length: " . filesize($file));
flush(); // this doesn't really matter.
$fp = fopen($file, "r");
while (!feof($fp))
{
    echo fread($fp, 65536);
    flush(); // this is essential for large downloads
} 
fclose($fp); 
*/

header("Content-Type: image");
//if($_GET["file"] == 'Mens_Shoe_Size_Measurer1' || $_GET["file"] == 'Mens_Shoe_Size_Measurer2')
//{
if($_GET["file"] == 'Mens-Shoe-Size-Measurer1')
$file = 'image/mens-shoe-size-finder-top-copy-footlounge.jpg';

else if($_GET["file"] == 'Mens-Shoe-Size-Measurer2')
$file = 'image/mens-shoe-size-finder-bottom-copy-footlounge.jpg';

else if($_GET["file"] == 'Womens-Shoe-Size-Measurer1')
$file = 'image/womens-shoe-size-finder-top-copy-footlounge.jpg';

else if($_GET["file"] == 'Womens-Shoe-Size-Measurer2')
$file = 'image/womens-shoe-size-finder-bottom-copy-footlounge.jpg';

else if($_GET["file"] == 'KIDS-SHOE-SIZER1')
$file = 'image/kids-shoe-size-finder-top-copy-footlounge.jpg';    

else if($_GET["file"] == 'KIDS-SHOE-SIZER2')
$file = 'image/kids-shoe-size-finder-bottom-copy-footlounge.jpg'; 
/*$files = array('image/foot_lounge_know_your_size_mens_top_copy.jpg', 'image/foot_lounge_know_your_size_mens_bottom_copy.jpg');
$zipname = 'file.zip';
$zip = new ZipArchive;
$zip->open($zipname, ZipArchive::CREATE);
foreach ($files as $file) {
  $zip->addFile($file);
}
$zip->close();

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . filesize($zipname));
readfile($zipname); */

header("Content-Disposition: image; filename=" . urlencode($file));   
header("Content-Type: image");
header("Content-Type: image");
header("Content-Description: File Transfer");            
header("Content-Length: " . filesize($file));
flush(); // this doesn't really matter.
$fp = fopen($file, "r");
while (!feof($fp))
{
    echo fread($fp, 65536);
    flush(); // this is essential for large downloads
} 
fclose($fp); 

/*}
else
{


$file = 'image/'.$_GET["file"] .".pdf";

 
header("Content-Disposition: image; filename=" . urlencode($file));   
header("Content-Type: image");
header("Content-Type: image");
header("Content-Description: File Transfer");            
header("Content-Length: " . filesize($file));
flush(); // this doesn't really matter.
$fp = fopen($file, "r");
while (!feof($fp))
{
    echo fread($fp, 65536);
    flush(); // this is essential for large downloads
} 
fclose($fp); 
}*/


/*
header("Content-Type: image");

$file = 'image/foot_lounge_know_your_size_mens_bottom_copy.jpg';

$files = array('image/foot_lounge_know_your_size_mens_top_copy.jpg', 'image/foot_lounge_know_your_size_mens_bottom_copy.jpg');
$zipname = 'file.zip';
$zip = new ZipArchive;
$zip->open($zipname, ZipArchive::CREATE);
foreach ($files as $file) {
  $zip->addFile($file);
}
$zip->close();

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . filesize($zipname));
readfile($zipname); */

/*
header("Content-Disposition: image; filename=" . urlencode($file));   
header("Content-Type: image");
header("Content-Type: image");
header("Content-Description: File Transfer");            
header("Content-Length: " . filesize($file));
flush(); // this doesn't really matter.
$fp = fopen($file, "r");
while (!feof($fp))
{
    echo fread($fp, 65536);
    flush(); // this is essential for large downloads
} 
fclose($fp); */

?>