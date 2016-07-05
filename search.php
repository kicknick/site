<html>
<head>
    <title>Регистрация</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
            <input autofocus id="searchLine" class="form-control" type="text" class="form-control" name="searchline"/>
        </div>
    </div>
    <div class="col-md-12">
        <table id="userlist" class="table table-bordered">
            <thead>
            <tr>
                <td class="label-info" width="8%">ID</td>
                <td class="label-info" width="25%">Фамилия</td>
                <td class="label-info" width="25%">Имя</td>
                <td class="label-info" width="25%">Отчество</td>
                <td class="label-info" width="8%">Отряд</td>
                <td class="label-info" width="15%"></td>
            </tr>
            </thead>
        </table>
    </div>
</div>

<div class="container">


</div>


<script type="text/javascript">

    var filerUsers = function (searchline) {
        searchline = searchline.trim();
        if (searchline == '') searchline = null;
        $.ajax({
            type: "POST",
            url: "Controller/filterUsers.php",
            data: {
                searchline: searchline
            },
            success: function (data) {
                var a = JSON.parse(data);
                $(".userline").html("");

                var inner = "";
                for (var i = 0; i < a.length; i++)
                    inner +=
                        "<tbody>" +
                        "<tr id='" + a[i]["iduser"] + "' class='userline'>" +
                        "<td><span class='text-info iduser'>" + a[i]["iduser"] + "</span>" + "</td> " +
                        "<td><span class='text-info lastname'>" + a[i]["lastname"] + "</span>" + "<input type='button' class='btn edit' name='lastname'>" + "</td> " +
                        "<td><span class='text-info firstname'>" + a[i]["firstname"] + "</span>" + "<input type='button' class='btn edit' name='firstname'>" + "</td> " +
                        "<td><span class='text-info middlename'>" + a[i]["middlename"] + "</span>" + "<input type='button' class='btn edit' name='middlename'>" + "</td>" +
                        "<td><span class='text-info squad'>" + a[i]["squadid"] + "</span>" + "<input type='button' class='btn edit' name='squad'>" + "</td>" +
                        "<td><input type='button' class='select_user btn btn-default' value='Выбрать'></td>" +
                        "</tr>" +
                        "</tbody>";

                $("#userlist").append(inner);
                setOnClickForList();
            }
        });
    }

    var editField = function(button){
        var item = $(button).parent();
        var field = $("span", item);
        var editingfield = $("<input>");
        editingfield.attr("type", "text");
        editingfield.attr("class", field.className);
        editingfield.addClass("control");
        editingfield.val(field.html());
        console.log(editingfield);
        field.remove();
        item.prepend(editingfield);

        $(button).removeClass("edit");
        $(button).addClass("set");
        $(button).val("OK");
        $(button).unbind( "click" );
        $(button).click(function(){
            setField(this);
        });
    };

    var setField = function(button){
        var item = $(button).parent();
        var editingfield = $("input[type=text]", item);
        var value = editingfield.val();
        var fieldname = $(button).attr("name");
        var field = $("<span>");
        field.addClass("text-info");
        field.addClass($(button).attr("name"));
        field.html(value);
        console.log(editingfield);
        editingfield.remove();
        item.prepend(field);

        var iduser = $(button).parent().parent()[0].id;

        var url;
        if(fieldname == "lastname") url = "/Controller/setLastname.php"
        if(fieldname == "firstname") url = "/Controller/setFirstname.php"
        if(fieldname == "middlename") url = "/Controller/setMiddlename.php"
        if(fieldname == "squad") url = "/Controller/setSquad.php"
        $.ajax({
            type: "POST",
            data: {
                iduser: iduser,
                value: value
            },
            url: url,
            success: function(e){
                console.log(e);
            }
        })

        $(button).removeClass("set");
        $(button).addClass("edit");
        $(button).val("");
        $(button).unbind( "click" );
        $(button).click(function(){
            editField(this);
        });
    };

    var setOnClickForList = function(){
        $(".select_user").click(function () {
            var useritem = $(this).parent().parent();
            localStorage.setItem("lastname", $(".lastname", useritem).first().html());
            localStorage.setItem("firstname", $(".firstname", useritem).first().html());
            localStorage.setItem("middlename", $(".middlename", useritem).first().html());
            localStorage.setItem("squad", $(".squad", useritem).first().html());
            window.location = "makebage.php";
        });
        $(".btn.edit").click(function(){
            editField(this);
        });
    }

    $(filerUsers($("#searchLine").val()));

    $("#searchLine").keyup(function (event) {
        if (event.keyCode == 13) {
            $(".select_user").first().click();
        }
        else filerUsers($("#searchLine").val());
    });

</script>

</body>
</html>