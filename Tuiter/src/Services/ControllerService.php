<?php

namespace Tuiter\Services;

class ControllerService {

    public function setup($app, $controllerFolder) {
        $files = array();

        $dh = opendir($controllerFolder);
        while (false !== ($entry = readdir($dh))) {
            if (strlen($entry) > 4) {
                $files[] = $entry;
            }
        }

        foreach ($files as $filename) {
            $info = explode('.', $filename);
            $filename = '\Tuiter\Controllers\\'.$info[0];
            
            $controller = new $filename;
            $controller->config($app);
        }

    }

}