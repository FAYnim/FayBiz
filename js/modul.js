$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams == "list=") {
        refresh(1);
    } else if (urlParams == "add=") {
        add();
    } else if (urlParams == "id=") {
        let id = $("#add-form-container").data("id");
        editData(id);
    } else {
        refresh(1);
    }
});

var refresh_dashboard = function(){
    const pathname = window.location.pathname;
    const pagename = pathname.split("/").pop();
    const modulname = pagename.split(".")[0];

    $("#btn-refresh").hide();
    $("#dbtn-refresh").show();
    $("#statistic-container").hide();

    $.ajax({
        url: "x" + modulname + "/refresh.php",
        type: "post",
        data: {
        },
        datatype: "html",
        success: function(response) {
            var cell = JSON.parse(JSON.stringify(response));
            if (cell.returncode == 200) {
                //alert(cell.table);
                $("#statistic-container").html(cell.html).show();

                // Tunggu sebentar agar DOM diperbarui, lalu jalankan styling ulang
                setTimeout(function(){
                    $(".stchange").each(function(){
                        let stat_symbol = $(this).text().trim();
                        if(stat_symbol.startsWith("+")){
                            $(this).css("color", "green");
                        } else if(stat_symbol.startsWith("-")){
                            $(this).css("color", "red");
                        }
                    });
                }, 50); // Delay kecil agar DOM sempat update

            } else if (cell.returncode == 400) {
                alert("No Data Found!");
                $("#statistic-container").hide();
            }
            $("#btn-refresh").show();
            $("#dbtn-refresh").hide();            //alert(cell.returncode);
            /*if (cell.returncode == 200) {
                //alert(cell.html);
                $("#statistic-container").html(cell.html);
                $("#statistic-container").show();
            } else if (cell.returncode == 400) {
                alert("No Data Found!");
                $("#statistic-container").hide();
            }
            $("#btn-refresh").show();
            $("#dbtn-refresh").hide();*/
        },
        error: function() {}
    });
}

var refresh = function(p) {
    const pathname = window.location.pathname;
    const pagename = pathname.split("/").pop();
    const modulname = pagename.split(".")[0];
    /*alert(pathname);
    alert(pagename);
    alert(modulname);*/
    
    if(modulname == "dashboard"){
        $("#dashboard-content").show();
        $("#other-content").hide();
        
        refresh_dashboard();
        return;
    } else {
        $("#dashboard-content").hide();
        $("#other-content").show();
    }

    window.history.pushState("",
        "",
        pagename + "?list");

    $("#btn-refresh").hide();
    $("#dbtn-refresh").show();

    $(".table-container").show();
    $("#add-form-container").hide();

    $(".data-text-empty").html("Loading...");
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
            //alert(cell.table);

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
    $(".search-wrapper").hide();

    $("#inp-coin").val("");
    $("#inp-addr").val("");
    $("#error-coin").hide();
    $("#error-addr").hide();
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
                //alert(cell.table);
                if (cell.returncode == 200) {
                    alert("Successfully Saved");

                    id = $("#add-form-container").data("id", cell.id);
                    window.history.pushState("", "", pagename + "?id=" + cell.id);

                } else if (cell.returncode == 100) {
                    alert("Data Already Exist");
                } else if (cell.returncode == 101) {
                    alert("Edited Data not found");
                } else if(cell.returncode == 400){
                    alert("Error ID");
                }
            },
            error: function() {}
        });
    }

    $("#btn-save").show();
    $("#dbtn-save").hide();
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


    $("#btn-refresh-other-content").show();
    $("#dbtn-refresh-other-content").hide();
    $("#btn-add").show();
    $("#dbtn-add").hide();
    $(".search-wrapper").show();
    
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

    $("#btn-refresh-other-content").hide();
    $("#dbtn-refresh-other-content").hide();
    $("#btn-add").hide();
    $("#dbtn-add").hide();
    $(".search-wrapper").hide();

    $("#dashboard-content").hide();

    $("#error-coin").hide();
    $("#error-addr").hide();

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

var searchData = function(){
    const pathname = window.location.pathname;
    const pagename = pathname.split("/").pop();
    const modulname = pagename.split(".")[0];

    $(".data-text-empty").html("Loading...");
    $(".data-body-empty").show();
    $(".data-body").hide();

    let inpsearch = $("#inp-search").val();
    
    if(inpsearch != ""){
        $.ajax({
            url: "x" + modulname + "/search-data.php",
            type: "post",
            data: {
                "inpsearch": inpsearch
            },
            datatype: "html",
            success: function(response) {
                var cell = JSON.parse(JSON.stringify(response));
                /*alert(cell.returncode);
                alert(cell.html);
                alert(cell.sql);*/
                
                if(cell.returncode == 200){
                    $(".data-body-empty").hide();
                    $(".data-body").html(cell.html);
                    $(".data-body").show();
                } else {
                    $(".data-text-empty").html("No Data Found!");
                }
            },
            error: function() {
                alert("Something Error! Try again later.");
            }
        });
    } else {
        refresh(1);
    }
}

var deleteData = function(id){
    const pathname = window.location.pathname;
    const pagename = pathname.split("/").pop();
    const modulname = pagename.split(".")[0];
    
    let delete_confirm = confirm("Are you sure you want to delete data with ID " + id + "?");
    if(delete_confirm){
        /*alert("Data " + id + " Deleted!");*/
        $.ajax({
            url: "x" + modulname + "/delete-data.php",
            type: "post",
            data: {
                "id": id
            },
            datatype: "html",
            success: function(response) {
                var cell = JSON.parse(JSON.stringify(response));
                
                if(cell.returncode == 200){
                    alert("Data " + id + " Successfully Deleted!");
                } else {
                    alert("Data " + id + " Not Found!");
                }
                refresh(1);
            },
            error: function() {
                alert("Something Error! Try again later.");
            }
        });
    } else {
        alert("Canceled");
    }
}

$(document).ready(function(){
    $(document).on("click", ".edit-data", function(){
        let id = $(this).data("id");
        /*alert("Edit Data " + id + " Clicked!");*/
        editData(id);
    });
    
    $(document).on("click", ".delete-data", function(){
        let id = $(this).data("id");
        /*alert("Data " + id + " Deleted!");*/
        deleteData(id);
    });
});