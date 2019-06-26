<?php
/**
 * Class FTP
 * @author Doğukan Akkaya
 */
class FTP
{
    protected $ftpID = "";
    protected $debugging = false; // If true, shows error messages. You can set in the constructor
    protected $mode = FTP_ASCII;
    protected $server_name = "";
    /**
     * FTP __construct
     * @param $debugging = false
     */
    public function __construct($debugging = false)
    {
        ini_set('display_errors', 0);
        $this->debugging = $debugging;
    }
    /**
     * FTP connect 
     * @param $ftp_server
     * @param $ftp_server_user
     * @param $ftp_server_pass
     * @return bool
     * This method allows us to connect to ftp server
     */
    public function connect($ftp_server, $ftp_server_user, $ftp_server_pass)
    {
        $this->ftpID = ftp_connect($ftp_server);
        $conn = ftp_login($this->ftpID, $ftp_server_user, $ftp_server_pass);
        if (!$this->ftpID) {
            if ($this->debugging) {
                echo "Connection is failed. Check your server name.";
            }
            return false;
        } elseif (!$conn) {
            if ($this->debugging) {
                echo "Connection is failed. Username and password doesn't match.";
            }
            return false;
        } else {
            $this->server_name=$ftp_server;
            return true;
        }
    }
    /**
     * FTP upload
     * @param $localfile
     * @param $remote_file
     * @param $mode = FTP_ASCII
     * @return bool
     * This method allows us to upload a file to server
     */
    public function upload($localfile, $remote_file, $mode = FTP_ASCII)
    {
        $this->mode = $mode == "ascii" ? FTP_ASCII : FTP_BINARY;
        if (!ftp_put($this->ftpID, $remote_file, $localfile, (int)$this->mode)) {
            if ($this->debugging) {
                if (!file_exists($localfile)) {
                    echo "No file with this name in your local. Please check the source path.";
                }
            }
            return false;
        } else {
            return true;
        }
    }
    /**
     * FTP download
     * @param $localfile
     * @param $remote_file
     * @param $mode = FTP_ASCII
     * @return bool
     * This method allows us to download a file from server
     */
    public function download($localfile, $remote_file, $mode = FTP_ASCII)
    {
        $this->mode = $mode == "ascii" ? FTP_ASCII : FTP_BINARY;
        if (!ftp_get($this->ftpID, $localfile, $remote_file, $this->mode)) {
            if ($this->debugging) {
                if (!file_exists($remote_file)) {
                    echo "No file with this name in this server. Please check the path.";
                }
            }
            return false;
        } else {
            return true;
        }
    }
    /**
     * FTP delete_file
     * @param $remote_file
     * @return bool
     * This method allows us to delete a file from server
     */
    public function delete_file($remote_file)
    {
        if (!ftp_delete($this->ftpID, $remote_file)) {
            if ($this->debugging) {
                if (!file_exists($remote_file)) {
                    echo "No file with this name in this server. Please check the path.";
                } elseif (is_dir($remote_file)) {
                    echo "This method is only for files. Not directories. You can use delete_dir method for that.";
                }
            }
            return false;
        } else {
            return true;
        }
    }
    /**
     * FTP delete_dir
     * @param $remote_dir
     * @return bool
     * This method allows us to delete a directory from server
     */
    public function delete_dir($remote_dir)
    {
        if (!ftp_rmdir($this->ftpID, $remote_dir)) {
            if ($this->debugging) {
                if (!is_dir($remote_dir)) {
                    echo "This function deletes only directories. If you want to delete file you can use delete_file method.";
                }
            }
            return false;
        } else {
            return true;
        }
    }
    /**
     * FTP list_files
     * @param $path = "."
     * @return array
     * This method shows us our files in the given path of server
     */
    public function list_files($path = ".")
    {
        return ftp_nlist($this->ftpID, $path);
    }
    /**
     * FTP rename
     * @param $oldname
     * @param $newname
     * @return bool
     * This method allows us to rename a file or folder in server
     */
    public function rename($oldname, $newname)
    {
        if (!ftp_rename($this->ftpID, $oldname, $newname)) {
            if ($this->debugging) {
                if (!file_exists($oldname) && !is_dir($oldname)) {
                    echo "There is no file or directory with this name.";
                }
            }
            return false;
        } else {
            return true;
        }
    }
     /**
     * FTP ftprealpath
     * @param $directory_name
     * @param $ssl
     * @return string
     * This method gives us the realpath of our ftp server
     */
    public function ftprealpath($directory_name = "", $ssl = "")
    {
        $rp = "<?php" . PHP_EOL;
        $rp .= 'echo realpath("");';
        file_put_contents("path.php", $rp);
        if (!$this->upload("path.php", "path.php")) {
            echo "There was an error while uploading path.php file to your server";
            return false;
        }
        $ch = curl_init($ssl . $this->server_name . "/" . $directory_name . "/path.php");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1
        ]);
        $absolutepath = curl_exec($ch);
        curl_close($ch);
        if ($this->debugging) {
            if (!file_exists("path.php")) {
                echo "File path.php doesn't created on your local server, so we can't get path.";
            }
            return false;
        }
        unlink("path.php");
        return $absolutepath;
    }
}
