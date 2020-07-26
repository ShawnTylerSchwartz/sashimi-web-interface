<?php
	session_start();

	include 'snippets/header.php';
	include 'snippets/main.php';
?>

<p class="lead">Please enter your <strong>email</strong> or a <strong>unique identifier</strong> below to get started.</p>

<?php
	// define function getAllDirs
	// (return first level img directories)
	function getAllDirs($directory, $directory_seperator) {
		$dirs = array_map(function ($item) use ($directory_seperator) {
    		return $item . $directory_seperator;
		}, array_filter(glob($directory . '*'), 'is_dir'));

		foreach ($dirs as $dir) {
    		$dirs = array_merge($dirs, getAllDirs($dir, $directory_seperator));
		}
	
		return $dirs;
	}

	// path to directory to scan 
	$directory = "input/";
 	$directory_seperator = "/";

	$alldirs = getAllDirs($directory, $directory_seperator);
 	
 	// print each file name into list with link to next-level of image directory
 	foreach($alldirs as $dir) {

 		//path to directory to scan
		$directory = $dir;
 
		//get all image files with a .jpg extension.
		$images = glob($directory . "*.jpg");

		$block = 1024*1024; //1MB for file read in
		$tmpstorage = array();
		if ($fh = fopen("_metadata.txt", "r")) { 
    		$left='';
    		while (!feof($fh)) { // read in file
       			$temp = fread($fh, $block);  
       			$fgetslines = explode("\n",$temp);
       			$fgetslines[0]=$left.$fgetslines[0];
       			if(!feof($fh) )$left = array_pop($lines);           
       				foreach ($fgetslines as $k => $line) {
		       			$completedComponents = explode("\t", $line);
						array_push($tmpstorage, $completedComponents[0]);
	       			}
       		} 	
		}

		fclose($fh); // close file stream

		$numCompleted = 0;

		foreach ($images as $image) {
			if (in_array($image, $tmpstorage)) {
				$numCompleted++;
			} else {
				break;
			}

			$totalNumImgs = count($images);
			$percentCompleted = (($numCompleted+1) / $totalNumImgs) * 100;
			$numRemaining = $totalNumImgs - ($numCompleted);
			
			if ($numCompleted != 0) {
				$percentCompleted = (($numCompleted) / $totalNumImgs) * 100;
				$numRemaining = $totalNumImgs - ($numCompleted);
			} else {
				$percentCompleted = 0;
				$numRemaining = $totalNumImgs - ($numCompleted);
			}
		}
 	}
?>

 	<?php echo '<form class="form-signin text-center" name="login" action="specimen_list.php?' . SID . '" method="post">'; ?>
      <label for="inputEmail" class="sr-only">Username</label>
      <input type="text" id="inputUsername" name="emailaddress" class="form-control" placeholder="Email Address or Unique Identifier" required autofocus>
      <p></p>
      <button class="btn btn-primary text-center" id="view-fullscreen" type="submit" name="submit" value="Submit">Launch Interface <i class="fas fa-rocket"></i></button>
    </form>

    <p></p>

    <div class="alert alert-info" role="alert">
  		<i class="fas fa-info-circle"></i> This login information will only be used to identify which images were processed by the same person in statistical analyses.
  		<br /><br />
  		If you are a returning participant, you should use the same identifier each time. <strong>Your email address or chosen unique identifier will not be stored</strong>.
  		<br /><br />
		For any questions regarding the interface, please email <strong>shawnschwartz@ucla.edu</strong> with the subject line [<em>sashimi</em> Interface Inquiry]. Thank you.
	</div>

<?php include 'snippets/footer.php'; ?>