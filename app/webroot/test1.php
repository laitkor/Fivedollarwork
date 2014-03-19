<?php
#$filename="/var/www/fiverrclone/app/webroot/abc.doc";
#$content = shell_exec('/usr/bin/antiword '.$filename);
#echo $content;
$filename="/var/www/fiverrclone/app/webroot/abc.doc";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
echo $contents;
?>
