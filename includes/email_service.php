<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class EmailService {
    private $db;
    private $fromEmail;
    private $fromName;
    private $mailer; // PHPMailer instance
    
    public function __construct($database) {
        $this->db = $database;
        $this->fromEmail = 'noreply@zenusbank.com'; // Your sender email
        $this->fromName = 'Zenus Bank'; // Your sender name

        // Initialize PHPMailer
        $this->mailer = new PHPMailer(true); // true enables exceptions
        try {
            // Server settings
            $this->mailer->isSMTP();                                            // Send using SMTP
            $this->mailer->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $this->mailer->SMTPAuth   = true;                                   // Enable SMTP authentication
            $this->mailer->Username   = 'your_gmail_email@gmail.com';           // SMTP username (your email)
            $this->mailer->Password   = 'your_gmail_app_password';              // SMTP password (your app password if 2FA is on)
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $this->mailer->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $this->mailer->CharSet    = 'UTF-8';
            $this->mailer->Encoding   = 'base64';

            // Recipients
            $this->mailer->setFrom($this->fromEmail, $this->fromName);
            
        } catch (Exception $e) {
            error_log("PHPMailer setup error: " . $e->getMessage());
            // You might want to throw an exception or handle this more gracefully
            // if the mailer setup is critical for the application to run.
        }
    }
    
    public function getTemplate($templateName) {
        try {
            $query = "SELECT * FROM email_templates WHERE template_name = ? AND is_active = 1 LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $templateName);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (Exception $e) {
            error_log("Error fetching email template: " . $e->getMessage());
            return null;
        }
    }
    
    public function replaceVariables($content, $variables) {
        foreach ($variables as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }
        return $content;
    }
    
    public function sendEmail($templateName, $recipientEmail, $variables = [], $userId = null) {
        // Reset mailer for each send to clear previous recipients/attachments etc.
        $this->mailer->clearAllRecipients();
        $this->mailer->clearAttachments();

        try {
            // Get template
            $template = $this->getTemplate($templateName);
            if (!$template) {
                throw new Exception("Email template not found: " . $templateName);
            }
            
            // Replace variables in subject and body
            $subject = $this->replaceVariables($template['subject'], $variables);
            $bodyHtml = $this->replaceVariables($template['body_html'], $variables);
            $bodyText = $this->replaceVariables($template['body_text'], $variables);
            
            // Log email attempt
            $logId = $this->logEmail($userId, $templateName, $recipientEmail, $subject);
            
            // Add recipient
            $this->mailer->addAddress($recipientEmail);
            
            // Content
            $this->mailer->isHTML(true); // Set email format to HTML
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $bodyHtml;
            $this->mailer->AltBody = $bodyText; // Plain text for non-HTML mail clients
            
            $this->mailer->send();
            
            $this->updateEmailLog($logId, 'sent');
            return ['success' => true, 'message' => 'Email sent successfully'];
            
        } catch (Exception $e) {
            if (isset($logId)) {
                $this->updateEmailLog($logId, 'failed', $e->getMessage());
            }
            error_log("Email sending error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Email sending error: ' . $e->getMessage()];
        }
    }
    
    private function logEmail($userId, $templateName, $recipientEmail, $subject) {
        try {
            $query = "INSERT INTO email_logs (user_id, template_name, recipient_email, subject, status) VALUES (?, ?, ?, ?, 'pending')";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $templateName);
            $stmt->bindParam(3, $recipientEmail);
            $stmt->bindParam(4, $subject);
            $stmt->execute();
            
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            error_log("Error logging email: " . $e->getMessage());
            return null;
        }
    }
    
    private function updateEmailLog($logId, $status, $errorMessage = null) {
        try {
            if ($status === 'sent') {
                $query = "UPDATE email_logs SET status = ?, sent_at = NOW() WHERE id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(1, $status);
                $stmt->bindParam(2, $logId);
            } else {
                $query = "UPDATE email_logs SET status = ?, error_message = ? WHERE id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(1, $status);
                $stmt->bindParam(2, $errorMessage);
                $stmt->bindParam(3, $logId);
            }
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Error updating email log: " . $e->getMessage());
        }
    }
    
    public function sendWelcomeEmail($userData) {
        $variables = [
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
            'email' => $userData['email'],
            'account_type' => ucfirst($userData['account_type']),
            'account_currency' => $userData['account_currency'],
            'registration_date' => date('F j, Y'),
            'login_url' => 'https://' . $_SERVER['HTTP_HOST'] . '/login.php'
        ];
        
        return $this->sendEmail('welcome_email', $userData['email'], $variables, $userData['user_id'] ?? null);
    }
}
?>
