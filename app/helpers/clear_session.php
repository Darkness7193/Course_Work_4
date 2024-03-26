<?php



function clear_session() {
    $directory = 'C:\Users\27_07\PhpstormProjects\Course_Work_4\storage\framework\sessions';
    $ignoreFiles = ['.gitignore', '.', '..'];
    $files = scandir($directory);

    foreach ($files as $file) {
        if(!in_array($file,$ignoreFiles)) unlink($directory . '/' . $file);
    }
}
