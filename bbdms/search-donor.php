<?php
error_reporting(0);
include('includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>BloodBank & Donor Management System | Become A Donor</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/modern-business.css" rel="stylesheet">
    <style>
    .navbar-toggler { z-index: 1; }
    @media (max-width: 576px) { nav > .container { width: 100%; } }
    .container-bg { background-color: #ffcccc; padding: 20px; border-radius: 10px; }
    .errorWrap { padding: 10px; margin: 0 0 20px 0; background: #fff; border-left: 4px solid #dd3d36; box-shadow: 0 1px 1px 0 rgba(0,0,0,.1); }
    .succWrap { padding: 10px; margin: 0 0 20px 0; background: #fff; border-left: 4px solid #5cb85c; box-shadow: 0 1px 1px 0 rgba(0,0,0,.1); }
    </style>
</head>
<body>
<?php include('includes/header.php');?>
<div class="container container-bg">
    <h1 class="mt-4 mb-3">Search <small>Donor</small></h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Search Donor</li>
    </ol>
    <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
    else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
    <form name="donor" method="post">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="font-italic">Blood Group<span style="color:red">*</span></div>
                <div>
                    <select name="bloodgroup" class="form-control" required>
                        <option value="">Select Blood Group</option>
                        <?php 
                        $sql = "SELECT * from tblbloodgroup";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        if($query->rowCount() > 0) {
                            foreach($results as $result) { ?>  
                                <option value="<?php echo htmlentities($result->BloodGroup);?>"><?php echo htmlentities($result->BloodGroup);?></option>
                            <?php }} ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="font-italic">Location</div>
                <div><textarea class="form-control" name="location"></textarea></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div><input type="submit" name="submit" class="btn btn-primary" value="Search" style="cursor:pointer"></div>
            </div>
        </div>
    </form>
    <div class="row">
        <?php 
        if(isset($_POST['submit'])) {
            $status=1;
            $bloodgroup=isset($_POST['bloodgroup']) ? $_POST['bloodgroup'] : '';
            $location=isset($_POST['location']) ? $_POST['location'] : '';
            
            $sql = "SELECT * FROM tblblooddonars WHERE status=:status";
            if (!empty($bloodgroup)) {
                $sql .= " AND BloodGroup=:bloodgroup";
            }
            if (!empty($location)) {
                $sql .= " AND Address LIKE :location";
            }
            
            $query = $dbh->prepare($sql);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            if (!empty($bloodgroup)) {
                $query->bindParam(':bloodgroup', $bloodgroup, PDO::PARAM_STR);
            }
            if (!empty($location)) {
                $query->bindValue(':location', "%$location%", PDO::PARAM_STR);
            }
            
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            if($query->rowCount() > 0) {
                foreach($results as $result) { ?>
                    <div class="col-lg-4 col-sm-6 portfolio-item">
                        <div class="card h-100">
                            <a href="#"><img class="card-img-top img-fluid" src="images/blood-donor.jpg" alt=""></a>
                            <div class="card-body">
                                <h4 class="card-title"><a href="#"> <?php echo htmlentities($result->FullName); ?> </a></h4>
                                <p><b>Mobile No. / Email:</b> <?php echo htmlentities($result->MobileNumber); ?> / <?php echo htmlentities($result->EmailId ?: 'NA'); ?></p>
                                <p><b>Gender:</b> <?php echo htmlentities($result->Gender); ?></p>
                                <p><b>Age:</b> <?php echo htmlentities($result->Age); ?></p>
                                <p><b>Blood Group:</b> <?php echo htmlentities($result->BloodGroup); ?></p>
                                <p><b>Address:</b> <?php echo htmlentities($result->Address ?: 'NA'); ?></p>
                                <p><b>Message:</b> <?php echo htmlentities($result->Message); ?></p>
                                <p><b>Last Donation Date:</b> <?php echo htmlentities($result->LastDonationDate ?: 'Not Available'); ?></p>
                            </div>
                        </div>
                    </div>
                <?php }} else { echo "<p>No Record Found</p>"; } } ?>
    </div>
</div>
<?php include('includes/footer.php'); ?>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/tether/tether.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>