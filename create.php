<?php
// Include config file
require_once "connect.php";
 
// Define variables and initialize with empty values
$fname = $lname = $cdate = "";
$fname_err = $lname_error = $cdate = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate fname
    $input_name = trim($_POST["fname"]);
    if(empty($input_name)){
        $fname_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $fname_err = "Please enter a valid name.";
    } else{
        $fname = $input_name;
    }
    
    // Validate lname
    $input_name = trim($_POST["lname"]);
    if(empty($input_name)){
        $lname_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lname_err = "Please enter a valid name.";
    } else{
        $lname = $input_name;
    }
    // Validate Date
    $input_cdate = trim($_POST["cdate"]);
    if(empty($input_cdate)){
        $cdate_err = "Please enter the Date of contact.";     
    } else{
        $cdate = $input_cdate;
    }
    
    // Check input errors before inserting in database
    if(empty($fname_err) && empty($lname_err) && empty($cdate_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO clients (fname, lname, cdate) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_fname, $param_lname, $param_date);
            
            // Set parameters
            $param_fname = $fname;
            $param_lname = $lname;
            $param_date = $cdate;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add client record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fname; ?>">
                            <span class="invalid-feedback"><?php echo $fname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lname" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lname; ?>">
                            <span class="invalid-feedback"><?php echo $lname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date of Contact</label>
                            <input type="date" name="cdate" class="form-control <?php echo (!empty($cdate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cdate; ?>">
                            <span class="invalid-feedback"><?php echo $cdate_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>