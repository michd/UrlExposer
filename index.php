<?php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
	require_once('engine/urlexposer.php');
	if($_POST and isset($_POST['input_url']))
	{
		$input_url = $_POST['input_url'];
		$exposer = new UrlExposer($input_url);
		$output_url = $exposer->result;	
		$step_count = $exposer->step_count;
	}
?>
<!doctype html>
<html>
	
<head>
	<title>UrlExposer</title>	
</head>

<body>
	<h1>UrlExposer</h1>
	<p>
		UrlExposer let's you see the URL of the page you will eventually reach by following a shortened link, thereby <em>exposing</em> its true goal.
	</p>
	<form method="post" action="/">
		<fieldset>
			<div>
				<label for="input_url">Input URL:</label>
				<input type="text" name="input_url" id="input_url" value="<?php echo isset($input_url) ? $input_url : ''; ?>">
				<input type="submit" value="Expose">
			</div>
			<?php if(isset($output_url)): ?>
			<div>
				<label>Result:</label>
				<output>
					<p>
						<a href="<?php echo $output_url; ?>"><?php echo $output_url; ?></a>
					</p>
					<p>
						Getting to this URL took <?php echo $step_count; ?> steps.
					</p>
				</output>
			</div>
			<?php endif; ?>
		</fieldset>
	</form>
	
	<footer>
		<p>UrlExposer was first written by <a href="http://michhimself.com">Micha&euml;l Duerinckx</a> on 27/12/2012.</p>
		<p>UrlExposer is open-source. <a href="https://github.com/michd/UrlExposer">Fork it on GitHub</a>.
	</footer>
</body>

</html>