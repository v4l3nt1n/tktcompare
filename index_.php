<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'input_submit.php';
}
?>
<html>
<head>
    <title>Prueba archivos multiples</title>
    <link href="http://api.tucanotours.com.ar/bs/css/tucano.bs.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="css/coef-admin.css" rel="stylesheet">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="http://api.tucanotours.com.ar/bs/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/tktcompare.js"></script>
    <style type="text/css">
    table td {
        font-size: 10px;
        font-weight: bold;
    }
    </style>
</head>
<body>
    <form method="post" action="" enctype="multipart/form-data">
        <input name="files[]" id="files" type="file" multiple="" />
        <input type="submit" value="go!!!" >
    </form>
    <hr>    
    <?php
        echo "<h3>MISSING</h3>";
        if (!empty($missing)) {
            echo "<p>Sabre</p>";
            echo "<table border='1'>";
            foreach ($missing['missing_sabre'] as $key => $ticket) {
                echo "<tr>";
                    foreach ($ticket as $key => $value) {
                        echo "<td>".$value."</td>";
                    }
                echo "</tr>";
            }
            echo "</table>";
            echo "<hr>";
            echo "<p>Amadeus</p>";
            echo "<table border='1'>";
            foreach ($missing['missing_amadeus'] as $key => $ticket) {
                echo "<tr>";
                    foreach ($ticket as $key => $value) {
                        echo "<td>".$value."</td>";
                    }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No hay Faltantes.</p>";
        }
        
        echo "<hr>";
        echo "<h3>VOIDS</h3>";
        if (!empty($voids)) {
            echo "<p>Sabre</p>";
            echo "<table border='1'>";
            foreach ($voids['void_sabre'] as $key => $ticket) {
                echo "<tr>";
                    foreach ($ticket as $key => $value) {
                        echo "<td>".$value."</td>";
                    }
                echo "</tr>";
            }
            echo "</table>";
            echo "<hr>";
            echo "<p>Amadeus</p>";
            echo "<table border='1'>";
            foreach ($voids['void_amadeus'] as $key => $ticket) {
                echo "<tr>";
                    foreach ($ticket as $key => $value) {
                        echo "<td>".$value."</td>";
                    }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No hay Voids.</p>";
        }
    ?>
</body>
</html>