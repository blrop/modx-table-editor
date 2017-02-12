<?php

namespace table_editor;

class Tpl
{
    public function __construct($tpl_dir)
    {
        if (!preg_match('/\/$/', $tpl_dir)) {
            $tpl_dir = $tpl_dir . '/';
        }
        $this->tpl_dir = $tpl_dir;
    }

    public function render($file_name, $params = false)
    {
        if (is_array($params)) {
            extract($params);
        }
        ob_start();
        require $this->tpl_dir . $file_name . '.php';
        return ob_get_clean();
    }
}
