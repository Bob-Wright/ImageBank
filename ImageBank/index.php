<!doctype html>
<html lang="En">
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="./.favicon.ico">
   <title>Imagebank Contents</title>

   <link rel="stylesheet" href="./.style.css">
   <script src="./.sorttable.js"></script>
</head>

<body>
<div id="container">
	<h1>ImageBank Contents</h1>
	<h2>This is a collection of images that you may enjoy<br>or use under a <a href="https://creativecommons.org/licenses/by/4.0/">Creative Commons BY license.</a><br>A repository for the ImageBank code is on <a href="https://github.com/Bob-Wright/ImageBank">GitHub.</a></h2>
	<table class="sortable">
	    <thead>
		<tr>
			<th>Filename</th>
			<th>Preview</th>
			<th>Size</th>
<!--	<th>Date Modified</th> --->
		</tr>
	    </thead>
	    <tbody>

<?php

	// Adds pretty filesizes
	function pretty_filesize($file) {
		$size=filesize($file);
		if($size<1024){$size=$size." Bytes";}
		elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
		elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
		else{$size=round($size/1073741824, 1)." GB";}
		return $size;
	}

	$hide=".";

	// Opens directory
	$myDirectory=opendir(".");
	// Gets each entry
	while($entryName=readdir($myDirectory)) {
	   $dirArray[]=$entryName;}
	// Closes directory
	closedir($myDirectory);
	// Counts elements in array
	$indexCount=count($dirArray);
	// Sorts files
	sort($dirArray);
	// Loops through the array of files
	for($index=0; $index < $indexCount; $index++) {
	// Decides if hidden files should be displayed, based on query above.
	    if(substr("$dirArray[$index]", 0, 1)!=$hide) {

	// Resets Variables
		$favicon="";
		$class="file";

	// Gets File Names
		$name=$dirArray[$index];

	// Separates directories, and performs operations on those directories
		if(is_dir($dirArray[$index]))
		{
				$extn="&lt;Directory&gt;";
				$size="&lt;Directory&gt;";
				$sizekey="0";
				$class="dir";
			// Gets favicon.ico, and displays it, only if it exists.
				if(file_exists("$name/favicon.ico"))
					{
						$favicon=" style='background-image:url($name/favicon.ico);'";
						$extn="&lt;Website&gt;";
					}
			// Cleans up . and .. directories
				if($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($name/.favicon.ico);'";}
				if($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;";}
		}
	// Output
	$extn=pathinfo($dirArray[$index], PATHINFO_EXTENSION);
	// Gets and cleans up file size
	$size=pretty_filesize($dirArray[$index]);
	$sizekey=filesize($dirArray[$index]);

	echo("
		<tr class='$class'>
			<td><a href='./$name' class='name'>$name</a></td>
			<td><a href='./$name'><img src='./$name' width=50% height=auto></a></td>
			<td sorttable_customkey='$sizekey'><a href='./$name'>$size</a></td>
	 	</tr>");
	   }
	}
//			<td sorttable_customkey='$timekey'><a href='./$name'>$modtime</a></td>
	?>

	</tbody>
</table>
</div>
</body>
</html>
