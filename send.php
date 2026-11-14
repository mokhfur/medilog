<?php
/**
 * MediLog contact form handler.
 *
 * SETTINGS: change these two addresses if needed.
 *  MAIL_TO   = where contact form messages are delivered.
 *  MAIL_FROM = sender address. It must be an address on this website's own
 *              domain (create it in hPanel > Emails), or messages may land in spam.
 */
const MAIL_TO   = 'info@shaficonsultancy.com';
const MAIL_FROM = 'no-reply@medilog.co.uk';

function back(string $where): void {
    header('Location: ' . $where, true, 303);
    exit;
}

function field(string $name, int $max): string {
    $value = isset($_POST[$name]) && is_string($_POST[$name]) ? $_POST[$name] : '';
    $value = trim(str_replace("\0", '', $value));
    return mb_substr($value, 0, $max, 'UTF-8');
}

function one_line(string $value): string {
    return trim(preg_replace('/[\r\n\t]+/', ' ', $value));
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    back('contact.html');
}

// Spam traps: hidden field must stay empty, and the form must not be sent within 2 seconds of loading.
if (field('website', 200) !== '') {
    back('thanks.html');
}
$loaded = field('t', 20);
if ($loaded !== '' && ctype_digit($loaded) && (microtime(true) * 1000 - (float) $loaded) < 2000) {
    back('thanks.html');
}

$first   = one_line(field('first_name', 100));
$email   = one_line(field('email', 200));
$phone   = one_line(field('phone', 40));
$subject = one_line(field('subject', 150));
$message = field('message', 5000);

if ($first === '' || $subject === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    back('contact.html?error=invalid');
}

$body  = "New message from the MediLog website contact form\n";
$body .= "--------------------------------------------------\n";
$body .= "First name: {$first}\n";
$body .= "Email:      {$email}\n";
$body .= 'Phone:      ' . ($phone !== '' ? $phone : '(not given)') . "\n";
$body .= "Subject:    {$subject}\n\n";
$body .= "Message:\n{$message}\n";

$headers = [
    'From: MediLog website <' . MAIL_FROM . '>',
    'Reply-To: ' . $email,
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
];
$mailSubject = '=?UTF-8?B?' . base64_encode('MediLog website: ' . $subject) . '?=';

$sent = @mail(MAIL_TO, $mailSubject, $body, implode("\r\n", $headers), '-f' . MAIL_FROM);

back($sent ? 'thanks.html' : 'contact.html?error=send');
