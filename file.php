<!DOCTYPE html>
<html>
<body>
    <form action="file.php" method="post" enctype="multipart/form-data">
        Select file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $target_dir = "uploads/";

        // Check if the directory exists, if not, create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir);
        }
        
        // Retrieve the uploaded file's name & concatenate it with the directory
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        
        // Check if the file was moved from its temporary location to the destination on the server.
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "<br>"."<div>"."The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded"."</div>";

            $file = fopen($target_file, "r");
            if ($file) {   
                echo "<ul>";

                $counter = 1;
                // While there still a line (the end of the file (EOF) is not reached yet nor an error occurred)
                while (($line = fgets($file)) !== false) {
                    // Split a sting by delimiter, returns an array
                    $parts = explode(", ", $line);
                    $name = explode(": ", $parts[0])[1];
                    $age = explode(": ", $parts[1])[1];
                    $language = explode(": ", $parts[2])[1];

                    echo "<li>The {$counter}th dev's name is {$name}, he's {$age} years old and likes {$language}.</li>";
                    $counter++;
                }
                echo "</ul>";
                fclose($file);
            } else {
                echo "Error reading file.<br>";
            }
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
    ?>
</body>
</html>
