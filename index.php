<html>

<head>
    <Title>Registration Form</Title>
    <style type="text/css">
        body {
            background-color: #fff;
            border-top: solid 10px #000;
            color: #333;
            font-size: .85em;
            margin: 20;
            padding: 20;
            font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
        }

        h1,
        h2,
        h3,
            {
            color: #000;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        h1 {
            font-size: 2em;
        }

        h2 {
            font-size: 1.75em;
        }

        h3 {
            font-size: 1.2em;
        }

        table {
            margin-top: 0.75em;
        }

        th {
            font-size: 1.2em;
            text-align: left;
            border: none;
            padding-left: 0;
        }

        td {
            padding: 0.25em 2em 0.25em 0em;
            border: 0 none;
        }
    </style>
</head>

<body>
    <h1>Data Pribadi!</h1>
    <p>Masukkan nama, Alamat dan kota anda lalu tekan <strong>Submit</strong> untuk registrasi.</p>
    <form method="post" action="index.php" enctype="multipart/form-data">
        Name <input type="text" name="name" id="name" /></br></br>
        Alamat <input type="text" name="alamat" id="alamat" /></br></br>
        Kota <input type="text" name="kota" id="kota" /></br></br>
        <input type="submit" name="submit" value="Submit" />
        <input type="submit" name="load_data" value="Load Data" />
    </form>

    <?php
    $host = "ferywebserver";
    $user = "Fery";
    $pass = "1234Qwer";
    $db = "webdatabase";

    try {
        $conn = new PDO($host, $db, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo "Failed: " . $e;
    }

    if (isset($_POST['submit'])) {
        try {
            $name = $_POST['nama'];
            $alamat = $_POST['alamat'];
            $kota = $_POST['kota'];
            // Insert data
            $sql_insert = "INSERT INTO registrasi (nama, alamat, kota) 
                        VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $alamat);
            $stmt->bindValue(3, $kota);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Failed: " . $e;
        }

        echo "<h3>Your're registered!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM registrasi";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll();
            if (count($registrants) > 0) {
                echo "<h2>People who are registered:</h2>";
                echo "<table>";
                echo "<tr><th>Name</th>";
                echo "<th>Alamat</th>";
                echo "<th>Kota</th>";

                foreach ($registrants as $registrant) {
                    echo "<tr><td>" . $registrant['name'] . "</td>";
                    echo "<td>" . $registrant['alamat'] . "</td>";
                    echo "<td>" . $registrant['kota'] . "</td>";
                    echo "<td>" . $registrant['date'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>No one is currently registered.</h3>";
            }
        } catch (Exception $e) {
            echo "Failed: " . $e;
        }
    }
    ?>
</body>

</html> 