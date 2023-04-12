# php-file-upload-script
This is a simple PHP script that allows users to upload files to a web server. It includes security measures such as file type validation, file size restrictions, and user input sanitization to ensure safe file uploads. The allowed file types are PDF, DOC, DOCX, and ODT, with a maximum file size of 4MB.

## Features
Secure file uploads with file type validation and file size restrictions.
User input sanitization to prevent malicious file uploads.
Simple and easy-to-use script that can be integrated into any PHP web application.
PDO (PHP Data Objects) used for database connectivity for improved security and performance.
Optional database storage of uploaded file content and metadata for further processing.
## Requirements
PHP 5.6 or higher (recommended PHP 7.2+)
Web server (such as Apache or Nginx) with PHP support
MySQL or any other compatible database (if you choose to enable database storage)
## Usage
Upload the upload.php file to your web server.
Configure the allowed file types, file size restriction, and database settings (if desired) in the script.
Include the upload.php script in your PHP web application or use it as a standalone script.
Use the provided HTML form or integrate the script with your existing form to allow file uploads from users.
Uploaded files will be validated, sanitized, and stored in the specified directory (with optional database storage) on successful upload.
Display appropriate messages or redirect users based on the upload result.
## License
This PHP file upload script is released under the MIT License, allowing for free usage, modification, distribution, and commercial use. See the LICENSE file for more information.

## Credits
This PHP file upload script was developed by Moataz Elsayed as a simple example and can be used as a starting point for your own file upload implementation.

You can customize the content and formatting of the README file to suit your needs. Include any additional instructions, usage guidelines, or credits as necessary. Remember to update the README file with any changes to the script or its configuration.



