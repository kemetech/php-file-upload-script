<?php
session_start();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

/*  
    To prevent duplicated uploads store a value for 
    the uploaded file in the session and use it to
    redirect to success page after successful upload. 
*/

// Check if file has been uploaded before
if(isset($_SESSION['file_uploaded']) && $_SESSION['file_uploaded'] === true){

    // Show a message indicating that the file has already been uploaded
    echo "File has already been uploaded.";
    exit; // Exit the script to prevent further processing

}


// Constants for allowed file extensions, file MIME types, and maximum file size
$max_size = 4 * 1024 * 1024; // 4 MB
$allowed_extensions = array('pdf', 'doc', 'docx', 'odt');
$allowed_mime_types = array('application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.oasis.opendocument.text');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $file_error = $_FILES['file']['error'];
                        
    // Check if the file was uploaded via HTTP POST using is_uploaded_file()
    if ($file_error === UPLOAD_ERR_OK){

        $file_name = basename($_FILES['file']['name']);
        $file_tmp = $_FILES['file']['tmp_name'];
    
        // Check if the file has no errors
        if (is_uploaded_file($file_tmp)){

            // Get file information
            $file_size = $_FILES['file']['size'];
            $file_mime_type = mime_content_type($file_tmp);
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Generate a unique file name to avoid overwriting existing files
            $file_name = uniqid() . '-' . $file_name;

            // Sanitize file name to remove special characters
            $file_name = htmlspecialchars($file_name, ENT_QUOTES, 'UTF-8');


            // Check if the file size is within the allowed limit
            if ($file_size <= $max_size){

                // Check if the file extension is allowed
                if (in_array($file_extension, $allowed_extensions)){

                    // Check if the file MIME type is allowed
                    if (in_array($file_mime_type, $allowed_mime_types)){

                        // Move uploaded file to desired destination
                        $upload_dir = 'uploads/'; // Change this to your desired upload directory
                        $upload_path = __DIR__ . '/' . $upload_dir . $file_name;

                        if(move_uploaded_file($file_tmp, $upload_path)){

                            // Connect to the database using PDO
                            $user = 'root';
                            $pass = '';
                            $dsn = "mysql:host=localhost;dbname=test";
                            $options = [
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_EMULATE_PREPARES => false
                            ];

                            try {

                                $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
                            } catch (PDOException $e) {

                                die("Failed to connect to database: " . $e->getMessage());
                            }

                            // Prepare the SQL statement
                            $query = "INSERT INTO files (file_name, file_type, file_size, file_content) VALUES (?, ?, ?, ?)";
                            $stmt = $dbh->prepare($query);

                            // Set the parameter values
                            $file_type = $_FILES["file"]["type"];

                            // use true instead of FILE_USE_INCLUDE_PATH in restrict mode
                            $file_content = file_get_contents($upload_path);

                            // Bind the parameters
                            $stmt->bindParam(1, $file_name, PDO::PARAM_STR);
                            $stmt->bindParam(2, $file_type, PDO::PARAM_STR);
                            $stmt->bindParam(3, $file_size, PDO::PARAM_INT);
                            $stmt->bindParam(4, $file_content, PDO::PARAM_LOB);

                            // Execute the query
                            if ($stmt->execute()){


                                // Set a session flag to indicate that the file has been uploaded
                                $_SESSION['file_uploaded'] = true;

                                // Redirect to a different page to prevent duplicate uploads on page refresh
                                header("Location: success.php");


                            } else {

                                echo "Error storing file: " . $stmt->errorInfo()[2];

                            }

                            // Close the database connection
                            $stmt = null;
                            $dbh = null;


                        } else {

                            echo "Failed to upload file.";
                        }
                        

                    } else {

                        echo "Error: Invalid file type. Allowed file types are PDF, DOC, DOCX, and ODT.";
                    }

                } else {

                    echo "Error: Invalid file type. Allowed file types are PDF, DOC, DOCX, and ODT.";

                }
            } else {

                echo "Error: File size exceeds the allowed limit of 4 MB.";
            }
        } else {

            echo "Error: Invalid file upload.";

        }
    } else {

        echo "Error: File upload failed" ;
    }

}



