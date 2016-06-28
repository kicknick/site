<html>
<head>
    <title>Регистрация</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="externals/css/bootstrap.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="styles/statusBar.css">
    <link rel="stylesheet" type="text/css" href="styles/site.css">

    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>

</head>
<body>

<?php echo file_get_contents("templates/header.tpl") ?>

<?php echo file_get_contents("templates/currentEvent.tpl"); ?>

</br>

<div class="container">
        <div class="col-md-4">
            <div class="form-group">
                <label for="searchLine">Введите фразу для поиска</label>
                <br>
                <input autofocus id="searchLine" class="form-control" type="text" class="form-control" name="searchline" />
            </div>
        </div>
        <div class="col-md-12">
            <table id="userlist" class="table table-bordered">
                <thead>
                    <tr>
                        <td width="5%">ID</td>
                        <td width="25%">Фамилия</td>
                        <td width="25%">Имя</td>
                        <td width="25%">Отчество</td>
                        <td width="20%"> </td>
                    </tr>
                </thead>
            </table>
        </div>
</div>

<div class="container">



</div>


<script type="text/javascript">

    var filerUsers = function(searchline) {
        searchline = searchline.trim();
        if (searchline == '') searchline = null;
        $.ajax({
            type: "POST",
            url: "Controller/filterUsers.php",
            data:{
                searchline: searchline
            },
            success: function(data){
                var a = JSON.parse(data);
                $(".userline").html("");

                var inner = "";
                for (var i = 0 ; i < a.length ; i++)
                    inner +=
                        "<tbody>" +
                            "<tr id='" + a[i]["iduser"] + "' class='userline'>" +
                                "<td class='iduser'>" + a[i]["iduser"] + "</td> " +
                                "<td class='lastname'>" + a[i]["lastname"] + "</td> " +
                                "<td class='firstname'>" + a[i]["firstname"] + "</td> " +
                                "<td class='middlename'>" + a[i]["middlename"] + "</td>" +
                                "<td><input type='button' class='select_user btn btn-default' value='Выбрать'></td>" +
                            "</tr>" +
                        "</tbody>";

                $("#userlist").append(inner);
                $(".select_user").click(function(){
                    var useritem = $(this).parent().parent();
                    localStorage.setItem("lastname", $(".lastname", useritem).first().html());
                    localStorage.setItem("firstname", $(".firstname", useritem).first().html());
                    localStorage.setItem("middlename", $(".middlename", useritem).first().html());
                    window.location = "makebage.php";
                });
            }
        });
    }

    $(filerUsers($("#searchLine").val()));

    $("#searchLine").keyup(function(event){
        if(event.keyCode == 13){
            $(".select_user").first().click();
        }
        else filerUsers($("#searchLine").val());
    });

</script>

</body>
</html>