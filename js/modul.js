$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams == "list=") {
        refresh(1);
    } else if (urlParams == "add=") {
        add();
    } else if (urlParams == "id=") {
        add();
    } else {
        refresh(1);
    }
    //refresh(1);
    //alert(window.location.href);
});

var refresh = function(p) {
    const pathname = window.location.pathname;
    const pagename = pathname.split("/").pop();
    const modulname = pagename.split(".")[0];
    /*alert(pathname);
    alert(pagename);
    alert(modulname);*/

    window.history.pushState("",
        "",
        pagename + "?list");

    $("#btn-refresh").hide();
    $("#dbtn-refresh").show();

    $(".table-container").show();
    $("#add-form-container").hide();

    $(".data-body-empty").show();
    $(".data-body").hide();

    $.ajax({
        url: "x" + modulname + "/refresh.php",
        type: "post",
        data: {
            "page": p
        },
        datatype: "html",
        success: function(response) {
            var cell = JSON.parse(JSON.stringify(response));
            //alert(cell.returncode);
            if (cell.returncode == 200) {
                //alert(cell.html);
                $("#btn-refresh").show();
                $("#dbtn-refresh").hide();


                $(".data-body-empty").hide();
                $(".data-body").html(cell.html);
                $(".data-body").show();
            } else if (cell.returncode == 100) {
                $(".data-text-empty").html("No Data Found!");
            }
        },
        error: function() {}
    });
}

var add = function() {
    const pathname = window.location.pathname;
    const pagename = pathname.split("/").pop();
    const modulname = pagename.split(".")[0];
    //alert(modulname);
    //alert(pagename);

    window.history.pushState("",
        "",
        pagename + "?add");
    $("#add-form-container").data("id",
        "");

    $(".table-container").hide();
    $("#add-form-container").show();

    $("#btn-refresh").hide();
    $("#dbtn-refresh").hide();
    $("#btn-add").hide();
    $("#dbtn-add").hide();

    $("#inp-coin").val("");
    $("#inp-addr").val("");
    $("#error-coin").hide();
    $("#error-coin").hide();
    $("#inp-coin").focus();
}

var saveData = function() {
    const pathname = window.location.pathname;
    const pagename = pathname.split("/").pop();
    const modulname = pagename.split(".")[0];

    let id = $("#add-form-container").data("id");
    window.history.pushState("",
        "",
        pagename + "?id=" + id);

    $("#btn-save").hide();
    $("#dbtn-save").show();

    const inpcoin = $("#inp-coin").val();
    const inpaddr = $("#inp-addr").val();

    $("#error-coin").hide();
    $("#error-addr").hide();
    let returncode = 200;
    if (inpcoin === "") {
        $("#error-coin").show();
        returncode--;
    }
    if (inpaddr === "") {
        $("#error-addr").show();
        returncode--;
    }

    if (returncode === 200) {
        $.ajax({
            url: "x" + modulname + "/save-data.php",
            type: "post",
            data: {
                "inpcoin": inpcoin,
                "inpaddr": inpaddr,
                "id": id
            },
            datatype: "html",
            success: function(response) {
                var cell = JSON.parse(JSON.stringify(response));
                //alert(cell.returncode);
                if (cell.returncode == 200) {
                    alert("Successfully Saved");

                    $("#btn-save").show();
                    $("#dbtn-save").hide();

                    id = $("#add-form-container").data("id", cell.id);
                    window.history.pushState("", "", pagename + "?id=" + cell.id);

                } else if (cell.returncode == 100) {
                    alert("Data Already Exist");
                    $("#btn-save").show();
                    $("#dbtn-save").hide();
                } else if (cell.returncode == 101) {
                    alert("Edited Data not found");
                    $("#btn-save").show();
                    $("#dbtn-save").hide();
                } else if(cell.returncode == 400){
                    alert("Error ID");
                }
            },
            error: function() {}
        });
    }
}

var cancelAdd = function() {
    const pathname = window.location.pathname;
    const pagename = pathname.split("/").pop();
    const modulname = pagename.split(".")[0];

    window.history.pushState("",
        "",
        pagename + "?list");

    $(".table-container").show();
    $("#add-form-container").hide();


    $("#btn-refresh").show();
    $("#dbtn-refresh").hide();
    $("#btn-add").show();
    $("#dbtn-add").hide();
    
    refresh(1);
}

var editData = function(id) {
    const pathname = window.location.pathname;
    const pagename = pathname.split("/").pop();
    const modulname = pagename.split(".")[0];

    window.history.pushState("",
        "",
        pagename + "?id=" + id);

    $(".table-container").hide();
    $("#add-form-container").show();

    $("#btn-refresh").hide();
    $("#dbtn-refresh").hide();
    $("#btn-add").hide();
    $("#dbtn-add").hide();

    $.ajax({
        url: "x" + modulname + "/edit-data.php",
        type: "post",
        data: {
            "id": id
        },
        datatype: "html",
        success: function(response) {
            var cell = JSON.parse(JSON.stringify(response));
            //alert(cell.returncode);
            if (cell.returncode == 200) {
                id = $("#add-form-container").data("id", cell.id);
                window.history.pushState("", "", pagename + "?id=" + cell.id);

                $("#inp-coin").val("");
                $("#inp-addr").val("");
            } else if (cell.returncode == 201) {
                id = $("#add-form-container").data("id", cell.id);
                window.history.pushState("", "", pagename + "?id=" + cell.id);
                $("#inp-coin").val(cell.coin);
                $("#inp-addr").val(cell.address);
            } else if (cell.returncode == 100) {
                alert("Data not found!");
                $("#inp-coin").val("");
                $("#inp-addr").val("");
            }
            $("#inp-coin").focus();
        },
        error: function() {}
    });
}

document.addEventListener('change', function(event) {
    // Gunakan event delegation
    if (event.target && event.target.classList.contains('action-dropdown')) {
        const selectedValue = event.target.value;
        const row = event.target.closest('tr'); // Get the parent row
        const rowNumber = row.querySelector('td:first-child').textContent; // Get the row number

        if (selectedValue === 'edit') {
            editData(rowNumber); // Panggil fungsi editData
        } else if (selectedValue === 'delete') {
            deleteData(rowNumber); // Panggil fungsi deleteData
        }
    }
});