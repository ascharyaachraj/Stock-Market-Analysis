<?php
// Define variables and initialize with empty values
$name = $email = $subject = $message = "";
$name_err = $email_err = $subject_err = $message_err = "";
$success_message = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
        // Check if name contains only letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $name_err = "Only letters and white space allowed";
        }
    }
    
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        }
    }
    
    // Validate subject
    if (empty(trim($_POST["subject"]))) {
        $subject_err = "Please enter a subject.";
    } else {
        $subject = htmlspecialchars(trim($_POST["subject"]));
    }
    
    // Validate message
    if (empty(trim($_POST["message"]))) {
        $message_err = "Please enter your message.";
    } else {
        $message = htmlspecialchars(trim($_POST["message"]));
    }
    
    // Check input errors before sending email
    if (empty($name_err) && empty($email_err) && empty($subject_err) && empty($message_err)) {
        
        // Recipient email (change this to your email)
        $to = "your-email@example.com";
        
        // Email headers
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        // Email content
        $email_content = "
            <html>
            <head>
                <title>New Contact Form Submission</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background-color: #f8f9fa; padding: 10px; text-align: center; }
                    .content { padding: 20px; }
                    .footer { background-color: #f8f9fa; padding: 10px; text-align: center; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>New Contact Form Submission</h2>
                    </div>
                    <div class='content'>
                        <p><strong>Name:</strong> $name</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>Subject:</strong> $subject</p>
                        <p><strong>Message:</strong></p>
                        <p>$message</p>
                    </div>
                    <div class='footer'>
                        <p>This email was sent from your website contact form.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        
        // Send email
        if (mail($to, $subject, $email_content, $headers)) {
            $success_message = "Thank you! Your message has been sent successfully.";
            // Clear form fields
            $name = $email = $subject = $message = "";
        } else {
            $success_message = "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }
        .contact-section {
            padding: 60px 0;
        }
        .contact-form {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            margin-bottom: 30px;
            color: #0d6efd;
            position: relative;
            padding-bottom: 10px;
        }
        .form-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: #0d6efd;
        }
        .contact-info {
            padding: 30px;
            background-color: #0d6efd;
            color: white;
            border-radius: 10px;
            height: 100%;
        }
        .contact-info h3 {
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        .contact-info h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: white;
        }
        .info-item {
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
        }
        .info-item i {
            margin-right: 15px;
            font-size: 20px;
        }
        .btn-submit {
            background-color: #0d6efd;
            border: none;
            padding: 10px 30px;
            font-weight: 600;
        }
        .btn-submit:hover {
            background-color: #0b5ed7;
        }
        .is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
        }
        .alert-success {
            background-color: #d1e7dd;
            border-color: #badbcc;
            color: #0f5132;
        }
    </style>
</head>
<body>
    <section class="contact-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="contact-form">
                                <h2 class="form-title">Get in touch</h2>
                                
                                <?php if (!empty($success_message)): ?>
                                    <div class="alert alert-success mb-4"><?php echo $success_message; ?></div>
                                <?php endif; ?>
                                
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Your Name</label>
                                        <input type="text" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" 
                                               id="name" name="name" value="<?php echo $name; ?>">
                                        <div class="invalid-feedback"><?php echo $name_err; ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" 
                                               id="email" name="email" value="<?php echo $email; ?>">
                                        <div class="invalid-feedback"><?php echo $email_err; ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="subject" class="form-label">Subject</label>
                                        <input type="text" class="form-control <?php echo (!empty($subject_err)) ? 'is-invalid' : ''; ?>" 
                                               id="subject" name="subject" value="<?php echo $subject; ?>">
                                        <div class="invalid-feedback"><?php echo $subject_err; ?></div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="message" class="form-label">Your Message</label>
                                        <textarea class="form-control <?php echo (!empty($message_err)) ? 'is-invalid' : ''; ?>" 
                                                  id="message" name="message" rows="5"><?php echo $message; ?></textarea>
                                        <div class="invalid-feedback"><?php echo $message_err; ?></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-submit">Send Message</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="contact-info">
                                <h3>Contact Information</h3>
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <h5>Location</h5>
                                        <p>123 Business Street, City, Country</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-envelope"></i>
                                    <div>
                                        <h5>Email</h5>
                                        <p>info@example.com</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-phone-alt"></i>
                                    <div>
                                        <h5>Phone</h5>
                                        <p>+1 (123) 456-7890</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-clock"></i>
                                    <div>
                                        <h5>Working Hours</h5>
                                        <p>Monday - Friday: 9AM - 5PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>