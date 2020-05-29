<?php

    global $myfilepath ;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    

    $filepropertiesvar  =  $_FILES['fileToUpload'];
    $filenamevar  =  $_FILES['fileToUpload']['name'];
    $filesizevar  =  $_FILES['fileToUpload']['size'];
    $filetypevar  =  $_FILES['fileToUpload']['type'];
    $filetemplocationvar  =  $_FILES["fileToUpload"]["tmp_name"];
    $fileerrorvar  =  $_FILES['fileToUpload']['error'];

    $mytargetlocationvar = 'uploads/' ;
    $target_filename = $mytargetlocationvar . basename($_FILES["fileToUpload"]["name"]);

    ##############################
    $unidqvar = uniqid();
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_filename,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) 
    {
        $check = getimagesize($filetemplocationvar);
        if($check !== false) 
        {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } 
        else 
        {
            echo "File is not an image.";
            $uploadOk = 0;
        }

    }
    // Check if file already exists
    if (file_exists($target_filename)) 
    {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 1000000) 
    {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
    {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) 
    {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file


    } 
    else 
    {
        $nefilename = $mytargetlocationvar.$unidqvar.".".$imageFileType ;
        if (move_uploaded_file($filetemplocationvar, $nefilename )) 
        { 
            $myfilepath = $nefilename;
        } 
        else 
        {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
else
{

}


// $myfilepath =  $target_dir . basename( $_FILES["fileToUpload"]["name"]);


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Image</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="jcroplib/jquery.Jcrop.min.css">
    <link rel="shortcut icon" type="image/png" href="../default/images/logo.png" />
</head>

<body>


    <div class="container-lg pt-5 pb-5">
        <form id="uploadForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">

            <div id="uploadFormLayer">
                <input name="fileToUpload" id="userImage" type="file" class="form-control">
                <p></p>

                <button type="submit" class="btn btn-primary" id="butoncrop">Upload Image</button>

            </div>

        </form>
        
        <div class="pt-3">
            <?php
                if(! empty($myfilepath))
                { 
                ?>
                    <img src="<?php echo $myfilepath ; ?>" alt="" id="imgtgt" srcset="">
                    
                <?php
                }

               
            ?>
            
        </div>

     
            <div class="pt-3">
                <img src="" alt="" id="imgtgt" srcset="">
            </div>
            <div class="pt-3">
                <img src="" alt="" id="imgtgt2" class="img-fluid">
            </div>
            <div class="p-3">
                <button class="btn btn-primary" id="forimage">Save image</button>
                <img src="" alt="" id="imgtgt3" srcset="">

            </div>

           



        

    </div>






    <script src="https://code.jquery.com/jquery-3.5.0.min.js"
        integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <script src="jcroplib/jquery.Jcrop.min.js"></script>
    <script>

        $(document).ready(function () {

      
                

                // Documentation for JCROP: http://deepliquid.com/content/Jcrop_Manual.html

                var size;
                $('#imgtgt').Jcrop({
                    boxWidth: 800,
                    boxHeight: 600,
                    aspectRatio: 7 / 3,

                    onSelect: function (c) {
                        size = { x: c.x, y: c.y, w: c.w, h: c.h };
                        $("#crop").css("visibility", "visible");
                        console.log(c);
                        var sovar = $("#imgtgt").attr('src');

                        $("#imgtgt2").attr('src', 'preve.php?x=' + size.x + '&y=' + size.y + '&w=' + size.w + '&h=' + size.h + '&img=' + sovar);

                    }
                });

                $("#forimage").click(function () {
                    var img = $("#imgtgt").attr('src');

                    $("#imgtgt3").attr('src', 'freesave.php?x=' + size.x + '&y=' + size.y + '&w=' + size.w + '&h=' + size.h + '&img=' + img);
                    location='jcroplib/success.html';
                });



        });
    </script>
</body>

</html>