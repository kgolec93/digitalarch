<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo "Wystąpił błąd. Wypełnij wszystkie pola jeszcze raz";
            exit;
        }

        $recipient = "digitalarch@digitalarch.pl";

        $subject = "Formularz kontaktowy digital.ARCH";

        $email_content = "Nadawca: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Wiadomość:\n$message\n";

        $header = "";
        $header .= "Od: " . $email . "\n";
        $header .= "Content-Type:text/plain;charset=utf-8";

        if (mail($recipient, $subject, $email_content, $header)) {
            http_response_code(200);
            echo "Twoja wiadomość została wysłana!";
        } else {
            http_response_code(500);
            echo "Wystąpił błąd i wiadomość nie została wysłana";
        }

    } else {
        http_response_code(403);
        echo "Wystąpił problem z Twoją wiadomością. Spróbuj ponownie";
    }
?>
