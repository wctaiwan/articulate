<?php
require_once 'Updater.php';
include 'header.php';
(new Updater(isset($_GET['r'])))->update();
include 'footer.php';
