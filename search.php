<html>
<head>
    <title>Регистрация</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/statusBar.css">
    <link rel="stylesheet" type="text/css" href="css/site.css">

    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>

</head>
<body>

<?php echo file_get_contents("templates/header.tpl") ?>

<div style="margin-left:100px">
    <div>
        <h3>Мероприятие: <b id="current_event"></b></h3>
    </div>
</div>
<script type="text/javascript">
    var eventname;
    if((eventname = localStorage.getItem("eventname")) != undefined)
        $("#current_event").html(eventname);
    else
        $("#current_event").html("-");
</script>
</br>

<div class="container">
        <div class="col-md-6">
            <div class="form-group">
                <label for="searchLine">Введите фразу для поиска</label>
                <br>
                <input id="searchLine" class="ui-widget" type="text" class="form-control" name="searchline" />
            </div>
        </div>
</div>

<div class="container">

    <table id="userlist">
        <tr>
            <td>ID</td> <td>Фамилия</td> <td>Имя</td> <td>Отчество</td> <td> </td>
        </tr>
    </table>

</div>


<script type="text/javascript">

    var filerUsers = function() {
        var searchline = $("#searchLine").val().trim();
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
                    inner += "<tr id='" + a[i]["iduser"] + "' class='userline'><td>" + a[i]["iduser"] + "</td> <td>" + a[i]["lastname"] + "</td> <td>" + a[i]["firstname"] + "</td> <td>" + a[i]["middlename"] + "</td><td><input type='button' class='select_user btn btn-default' value='Выбрать'></td></tr>";
                $("#userlist").append(inner);
                $(".select_user").click(function(){
                    console.log($(this).parent().parent().attr("id")); // Обработка клика
                });
            }
        });

    }

    $(filerUsers());

    $("#searchLine").keyup(function(event){
        if(event.keyCode == 13){
            $(".select_user").first().click();
        }
        else filerUsers();
    });

</script>

</body>
</html>