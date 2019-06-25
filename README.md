# php-ftp-library
This FTP Library makes easier to connect ftp, file upload, download, delete and others.

    <?php
    $ftp = new FTP(true); // If set true, you get the error messages.
    if($ftp->connect("ftp_server_name","ftp_server_user","ftp_server_password")){
      echo "Connection successful.";
    }
    $ftp->upload("MyFile.txt","ServerFile.txt","ascii"); Returns BOOLEAN
    $ftp->download("ServerFile.txt","MyFile.txt","ascii"); Returns BOOLEAN
    $ftp->delete_file("ServerFile.txt"); Returns BOOLEAN
    $ftp->delete_dir("ServerDirectory"); Returns BOOLEAN
    $ftp->list_files("."); Returns ARRAY
    $ftp->rename("OldServerFileOrDirectoryName","NewServerFileOrDirectoryName"); Returns BOOLEAN
