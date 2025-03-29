<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_POST['send'])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $message = $_POST['message'];
    $sql = "INSERT INTO tblcontactusquery(name, EmailId, ContactNumber, Message) VALUES(:name, :email, :contactno, :message)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':contactno', $contactno, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        $msg = "Query Sent. We will contact you shortly";
    } else {
        $error = "Something went wrong. Please try again";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blood Donation - Contact Us</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/modern-business.css" rel="stylesheet">

    <style>
        body {
            background-color: #f2f2f2; /* Light gray background for the body */
        }

        .contact-container {
            background-color: #ffffff; /* White background for the container */
            border-radius: 8px; /* Rounded corners */
            padding: 30px; /* Increased padding */
            transition: all 0.3s ease; /* Smooth transition for hover effect */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            margin-bottom: 30px; /* Space below the container */
        }

        .contact-container:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
        }

        .btn-primary {
            background-color: #c0392b; /* Blood red color */
            border-color: #c0392b; /* Border color */
        }

        .btn-primary:hover {
            background-color: #a93226; /* Darker red on hover */
            border-color: #a93226; /* Darker border on hover */
        }

        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        /* Add margin to the top of the content to prevent overlap with the header */
        .content {
            margin-top: 20px; /* Adjust this value as needed */
        }

        /* New styles for the contact form */
        .contact-header {
            background-color: #e74c3c; /* Red background for header */
            color: white; /* White text color */
            padding: 15px; /* Padding for header */
            border-radius: 8px 8px 0 0; /* Rounded corners for the top */
            text-align: center; /* Centered text */
        }

        .contact-container {
            border: 1px solid #e74c3c; /* Red border for the container */
        }
    </style>
</head>

<body>

    <?php include('includes/header.php'); ?>

    <div class="container-fluid content">
        <h1 class="mt-4 mb-3 text-center">Contact Us</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">Contact</li>
        </ol>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="contact-container">
                    <div class="contact-header">
                        <h3>Send us a Message</h3>
                    </div>
                    <?php if ($error) { ?>
                        <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
                    <?php } else if ($msg) { ?>
                        <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
                    <?php } ?>
                    <form name="sentMessage" method="post">
                        <div class="control-group form-group">
                            <div class="controls">
                                <label>Full Name:</label>
                                <input type="text" class="form-control" id="name" name="fullname" required data-validation-required-message="Please enter your name.">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <div class="controls">
                                <label>Phone Number:</label>
                                <input type="tel" class="form-control" id="phone" name="contactno" required data-validation-required-message="Please enter your phone number.">
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <div class="controls">
                                <label>Email Address:</label>
                                <input type="email" class="form-control" id="email" name="email" required data-validation-required-message="Please enter your email address.">
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <div class="controls">
                                <label>Message:</label>
                                <textarea rows="10" cols="100" class="form-control" id="message" name="message" required data-validation-required-message="Please enter your message" maxlength="999" style="resize:none"></textarea>
                            </div>
                        </div>
                        <div id="success"></div>
                        <button type="submit" name="send" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>

            <!-- Contact Details Column -->
            <?php 
            $pagetype = $_GET['type'];
            $sql = "SELECT Address, EmailId, ContactNo from tblcontactusinfo";
            $query = $dbh->prepare($sql);
            $query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($results as $result) { ?>
                    <div class="col-lg-4 mb-4">
                        <h3>Contact Details</h3>
                        <p><?php echo htmlentities($result->Address); ?><br></p>
                        <p><abbr title="Phone">P</abbr>: <?php echo htmlentities($result->ContactNo); ?></p>
                        <p><abbr title="Email">E</abbr>: <a href="mailto:name@example.com"><?php echo htmlentities($result->EmailId); ?></a></p>
                    </div>
                <?php }
            } ?>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/tether/tether.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

</body>

</html>