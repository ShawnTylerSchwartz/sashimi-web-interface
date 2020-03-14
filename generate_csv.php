<?php    
	$directory = $_GET['dir'];
	$dir_split = explode("/", $directory);
	$fam_only = $dir_split[1];
	$dataloc = "_metadata.txt";

	// $txt='segmentdata_'.$fam_only.'_'.date('m-d-Y_hms').'.csv';
	$txt='segmentdata_'.date('m-d-Y_hms').'.csv';

    if(!file_exists($txt)) {
        $fh = fopen($txt, 'a');
        $txtheader = "#filename" . ',' . "file_size" . ',' . "file_attributes" . ',' . "region_count" . ',' . "region_id" . ',' . "region_shape_attributes" . ',' . "region_attributes" . "\n";
        fwrite($fh,$txtheader); // Write information to the file
        $fin = fopen($dataloc, "r");
        $datas = [];
        // https://stackoverflow.com/questions/1372223/reading-from-comma-or-tab-delimited-text-file
        while(!feof($fin)) {
        	// $data = fgetcsv($fin, 1000, "\t");
        	$line = fgets($fin, 2048);
        	// echo $line;
        	$datatmp = str_getcsv($line, "\t");
        	// print_r($datatmp);
        	array_push($datas, $datatmp);
        }

        fclose($fin);

        // remove the last empty part of the $datas array (EOL)
        array_pop($datas);

        foreach($datas as $i => $data) {
        	$originalfilename = explode("/", $data[0])[2];
        	$filterterm = explode("/", $data[0])[1];
        	//TODO:check to make sure the selected class of images are properly parsed (based on POST request)
        	// if($filterterm == $fam_only) {
        		$fsize = filesize($data[0]);
				$file_attributes = "{}";
				$region_count = 1;
				$region_id = 0;
				$xs = $data[4];
				$ys = $data[5];

				$region_shape_attributes = "{\"\"name\"\":\"\"polygon\"\",\"\"all_points_x\"\":" . $xs . ",\"\"all_points_y\"\":" . $ys . "}";
				$region_shape_attributes_arr[] = "\"".$region_shape_attributes."\"";

				$region_attributes = "{\"\"name\"\":\"\"" . $filterterm . "\"\"}";
				$region_attributes_arr[] = "\"".$region_attributes."\"";

				$data_cat = $originalfilename . ',' . $fsize . ',' . $file_attributes . ',' . $region_count . ',' . $region_id . ',' . $region_shape_attributes_arr[$i] . ',' . $region_attributes_arr[$i] . "\n";

				fwrite($fh,$data_cat);
        	// }
	    }
	    fclose($fh); // Close the file
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/csv');
	    header("Content-Disposition: attachment; filename=" . $txt);
	    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	    readfile($txt); // download temp file on server
	    unlink($txt); // delete temp file from server
    }

?>