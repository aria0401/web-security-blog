<?php

class Image {

    public function validate() {


        $mine_types = ['image/gif', 'image/png', 'image/jpeg'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mine_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

        if ($this->file_error) {

            switch ($this->file_error) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $this->errors[] = 'No file Uploaded';
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    $this->errors[] = 'File is too long (from the server settings)';
                    break;
                default:
                    $this->errors[] = 'An error ocurred';
            }
        } else if (!in_array($mine_type, $mine_types)) {

            $this->errors[] = 'Invalid file type';
        } else if ($this->file_size > 1000000) {

            $this->errors[] = 'File is too large';
        } else  if (empty($_FILES)) {

            $this->errors[] = 'Invalid upload';
        }


        return empty($this->errors);
    }


    public function fileName($folder) {

        //sanitize the filename- change the name of the file if it contains odd characters
        $pathinfo = pathinfo($this->file_name);
        $base = $pathinfo['filename'];
        $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);
        $base = mb_substr($base, 0, 200); //restrict the filename to 200 char
        $filename = $base . "." . $pathinfo['extension'];
        $destination = $folder . $filename;

        $i = 1;
        while (file_exists($destination)) {

            $filename = $base . "-$i." . $pathinfo['extension'];
            $destination = $folder . $filename;

            $i++;
        }

        return [$destination, $filename];
    }
}
