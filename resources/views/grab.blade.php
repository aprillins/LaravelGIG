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
	{!! Form::open(['url' => '', 'method' => 'POST']) !!}
	<table>
		<tr>
			<td>Keyword</td>
			<td>{!! Form::text('keyword') !!}</td>
		</tr>
		<tr>
			<td></td>
			<td>{!! Form::submit('Search') !!}</td>
		</tr>
	</table>
	{!! Form::close() !!}
</div>
</body>
</html>