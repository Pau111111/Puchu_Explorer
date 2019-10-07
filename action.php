<?php
chdir("home");
function format_folder_size($size) {
    if ($size >= 1073741824) {
        $size = number_format($size / 1073741824, 2) . ' GB';
    } elseif ($size >= 1048576) {
        $size = number_format($size / 1048576, 2) . ' MB';
    } elseif ($size >= 1024) {
        $size = number_format($size / 1024, 2) . ' KB';
    } elseif ($size > 1) {
        $size = $size . ' bytes';
    } elseif ($size == 1) {
        $size = $size . ' byte';
    } else {
        $size = '0 bytes';
    }
    return $size;
}

function get_folder_size($folder_name) {
    $total_size = 0;
    $file_data = scandir($folder_name);
    foreach ($file_data as $file) {
        if ($file === '.' or $file === '..') {
            continue;
        } else {
            $path = $folder_name . '/' . $file;
            $total_size = $total_size + filesize($path);
        }
    }
    return format_folder_size($total_size);
}

if (isset($_POST["action"])) {
    if ($_POST["action"] == "fetch") {
        
        $folder = array_filter(glob('*'), 'is_dir');

        $output = '
  <table class="table table-bordered table-striped">
   <tr>
    <th>CARPETA</th>
    <th>TOTAL DE FICHEROS</th>
    <th>TAMAÑO</th>
    <th>ACTUALIZAR</th>
    <th>SUBIR FICHEROS</th>
    <th>VER FICHEROS</th>
    <th>BORRAR</th>
   </tr>
   ';
        if (count($folder) > 0) {
            foreach ($folder as $name) {
                $output .= '
     <tr>
      <td>' . $name . '</td>
      <td>' . (count(scandir($name)) - 2) . '</td>
      <td>' . get_folder_size($name) . '</td>
      <td><button type="button" name="update" data-name="' . $name . '" class="update btn btn-warning btn-xs">֎</button></td>
      <td><button type="button" name="upload" data-name="' . $name . '" class="upload btn btn-info btn-xs">↑</button></td>
      <td><button type="button" name="view_files" data-name="' . $name . '" class="view_files btn btn-default btn-xs">Ver</button></td>
      <td><button type="button" name="delete" data-name="' . $name . '" class="delete btn btn-danger btn-xs">X</button></td>    
    </tr>';
            }
        } else {
            $output .= '
    <tr>
     <td colspan="6">No Folder Found</td>
    </tr>
   ';
        }
        $output .= '</table>';
        echo $output;
    }

    if ($_POST["action"] == "create") {
        if (!file_exists($_POST["folder_name"])) {
            mkdir($_POST["folder_name"], 0777, true);
            echo 'Carpeta creada';
        } else {
            echo 'La carpeta ya existe';
        }
    }
    if ($_POST["action"] == "change") {
        if (!file_exists($_POST["folder_name"])) {
            rename($_POST["old_name"], $_POST["folder_name"]);
            echo 'El nombre se ha cambiado correctamente';
        } else {
            echo 'La carpeta ya existe';
        }
    }

    if ($_POST["action"] == "delete") {
        $files = scandir($_POST["folder_name"]);
        foreach ($files as $file) {
            if ($file === '.' or $file === '..') {
                continue;
            } else {
                unlink($_POST["folder_name"] . '/' . $file);
            }
        }
        if (rmdir($_POST["folder_name"])) {
            echo 'Carpeta borrada';
        }
    }

    if ($_POST["action"] == "fetch_files") {
        $file_data = scandir($_POST["folder_name"]);
        $output = '
  <table class="table table-bordered table-striped">
   <tr>
    <th>Fichero</th>
    <th>Nombre</th>
    <th>Descargar</th>
    <th>Borrar</th>
   </tr>
  ';

        foreach ($file_data as $file) {
            if ($file === '.' or $file === '..') {
                continue;
            } else {
                $path = $_POST["folder_name"] . '/' . $file;
                $output .= '
    <tr>
     <td><img src="' . $path . '" class="img-thumbnail" height="50" width="50" /></td>
     <td contenteditable="true" data-folder_name="' . $_POST["folder_name"] . '"  data-file_name = "' . $file . '" class="change_file_name">' . $file . '</td>
     <td><button name="download_file" class="download_file btn btn-success btn-xs" id="' . $path . '" file_name= "' . $file . '">↓</button></td>
     <td><button name="remove_file" class="remove_file btn btn-danger btn-xs" id="' . $path . '">X</button></td>
    </tr>
    ';
            }
        }
        $output .='</table>';
        echo $output;
    }

    if ($_POST["action"] == "remove_file") {
        if (file_exists($_POST["path"])) {
            unlink($_POST["path"]);
            echo 'Fichero borrado';
        }
    }
    
    if ($_POST["action"] == "download_file") {
        if (file_exists($_POST["path"])) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/force-download');
            header('Content-Disposition: attachment; filename="' . basename($_POST["path"]) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($_POST["path"]));
            
            readfile($_POST["path"]);
            flush();
//            header("Cache-Control: public");
//    header("Content-Description: File Transfer");
//    header('Content-Disposition: attachment; filename="' . $_POST["path"] . '"');
//    header("Content-Type: application/zip");
//    header("Content-Transfer-Encoding: binary");
//
//    readfile($_POST["path"]);
//            
//            $handle = fopen($_POST["path"], 'rb');
//            $buffer = '';
//            while (!feof($handle)) {
//                $buffer = fread($handle, 4096);
//                echo $buffer;
//                ob_flush();
//                flush();
//            }
//            fclose($handle);
//            exit;
        }
    }

    if ($_POST["action"] == "change_file_name") {
        $old_name = $_POST["folder_name"] . '/' . $_POST["old_file_name"];
        $new_name = $_POST["folder_name"] . '/' . $_POST["new_file_name"];
        if (rename($old_name, $new_name)) {
            echo 'Se ha cambiado el nombre correctamente';
        } else {
            echo 'Ha habido un error al cambiar el nombre';
        }
    }
}
?>