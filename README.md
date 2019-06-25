# php-ftp-library
This FTP Library makes easier to connect ftp, file upload, download, delete and others.

<?php
$ftp = new FTP(true); // If set true, you get the error messages.
if($ftp->connect("ftp_server_name","ftp_server_user","ftp_server_password")){
  echo "Connection successful."
}
