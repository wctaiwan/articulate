<?php
require_once 'updater.php';
include 'header.php';
update(isset($_GET['r']));
include 'footer.php';
