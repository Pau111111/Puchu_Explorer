<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>PHP Filesystem with Ajax JQuery</title>
        <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="utils.js" type="text/javascript"></script> 
        <link href="css/custom.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <!-- Página principal -->
        <div class="container">
            <!--<div style="height: 100%; width: 15%; background-color: #50a897;">-->
            <div style="height: 15%; width: 100%;">
                <div style="height: 100%; display: inline-block;">
                    <img src="img/logo4.PNG" alt="Puchu Explorer" style="height: 100%"/>
                </div>
                <div style="display: inline-block; float: right; padding-top: 5%;">
                    <input name="buscador" /><button type="button" class="btn btn-default" data-dismiss="modal">Buscar</button>
                </div>
            </div>
            <br />
            <div class="table-responsive" id="carpetas">

            </div>
            <div align="left">
                <button type="button" name="crear_carpeta" id="crear_carpeta" class="btn btn-success">Crear</button>
            </div>
        </div>
        <!-- Página principal -->
        
        <div id="folderModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><span id="change_title">Crear carpeta</span></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Introduce el nombre de la carpeta
                            <input type="text" name="folder_name" id="folder_name" class="form-control" /></p>
                        <br />
                        <input type="hidden" name="action" id="action" />
                        <input type="hidden" name="old_name" id="old_name" />
                        <input type="button" name="folder_button" id="folder_button" class="btn btn-info" value="Crear" />

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="uploadModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Subir fichero</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="upload_form" enctype='multipart/form-data'>
                            <p>Seleccionar fichero
                                <input type="file" name="upload_file" /></p>
                            <br />
                            <input type="hidden" name="hidden_folder_name" id="hidden_folder_name" />
                            <input type="submit" name="upload_button" class="btn btn-info" value="Subir" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="filelistModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Archivos</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="file_list">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

