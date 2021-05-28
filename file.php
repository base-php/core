<?php

/**
 * Class to interact with files
 */
class File
{
    /**
     * File type input corresponding to the file you want to uplooad.
     *
     * $input string
     */
    public $input    = '';

    /**
     * Name that the file will carry once uploaded.
     *
     * $filename string
     */
    public $filename = '';

    /**
     * Name of multiple files uploaded.
     *
     * $filenames json
     */
    public $filenames = '';

    /**
     * Path where the uploaded file will be saved.
     *
     * $upload string
     */
    public $upload;

    /**
     * Result of the file you tried to upload.
     *
     * $success boolean
     */
    public $success = false;

    /**
     * Initialize the class to use from a global function.
     *
     * @return File
     */
    public static function init()
    {
        $class = new static;
        return $class;
    }

    /**
     * Set file type input corresponding to the file you want to uplooad.
     *
     * @param $input string
     * @return File
     */
    public function input($input)
    {
        $this->input = (isset($_FILES[$input])) ? $_FILES[$input] : '';
        return $this;
    }

    /**
     * Set name that the file will carry once uploaded.
     *
     * @param $filename string
     * @return File
     */
    public function filename($filename)
    {
        $this->filename = $filename . '.' . pathinfo($this->input['name'], PATHINFO_EXTENSION);
        return $this;
    }

    /**
     * Set path where the uploaded file will be saved.
     *
     * @param $upload string
     * @return File
     */
    public function upload($upload)
    {
        $this->upload = $upload;

        if (isset($this->input) && $this->input != '') {
            if (is_array($this->input['name'])) {
                $i = 0;
                foreach ($this->input['tmp_name'] as $name) {
                    $result = move_uploaded_file(
                        $name,
                        $_SERVER['DOCUMENT_ROOT'] . '/' . $upload . '/' . $this->input['name'][$i]
                    );
                    $i = $i + 1;
                }

                if ($result) {
                    $this->success = true;
                    $this->filenames = json($this->input['name']);
                }
                return $this;
            } else {
                $this->filename = ($this->filename != '') ? $this->filename : $this->input['name'];

                $result = move_uploaded_file(
                    $this->input['tmp_name'],
                    $_SERVER['DOCUMENT_ROOT'] . '/' . $upload . '/' . $this->filename
                );

                if ($result) {
                    $this->success = true;
                }
            }
        }

        return $this;
    }

    /**
     * Result of the file you tried to upload.
     *
     * @return boolean
     */
    public function success()
    {
        return $this->success;
    }

    /**
     * Force downloading a file.
     *
     * @param $file string
     * @return File
     */
    public static function download($file, $filename)
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $file)) {
            header('Content-disposition: attachment; filename=' . $filename);
            header('Content-type: application/octet-stream');
            readfile($_SERVER['DOCUMENT_ROOT'] . '/' . $file);
        }
    }

    /**
     * Delete a file.
     *
     * @param $file string
     * @return unlink
     */
    public function delete($file)
    {
        return unlink($file);
    }
}

/**
 * Initialize global helper.
 *
 * @return File
 */
function files()
{
    return File::init();
}
