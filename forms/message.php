<?php
require_once '../registration/config.php';
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$name    = mysqli_real_escape_string($conn, trim($_POST['name']    ?? ''));
$email   = mysqli_real_escape_string($conn, trim($_POST['email']   ?? ''));
$phone   = mysqli_real_escape_string($conn, trim($_POST['phone']   ?? ''));
$country = mysqli_real_escape_string($conn, trim($_POST['country'] ?? ''));
$message = mysqli_real_escape_string($conn, trim($_POST['message'] ?? ''));

if (empty($email) || empty($message)) {
    echo "Email and message fields are required!";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Enter a valid email address!";
    exit;
}

/* ── Save to database ───────────────────────────────── */
$sql = "INSERT INTO messages (name, email, phone, country, message)
        VALUES ('$name', '$email', '$phone', '$country', '$message')";

if (!mysqli_query($conn, $sql)) {
    echo "Sorry, failed to save your message. Please try again.";
    exit;
}

/* ── Shared mailer helper ───────────────────────────── */
function buildMailer(): PHPMailer {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'mondotoil@gmail.com';
    $mail->Password   = getenv('GMAIL_APP_PASSWORD');
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';
    return $mail;
}

/* ── 1. Notify mondotoil@gmail.com ──────────────────── */
try {
    $mail = buildMailer();
    $mail->setFrom('mondotoil@gmail.com', 'Mt Giluwe Website');
    $mail->addAddress('mondotoil@gmail.com', 'Mt Giluwe Admin');
    $mail->addReplyTo($email, $name ?: 'Visitor');

    $mail->isHTML(true);
    $mail->Subject = 'New Contact Message — Mt Giluwe';
    $mail->Body = "
    <div style='font-family:Inter,sans-serif;max-width:600px;margin:auto;'>
      <div style='background:#1f2833;padding:28px 32px;border-radius:8px 8px 0 0;'>
        <h2 style='color:#ff9100;margin:0;font-size:22px;'>New Contact Message</h2>
        <p style='color:rgba(255,255,255,.7);margin:6px 0 0;font-size:14px;'>Submitted via Mt Giluwe website</p>
      </div>
      <div style='background:#f8f9fb;padding:28px 32px;border-radius:0 0 8px 8px;'>
        <table style='width:100%;border-collapse:collapse;font-size:15px;'>
          <tr><td style='padding:8px 0;color:#6b7280;width:110px;'>Name</td>
              <td style='padding:8px 0;color:#1a1a1a;font-weight:600;'>" . htmlspecialchars($name) . "</td></tr>
          <tr><td style='padding:8px 0;color:#6b7280;'>Email</td>
              <td style='padding:8px 0;color:#1a1a1a;'><a href='mailto:" . htmlspecialchars($email) . "' style='color:#ff9100;'>" . htmlspecialchars($email) . "</a></td></tr>
          <tr><td style='padding:8px 0;color:#6b7280;'>Phone</td>
              <td style='padding:8px 0;color:#1a1a1a;'>" . (htmlspecialchars($phone) ?: '—') . "</td></tr>
          <tr><td style='padding:8px 0;color:#6b7280;'>Country</td>
              <td style='padding:8px 0;color:#1a1a1a;'>" . (htmlspecialchars($country) ?: '—') . "</td></tr>
        </table>
        <div style='margin-top:20px;padding:16px;background:#fff;border-left:4px solid #ff9100;border-radius:4px;'>
          <p style='color:#374151;font-size:15px;line-height:1.7;margin:0;'>" . nl2br(htmlspecialchars($message)) . "</p>
        </div>
      </div>
    </div>";
    $mail->AltBody = "New contact message from {$name} ({$email})\nPhone: {$phone}\nCountry: {$country}\n\nMessage:\n{$message}";

    $mail->send();
} catch (Exception $e) {
    // Log error but don't fail — DB save already succeeded
    error_log('Admin email failed: ' . $e->getMessage());
}

/* ── 2. Confirmation email to the user ──────────────── */
try {
    $mail2 = buildMailer();
    $mail2->setFrom('mondotoil@gmail.com', 'Mt Giluwe');
    $mail2->addAddress($email, $name ?: 'Visitor');

    $mail2->isHTML(true);
    $mail2->Subject = 'We received your message — Mt Giluwe';
    $mail2->Body = "
    <div style='font-family:Inter,sans-serif;max-width:600px;margin:auto;'>
      <div style='background:#1f2833;padding:28px 32px;border-radius:8px 8px 0 0;text-align:center;'>
        <h2 style='color:#ff9100;margin:0;font-size:24px;letter-spacing:-.5px;'>Mt Giluwe</h2>
        <p style='color:rgba(255,255,255,.7);margin:6px 0 0;font-size:14px;'>Southern Highlands Province, Papua New Guinea</p>
      </div>
      <div style='background:#f8f9fb;padding:32px;border-radius:0 0 8px 8px;'>
        <p style='font-size:16px;color:#1a1a1a;margin:0 0 12px;'>Hi " . htmlspecialchars($name ?: 'there') . ",</p>
        <p style='font-size:15px;color:#374151;line-height:1.7;margin:0 0 20px;'>
          Thank you for reaching out! We have received your message and our team will get back to you within <strong>24 hours</strong>.
        </p>
        <div style='padding:16px;background:#fff;border-left:4px solid #ff9100;border-radius:4px;margin-bottom:24px;'>
          <p style='color:#6b7280;font-size:13px;margin:0 0 6px;text-transform:uppercase;letter-spacing:.05em;'>Your message</p>
          <p style='color:#374151;font-size:15px;line-height:1.7;margin:0;'>" . nl2br(htmlspecialchars($message)) . "</p>
        </div>
        <p style='font-size:14px;color:#6b7280;margin:0;'>
          If you have an urgent enquiry, call us at <strong>+675 000 0000</strong> or reply to this email.
        </p>
      </div>
      <p style='text-align:center;font-size:12px;color:#9ca3af;margin-top:16px;'>
        &copy; " . date('Y') . " Mt Giluwe Tourism &mdash; Papua New Guinea
      </p>
    </div>";
    $mail2->AltBody = "Hi {$name},\n\nThank you for contacting Mt Giluwe! We received your message and will reply within 24 hours.\n\nYour message:\n{$message}\n\n— Mt Giluwe Team";

    $mail2->send();
} catch (Exception $e) {
    error_log('User confirmation email failed: ' . $e->getMessage());
}

echo "success";
?>
