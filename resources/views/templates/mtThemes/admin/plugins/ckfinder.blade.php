<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
	<title>File manager</title>
	<script>
		var app_url 	= "{{ url('/') }}";
	</script>
</head>
<body>
<script src="{{ asset('/public/templates/mtThemes/admin/plugins/editor/ckfinder/ckfinder.js') }}"></script>
<script>
	CKFinder.start();
</script>

</body>
</html>