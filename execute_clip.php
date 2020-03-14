<?php
    session_start();

    $seshID = session_id();

    $date   = new DateTime();
    $readableDate = $date->format('m-d-Y,h:i:sa');

if($_POST) {
	
    // define('UPLOAD_DIR', 'uploads-test/');
    $img = $_POST['image'];
    $img = str_replace('data:image/png;base64,', '', $img);
   
    $img = str_replace(' ', '+', $img);

    $cur_img = $_GET['image'];

    $all_x_points = $_GET['xpts'];
    $all_y_points = $_GET['ypts'];

    //new version assuming no spaces
    $noext = explode(".", $cur_img);
    $noslash = explode("/", $noext[0]);
    $originalfilename = $noslash[2];
    $categoryname = $noslash[1];
    $exportPath = "output/" . $categoryname . "/";
    $name = $originalfilename;
    print($name);
    //old version for fish file names with spaces
    // $nospace = explode(" ", $cur_img);
    // $noext = explode(".", $nospace[1]);
    // $noslash = explode("/", $nospace[0]);
    // $sepgenus = explode("_", $noslash[2]);
    // $exportPath = "output/" . $noslash[1] . "/";  
    // $name = $noslash[1] . "_" . $sepgenus[1] . "_" . $noext[0];

    if(!is_dir($exportPath)) {
        mkdir($exportPath);
    }
   
    $dataimg = base64_decode($img);
    
    $nameimg = $exportPath . $name;
    $fileimg = $nameimg . '.png';
    $successimg = file_put_contents($fileimg, $dataimg);
    echo $nameimg;

    $txt = "_metadata.txt";

    if(!file_exists($nameimg)) {
        $fh = fopen($txt, 'a'); 
        $txt = $cur_img . "\t" . $name . "\t" . $readableDate . "\t" . $seshID . "\t" . $all_x_points . "\t" . $all_y_points . "\n"; 
        fwrite($fh,$txt); // Write information to the file
        fclose($fh); // Close the file
    }
}
?>