<?php
header("Content-Type:text/css");
$color2 = "#f0f"; // Change your Color Here

function checkhexcolor($color2)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color2);
}

if (isset($_GET['color2']) AND $_GET['color2'] != '') {
    $color2 = "#" . $_GET['color2'];
}

if (!$color2 OR !checkhexcolor($color2)) {
    $color2 = "#336699";
}

?>


@import url('https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i,800,800i');




.orange-circle-button {
border: .5em solid <?php echo $color2 ?>;
background-color: <?php echo $color2 ?>;
}

.orange-circle-button:hover {
background-color: <?php echo $color2 ?>;
}