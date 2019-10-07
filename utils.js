$(document).ready(function(){
    
    load_folder_list();

        function load_folder_list()
        {
            var action = "fetch";
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {action: action},
                success: function (data)
                {
                    $('#carpetas').html(data);
                }
            });
        }

        $(document).on('click', '#crear_carpeta', function () {
            $('#action').val("create");
            $('#folder_name').val('');
            $('#folder_button').val('Crear');
            $('#folderModal').modal('show');
            $('#old_name').val('');
            $('#change_title').text("Crear carpeta");
        });

        $(document).on('click', '#folder_button', function () {
            var folder_name = $('#folder_name').val();
            var old_name = $('#old_name').val();
            var action = $('#action').val();
            if (folder_name != '')
            {
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data: {folder_name: folder_name, old_name: old_name, action: action},
                    success: function (data)
                    {
                        $('#folderModal').modal('hide');
                        load_folder_list();
                        alert(data);
                    }
                });
            }
            else
            {
                alert("Enter Folder Name");
            }
        });

        $(document).on("click", ".update", function () {
            var folder_name = $(this).data("name");
            $('#old_name').val(folder_name);
            $('#folder_name').val(folder_name);
            $('#action').val("change");
            $('#folderModal').modal("show");
            $('#folder_button').val('Aceptar');
            $('#change_title').text("Cambiar el nombre");
        });

        $(document).on("click", ".delete", function () {
            var folder_name = $(this).data("name");
            var action = "delete";
            if (confirm("¿Seguro que quieres borrarla?"))
            {
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data: {folder_name: folder_name, action: action},
                    success: function (data)
                    {
                        load_folder_list();
                        alert(data);
                    }
                });
            }
        });

        $(document).on('click', '.upload', function () {
            var folder_name = $(this).data("name");
            $('#hidden_folder_name').val(folder_name);
            $('#uploadModal').modal('show');
        });

        $('#upload_form').on('submit', function () {
            $.ajax({
                url: "upload.php",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    load_folder_list();
                    alert(data);
                }
            });
        });

        $(document).on('click', '.view_files', function () {
            var folder_name = $(this).data("name");
            var action = "fetch_files";
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {action: action, folder_name: folder_name},
                success: function (data)
                {
                    $('#file_list').html(data);
                    $('#filelistModal').modal('show');
                }
            });
        });

        $(document).on('click', '.remove_file', function () {
            var path = $(this).attr("id");
            var action = "remove_file";
            if (confirm("¿Seguro que quieres borrar este fichero?"))
            {
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data: {path: path, action: action},
                    success: function (data)
                    {
                        alert(data);
                        $('#filelistModal').modal('hide');
                        load_folder_list();
                    }
                });
            }
        });
        
        $(document).on('click', '.download_file', function () {
            var path = $(this).attr("id");
            var file_name = $(this).attr("file_name");
            //var file_name = $(".change_file_name").data("file_name");
            console.log(path);
            var action = "download_file";
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {path: path, action: action},
                success: function (data)
                {
                    alert(data);
//                    $.fileDownload('path')
//    .done(function () { alert('File download a success!'); })
//    .fail(function () { alert('File download failed!'); });
//            var link = document.createElement("a");
//            link.download = file_name;
//            link.href = path;
//            link.click();
                }
            });
        });
        
        $(document).on('blur', '.change_file_name', function () {
            var folder_name = $(this).data("folder_name");
            var old_file_name = $(this).data("file_name");
            var new_file_name = $(this).text();
            var action = "change_file_name";
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {folder_name: folder_name, old_file_name: old_file_name, new_file_name: new_file_name, action: action},
                success: function (data)
                {
                    alert(data);
                }
            });
        });
});
