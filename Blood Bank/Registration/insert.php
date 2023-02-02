<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['Name']) && isset($_POST['b_group']) &&
        isset($_POST['aadhar_no']) && isset($_POST['contact']) &&
        isset($_POST['email'])) {
        
        $Name = $_POST['Name'];
        $b_group = $_POST['b_group'];
        $aadhar_no = $_POST['aadhar_no'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        

        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "bloodbank";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM regestrationdetls WHERE email = ? LIMIT 1" ;
            $Insert = "INSERT INTO `regestrationdetls`(`Name`, `b_group`, `aadhar_no`, `contact`, `email`) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sssii",$Name, $b_group, $aadhar_no,$contact, $email);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this aadhar_no number.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>