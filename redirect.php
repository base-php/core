<?php

class Redirect
{
    public $to;

    public function redirect()
    {
        echo "
            <script>
                window.location.href = '$this->to';
            </script>
        ";
    }

    public function with($key, $value)
    {
        $_SESSION['flashmessages'][$key] = $value;
        return $this;
    }

    public function __destruct()
    {
        return $this;
    }
}
