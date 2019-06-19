<?php
header("Content-Type:text/css");
$hover = "#f0f"; // Change your Color Here

function checkhexcolor($hover)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $hover);
}

if (isset($_GET['hover']) AND $_GET['hover'] != '') {
    $hover = "#" . $_GET['hover'];
}

if (!$hover OR !checkhexcolor($hover)) {
    $hover = "#336699";
}

?>


@import url('https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i,800,800i');

.orange-circle-button:hover {
border-color: <?php echo $hover ?>;
}
