        $(document).ready(function() {
            $('#loginForm').on('submit', function(event) {
                event.preventDefault(); // Mencegah pengiriman form secara default

                var username = $('#username').val();
                var password = $('#password').val();

                // Mengirim data menggunakan AJAX POST
                $.ajax({
                    url: 'login-check.php',
                    type: 'POST',
                    data: { "username": username, "password": password },
                    success: function(response) {
                        var cell = JSON.parse(JSON.stringify(response));
                        //alert(cell.returncode);
                        //alert(cell.sql);
                        //alert(cell.table);
                        const expires = cell.nextweek;
                        if(cell.returncode == 200){
                            //document.cookie = 'loggedIn=true; username=${encodeURIComponent(username)}; expires=${expires}; path=/';
                            document.cookie = "loggedIn=true; expires=" + expires + "; path=/";
                            document.cookie = "username=" + encodeURIComponent(username) + "; expires= " + expires + "; path=/";
                            //alert(document.cookie);
                            window.location.href = 'dashboard.php';
                        } else {
                            alert('Wrong Username or Password!');
                        }
                    },
                    error: function() {
                        // Menangani error
                        alert('System Error!');
                    }
                });
            });
        });
