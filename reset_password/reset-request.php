<?php require_once("../connection.php");
require_once("../DESAlgorithm.php");
$a = explode("/", $_SERVER["SCRIPT_FILENAME"]);
$string = '';
for ($i = 3; $i < sizeof($a) - 2; $i++) {
    $string .= $a[$i] . "/";
}
$url = "http://localhost/" . $string . "/pages/create-new-password.php";
if (isset($_POST["reset-request-submit"])) {
    $selector = generateRandomString(8);
    $token = generateRandomString(24);
    $url = $url . "?selector=" . $selector . "&validator=" . $token;
    $expire_in = date("U") + 300;
    Query("delete from resetpassword where ResetEmail = '" . $_POST["email"] . "'");
    Query("INSERT INTO resetpassword(ResetEmail, ResetSelector, ResetToken, ResetExpire) values ('" . $_POST["email"] . "','$selector','" . EncryptPlaintextToHexadecimal($token) . "','$expire_in')");
    $subject = "Reset your password for VeMayBay.com";
    $message = '
    <table style="margin-bottom: 1rem;">
    <thead>
        <tr>
            <th>
                <img style="width: 4rem; margin-right: 1rem;" src="https://pngset.com/images/airplane-airport-delivery-flying-logistics-plane-icon-aircraft-vehicle-transportation-jet-transparent-png-1630378.png">
            </th>
            <th>
                <span style="font-weight: bold; font-style: italic; color: blueviolet; font-size: 1.5rem;">VeMayBay.com</span>
            </th>
        </tr>
    </thead>
    </table>
    <div style="color: gray;">
        <p>We received a password reset request. The link to reset your password is below.</p>
        <p>The link will be expired in 5 minutes.</p>
        <p>Here is your password reset link: <a href=' . $url . '>' . $url . '</a></p>
    </div>';
    require_once("../PHPMailer/PHPMailerAutoload.php");
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = "465";
    $mail->isHTML();
    $mail->Username = "zipphub@gmail.com";
    $mail->Password = "zippohub123";
    $mail->setFrom("no-reply@zippohub.com");
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->addAddress($_POST["email"]);
    $mail->send();
    echo '<h2 class="text-success">Thành công</h2>
    <p>Đã gửi email thành công đến địa chỉ: <strong>' . $_POST["email"] . '<strong></p>';
}

function generateRandomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
