# php-ftp-library
This FTP Library makes easier to connect ftp, file upload, download, delete and others.

    <?php
    $ftp = new FTP(true); // If set true, you get the error messages.
    if($ftp->connect("ftp_server_name","ftp_server_user","ftp_server_password")){
      echo "Connection successful.";
    }
    // Upload a file to ftp server. Zip and some of other files you should set mode ascii to binary.
    $ftp->upload("MyFile.txt","ServerFile.txt","ascii"); Returns BOOLEAN
    
    // Download a file from ftp server. Zip and some of other files you should set mode ascii to binary.
    $ftp->download("ServerFile.txt","MyFile.txt","ascii"); Returns BOOLEAN
    
    // Delete a file from ftp server.
    $ftp->delete_file("ServerFile.txt"); Returns BOOLEAN
    
    // Delete a directory from ftp server.
    $ftp->delete_dir("ServerDirectory"); Returns BOOLEAN
    
    // List the files in the given path of ftp server.
    $ftp->list_files("."); Returns ARRAY
    
    // Rename a file or directory in ftp server.
    $ftp->rename("OldServerFileOrDirectoryName","NewServerFileOrDirectoryName"); Returns BOOLEAN
