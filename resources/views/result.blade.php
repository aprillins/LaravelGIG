<!doctype html>
<html>
<head>
	<title>Grabber</title>
</head>
<style type="text/css">
*{
	margin: 0;
	padding: 0;
	outline: 0;
	text-decoration: none;
}

.container{
	width: 800px;
	margin: 1em auto;
}

</style>
<body>
<div class="container">

	{!! link_to('/', 'Home') !!} <br>

	<?php
		//print_r($googleResponseResults);
	?>
	<ul>
		 
	@foreach($googleResponseResults as $key => $result)
		<li>{!! link_to($result->unescapedUrl, $result->titleNoFormatting) !!} - {!! link_to_action('GrabberController@saveImage', 'Save image', ['url' => urlencode($result->unescapedUrl)]) !!}</li>
	@endforeach
		
		
	</ul>
</div>
</body>
</html>