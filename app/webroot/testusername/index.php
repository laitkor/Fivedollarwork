<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script>
function checkusername(uvalue){
if(uvalue!="")
{
	 $.ajax({ url: "checkuser.php", data: {q:uvalue} })
    .success(function(msg) {$('#msg').html(msg)})
    .error(function() { alert("error"); })    
}
}
</script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="" method="post">
<input name="username" type="text"  onkeyup="checkusername(this.value)" />
<div id="msg" ></div>

</form>
</body>
</html>