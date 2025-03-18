<?php
    $site = "CrypVest";
    $title = "Dashboard";
    $modul = "dashboard";
    $version = "1.0";
    $id = ""; if (isset($_GET["id"])){$id = $_GET["id"];}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site." | ".$title;?></title>
    <link rel="icon" href="favicon/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/style-app.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <header class="header">
            <div class="hamburger-menu" id="hamburgerMenu">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <h1><?php echo $title." ".$version;?></h1>
        </header>
        <aside class="sidebar" id="sidebar">
<?php include "sidebar.inc";?>
        </aside>
        <div class="overlay" id="overlay"></div>
        <main class="content">
            <!-- Content will be added here -->
            <!-- Refresh and Add -->
            <div class="button-container">
                <button class="btn-primary" id="btn-refresh" onclick="refresh(1)">Refresh</button>
                <button class="btn-secondary dbtn" id="dbtn-refresh" style="display: none;">Refresh</button>
                <button class="btn-primary" id="btn-add" onclick="editData()">Add</button>
                <button class="btn-secondary dbtn" id="dbtn-add" style="display: none;">Add</button>
            </div>

            <div id="add-form-container" data-id="<?php echo $id;?>">
                <h2>Add New Data</h2>
                <div class="form-group">
                    <label for="data-input">Coin:</label>
                    <input type="text" id="inp-coin">
                    <label id="error-coin" style="display: none; color: red;">* The coin field cannot be empty</label>
                </div>
                <div class="form-group">
                    <label for="data-input">Address:</label>
                    <input type="text" id="inp-addr">
                    <label id="error-addr" style="display: none; color: red;">* The address field cannot be empty</label>
                </div>
                <div class="button-container">
                    <button class="btn-danger" id="btn-cancel-add" onclick="cancelAdd()">Cancel</button>
                    <button class="btn-primary" id="btn-save" onclick="saveData()">Save</button>
                    <button class="btn-secondary dbtn" id="dbtn-save" style="display: none;">Save</button>
                </div>
            </div>
            
            <!-- Data -->
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Data</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="data-body" style="display:none;">
                        <!-- Data rows will be added here -->
                        <tr>
                            <td>1</td>
                            <td>
                                <strong>Data 1</strong><br>
                                <input type="text" value="User 12345678912334567" readonly>
                            </td>
                            <td>
                                <select class="action-dropdown">
                                    <option value="">Action</option>
                                    <option value="edit">Edit</option>
                                    <option value="delete">Delete</option>
                                </select>
                            </td>
                        </tr>
                      </tbody>
                    <tbody class="data-body-empty">
                        <tr>
                            <td class="data-text-empty" colspan="3" style="text-align:center;">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
        <footer class="footer">
            <p>© 2025 <?php echo $site;?></p>
        </footer>
    </div>
    <script src="js/app.js">
    </script>
    <script src="js/modul.js?v=1">
    </script>
</body>
</html>