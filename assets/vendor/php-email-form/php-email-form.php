<?php
class PHP_Email_Form {
    public $ajax = false;
    public $to = '';
    public $from_name = '';
    public $from_email = '';
    public $subject = '';
    public $message = '';

    public function add_message($message, $name) {
        $this->message .= "$name: $message\n";
    }

    public function send() {
        // Memeriksa apakah alamat email valid
        if (!filter_var($this->from_email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Mengatur header email
        $headers = "From: $this->from_name <$this->from_email>\r\n";
        $headers .= "Reply-To: $this->from_email\r\n";

        // Mengirim email
        return mail($this->to, $this->subject, $this->message, $headers);
    }
}

// Jika file ini diakses melalui AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact = new PHP_Email_Form();
    $contact->to = 'comsmakda@gmail.com'; // Ganti dengan alamat email tujuan
    $contact->from_name = $_POST['name'];
    $contact->from_email = $_POST['email'];
    $contact->subject = $_POST['subject'];
    $contact->add_message($_POST['message'], 'Message');

    // Mengirim email dan mengembalikan respons
    if ($contact->send()) {
        echo json_encode(['status' => 'success', 'message' => 'Pesan berhasil dikirim!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim pesan.']);
    }
}
?>