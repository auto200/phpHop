<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="GET" action="index.php">
        <select name="owner">
            <?php
            $owners = ["Carlsberg Polska", "Grupa Żywiec", "Kompania Piwowarska", "Van Pur"];
            foreach ($owners as $owner) {
                echo "<option value='$owner'>$owner</option>";
            }
            ?>
        </select>
        <button type="submit">Submit</button>

    </form>
    <?php
    require("./testing.php");
    ?>
</body>

</html>
<?php
?>