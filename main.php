<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.html");
    exit;
}

// Static data for now, we will replace this with database data later


include 'db.php';

// Fetch data from cars table
$sql = "SELECT * FROM cars";
$sql2 = "SELECT * FROM users";
$sql3 = "SELECT * FROM subscribers";
$sql4 = "SELECT * FROM purchcars";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$result4 = $conn->query($sql4);

$tableData = []; // Initialize an empty array to store fetched data
$tableData2 = [];
$tableData3 = [];
$tableData4 = [];

if ($result->num_rows > 0) {
    // Fetch each row and push it into $tableData array
    while ($row = $result->fetch_assoc()) {
        $tableData[] = $row;
    }
} else {
    echo "No data found in cars table.";
}
if ($result2->num_rows > 0) {
    // Fetch each row and push it into $tableData array
    while ($row = $result2->fetch_assoc()) {
        $tableData2[] = $row;
    }
} else {
    echo "No data found in users table.";
}
if ($result3->num_rows > 0) {
    // Fetch each row and push it into $tableData array
    while ($row = $result3->fetch_assoc()) {
        $tableData3[] = $row;
    }
} else {
    echo "No data found in subscribers table.";
}

if ($result4->num_rows > 0) {
    // Fetch each row and push it into $tableData array
    while ($row = $result4->fetch_assoc()) {
        $tableData4[] = $row;
    }
} else {
    echo "No data found in subscribers table.";
}
// Close database connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css'>
    <meta name="author" content="Pharell">
    <!-- styling -->
    <link rel="stylesheet" type="text/css" href="./main.css">
    <!-- font: poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- icons: Font Awesome 5.15 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./form.css">
    <title>Responsitive Dashboard Admin</title>
</head>

<body>
    <!-- header -->
    <header class="header" id="header">
        <h4>Dashboard</h4>
        <div class="profile">

            <img class="profile-image" alt="no available image" src="https://pbs.twimg.com/media/FREjAjXXwAASCp7.jpg:large">
            <p class="profile-name"><?php echo strtok($_SESSION['email'], '@'); ?></p>
            <form action="./logout.php">
                <button class="logoutBtn" type="submit"> <img src="./assets/images/logout.png" alt=""></button>
            </form>

        </div>
    </header>

    <input type="checkbox" id="toggle">
    <label class="side-toggle" for="toggle"><span class="fas fa-bars"></span></label>

    <!-- nav -->
    <nav id="nav" class="nav">
        <div class="nav-menu" id="overview">
            <span class="fas fa-clipboard-list"></span>
            <p>All Cars</p>
        </div>
        <div class="nav-menu" id="users">
            <span class="fas fa-users"></span>
            <p>Users</p>
        </div>
        <div class="nav-menu" id="update">
            <span class="fas fa-credit-card"></span>
            <p>Update</p>
        </div>
        <div class="nav-menu" id="BookedCars">
            <span class="fas fa-clipboard-list"></span>
            <p>Booked Cars</p>
        </div>
        <div class="nav-menu" id="subscribers">
            <span class="fas fa-id-card"></span>
            <p>Subscribers</p>
        </div>

    </nav>


    <!-- main dashboard -->
    <main>
        <?php if (isset($_GET['delete_success']) && $_GET['delete_success'] == 1) : ?>
            <div class="success-message" id="delete-success-message">
                Record deleted successfully!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['upload_success']) && $_GET['upload_success'] == 1) : ?>
            <div class="success-message" id="upload-success-message">
                Record added successfully!
            </div>
        <?php endif; ?>

        <script>
            setTimeout(function() {
                var deleteMessage = document.getElementById('delete-success-message');
                if (deleteMessage) {
                    deleteMessage.style.display = 'none';
                }
                var uploadMessage = document.getElementById('upload-success-message');
                if (uploadMessage) {
                    uploadMessage.style.display = 'none';
                }
            }, 3000); // 3000 milliseconds = 3 seconds

            // Remove the query parameter to prevent the message from showing on refresh
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('delete_success');
                url.searchParams.delete('upload_success');
                window.history.replaceState(null, '', url);
            }
        </script>
        <div class="dashboard-container" id="overview">
            <!-- 4 top cards -->
            <img class="closeDashboardBtn" id="overview" src="./assets/images/close.png " alt="">

            <!-- 2 bottom cards -->
            <div class="card detail" id="card-detail">
                <div class="detail-header" id="detail-header">
                    <h2>All Cars</h2>


                </div>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Model</th>
                        <th>Type</th>
                        <th>Transmission</th>
                        <th>Price</th>
                        <th>Specs</th>
                        <th>Remove?</th>
                    </tr>
                    <?php foreach ($tableData as $row) : ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['model'] ?></td>
                            <td><?= $row['type'] ?></td>
                            <td><?= $row['transmission'] ?></td>
                            <td><?= $row['price'] ?></td>
                            <td><?= $row['specs'] ?></td>
                            <td>
                                <!-- Add a delete button with a form for each row -->
                                <form action=" delete_car.php" method="post">
                                    <input type="hidden" name="name" value="<?= $row['name'] ?>">
                                    <input type="hidden" name="model" value="<?= $row['model'] ?>">
                                    <input type="hidden" name="type" value="<?= $row['type'] ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>


        </div>
        <div class="dashboard-container" id="update">
            <!-- 4 top cards -->


            <!-- 2 bottom cards -->
            <div class="container">

                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <img class="closeDashboardBtn closeDashboardBtnUpdate" id="update" src="./assets/images/close.png " alt="">
                    </div>
                    <div class="row mb-3">
                        <div class="col">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><input type="text" name="name" required placeholder="name"></div>
                        <div class="col-md-6"> <input type="text" name="model" required placeholder="model"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6"> <select name="type" id="type">
                                <option value="Sedan">Sedan</option>
                                <option value="SUV">SUV</option>
                                <option value="Coupe">Coupe</option>
                            </select></div>
                        <div class="col-md-6"><input type="text" name="numOfSeats" required placeholder="number of seats"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6"> <input type="text" name="bagageSpace" required placeholder="bagage space"></div>
                        <div class="col-md-6"> <input type="text" name="transmission" required placeholder="transmission"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6"><input type="text" name="price" required placeholder="price"></div>
                        <div class="col-md-6"> <input type="text" name="stars" required placeholder="stars"></div>
                    </div>


                    <div class="row">
                        <div class="col">
                            <textarea name="specs" id="specs" placeholder="specs"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="file" name="image" required>
                        </div>
                        <!-- <div class="col-md-6"><input type="submit" name="submit" value="Upload Image"></div> -->
                    </div>
                    <div class="row mt-5">
                        <div class="col">
                            <button type="submit" name="submit" value="Upload Image">Submit</button>
                        </div>
                    </div>


                </form>
            </div>



        </div>

        <div class="dashboard-container" id="users">
            <img class="closeDashboardBtn" id="users" src="./assets/images/close.png " alt="">

            <div class="card detail" id="card-detail">
                <div class="detail-header" id="detail-header">
                    <h2>All Users</h2>


                </div>
                <table>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>

                    </tr>
                    <?php foreach ($tableData2 as $row) : ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['fullName'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td><?= $row['email'] ?></td>



                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

        </div>

        <div class="dashboard-container" id="subscribers">
            <img class="closeDashboardBtn" id="subscribers" src="./assets/images/close.png " alt="">

            <div class="card detail" id="card-detail">
                <div class="detail-header" id="detail-header">
                    <h2>All Subscribers</h2>


                </div>
                <table>
                    <tr>
                        <th>id</th>
                        <th>Email</th>

                    </tr>
                    <?php foreach ($tableData3 as $row) : ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['email'] ?></td>



                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

        </div>

        <div class="dashboard-container" id="BookedCars">
            <img class="closeDashboardBtn" id="BookedCars" src="./assets/images/close.png " alt="">

            <div class="card detail" id="card-detail">
                <div class="detail-header" id="detail-header">
                    <h2>All Booked Cars</h2>


                </div>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Pick Up Address</th>
                        <th>Pick Up Date</th>
                        <th>Pick Up Time</th>
                        <th>Drop-of Address</th>
                        <th>Drop-of Date</th>
                        <th>Drop-of Time</th>
                        <th>Car Name</th>
                        <th>Car Model</th>
                        <th>Status</th>

                    </tr>
                    <?php foreach ($tableData4 as $row) : ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td><?= $row['pickUpAddress'] ?></td>
                            <td><?= $row['pickUpDate'] ?></td>
                            <td><?= $row['pickUpTime'] ?></td>
                            <td><?= $row['dropOffAddress'] ?></td>
                            <td><?= $row['dropOffDate'] ?></td>
                            <td><?= $row['dropOffTime'] ?></td>
                            <td><?= $row['carName'] ?></td>
                            <td><?= $row['carModel'] ?></td>
                            <td><?= $row['status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="./main.js"></script>

</body>

</html>