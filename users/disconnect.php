<?php
session_start();
session_destroy();
header('Location: /cp6-7/index.php');
