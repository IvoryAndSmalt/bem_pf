<?php

class RequestHandler
{

    private $email;
    private $subject;
    private $email_message;

    public function return(int $code, string $status_message, string $feedback)
    {
        header('Content-Type: application/json');

        http_response_code($code);

        echo json_encode([
            "status_message" => $status_message,
            "feedback_message" => $feedback
        ]);
    }

    public function checkMethod($method): bool
    {
        if ($method === "POST") {
            return true;
        } else {
            return false;
        }
    }

    public function verifyFields(array $array): bool
    {
        //validate if email
        foreach ($array as $key => $value) {
            if ($key === "email") {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
            } elseif ($value !== strip_tags($value)) {
                return false;
            }
        }

        //apply several filters to all fields
        $array = array_map(function ($el) {
            return htmlspecialchars(stripslashes(trim($el)));
        }, $array);

        $this->email = $array['email'];
        $this->subject = $array['subject'];
        $this->email_message = $array['message'];

        return true;
    }

    public function sendMail()
    {
        $my_email = "lucas180395@gmail.com";
        $modified_subject = "Contact - " . $this->email . " - " . $this->subject;
        $headers = 'From: contact@lucasvandenberg.fr' . "\r\n" .
            'Reply-To: ' . $this->email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        try {
            header('Content-Type: application/json');
            if (mail($my_email, $modified_subject, $this->email_message, $headers)) {
                $this->return(200, "email successfully sent", "Votre message a été envoyé correctement.");
            } else {
                $this->return(501, "sendmail failure", "Votre email n'a pas pu être envoyé. Veuillez réessayer plus tard.");
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');

            $this->return(500, $e->getTraceAsString(), "Erreur dans l'envoi d'email.");
        }
    }
}