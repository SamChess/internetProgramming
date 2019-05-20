<?php
    class FileUploader{
        private static $target_directory;
        private $target_file;
        private static $size_limit;
        private $uploadOk ;
        private $file_original_name;
        private $file_type;
        private $file_size;
        private $final_file_name;
        
        public function __construct(){
		if (isset($_FILES["fileToUpload"]["name"])) {
			FileUploader::$target_directory = "uploads/";
			$this->target_file = FileUploader::$target_directory . basename($_FILES["fileToUpload"]["name"]);
			FileUploader::$size_limit = 5000; //bytes
			$this->uploadOk = false;
			$this->file_original_name = $_FILES["fileToUpload"]["name"];
			$this->file_type = strtolower(pathinfo($this->target_file,PATHINFO_EXTENSION));
			$this->file_size = $_FILES["fileToUpload"]["size"];
			$final_file_name;
		}
	}
        
        public function setOriginalName($name){
            $this->file_original_name = $name;
        }
        public function getOriginalName(){
            return $this->file_original_name;
        }
        public function setFileType($type){
            $this->file_type = $type;
        }
        public function getFileType(){
            return $this->file_type;
        }
        public function setFileSize($size){
            $this->$file_size = $size;
        }
        public function getFileSize(){
            return $this->$file_size;
        }
        public function setFinalFileName($final_name){
            $this->$final_file_name = $final_name;
        }
        public function getFinalFileName(){
            return $this->$final_file_name;
        }
        
        public function uploadFile(){
            
            if ($_FILES["fileToUpload"]["error"] > 0){
			    echo "Upload Error: " . $_FILES["fileToUpload"]["error"] . "<br />";
			    $uploadOk = false;
			}
			else{   
			    if (file_exists("upload/" . $_FILES["fileToUpload"]["name"])){
			      echo $_FILES["fileToUpload"]["name"] . " already exists. ";
			      $uploadOk = false;
			    }
			    else{
			      if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$this->target_file)){
			      echo "File saved in: " . "upload/" . $_FILES["fileToUpload"]["name"]; //<- This is it
			      $uploadOk = true;
			      }
			      else{
			      	echo "There was an error in the file upload.";
			      }
			    }
			}
           
        }
        public function fileAlreadyExists(){
            if (file_exists($target_file)){
                echo"sorry, file already exists";
                $uploadOk = 0;
            }
        }
        public function saveFilePathTo(){}
        public function moveFile(){}
        public function fileTypeIsCorrect(){
            if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
			&& $file_type != "gif" && $file_type != "txt" && $file_type != "docx" ) {
			    echo "Sorry, only pictures, motion pictures, word documents & text files can be uploaded.";
			    $uploadOk = 0;
			    header("Refresh:0");
			}
        }
        public function fileSizeIsCorrect(){
            if ($file_size > 500000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		    header("Refresh:0");
		}
        }
        public function fileWasSelected(){
            		return getOriginalName();

        }
    }
?>