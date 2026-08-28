<?php
session_start();


if (isset($_SESSION["students"])) {
    $_SESSION["students"] = null;
    unset($_SESSION["students"]);
}

session_destroy();
echo ("success");
?>