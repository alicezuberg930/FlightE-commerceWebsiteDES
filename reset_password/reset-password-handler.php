<?php require_once("../connection.php");
require_once("../DESAlgorithm.php");
if (isset($_POST["reset-password-submit"])) {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["password"];
    $retypexPassword = $_POST["retype_password"];
    if (empty($password) || empty($retypexPassword)) {
        header("location: ../pages/create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&notify=emptyfields");
    } else if ($password !== $retypexPassword) {
        header("location: ../pages/create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&notify=notmatch");
    } else {
        $currentDate = date("U");
        $result = GetObjectArray("select * from resetpassword where ResetSelector = '" . $selector . "'")[0];
        if ($result["RESETEXPIRE"] < $currentDate) {
            header("Location: ../pages/create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&notify=expired");
        } else {
            if ($validator == DecryptCiphertextFromHexadecimal($result["RESETTOKEN"])) {
                $email = $result["RESETEMAIL"];
                Query("update member set Password=q'[" . utf8_encode(EncryptPlaintext($password)) . "]' where Email=q'[" . utf8_encode(EncryptPlaintext($email)) . "]'");
                Query("delete from resetpassword where ResetEmail = '$email'");
                header("Location: ../pages/create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&notify=success");
            } else {
                header("Location: ../pages/create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&notify=wrongtoken");
            }
        }
    }
} else {
    header("location: ./index.php");
}
