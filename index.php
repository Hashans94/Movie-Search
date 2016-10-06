<?php

$valid = false;
$error = "";	

if(isset($_POST["submit"])){
    
    // Retrieves the typed search string
    $name = $_POST["search"];
    
    // checks the search value is empty
    if(empty($name))
    {
        // if search value is null, user gets an error message
        $error = "A Search Term Is Required In order To Conduct A Search, Please Enter A Search Term";
    }
    else{
        
        // replaces search string spaces with '%20' character
        // This is done to avoid errors
        $nameString = str_replace(" ", "%20", $name);
        
        // Checks if there is a blank space character at the end of the string
        // if there is that blankspace character gets removed
        // else the normal value gets assigned to $nameVariable
        if(substr($nameString,-3) == "%20"){
          
          $name = chop($nameString, substr($nameString,-3)); 
          //Removes the whitespace character and assign the to $name Variable
        }
        else
        {
           $name = $nameString; // Value of nameString gets assigned to name variable
        }
        
        //echo '<h1>Replaced String: '.$nameString.'</h1>';
        //echo '<h1>Chopped: '.$name.'</h1>';
        
        // Reads and return the json content as a string
        $url = file_get_contents("http://www.omdbapi.com/?s=$name&y=&plot=short&r=json", true);
        
        // Decodes a json string and returns the json array
        $json = json_decode($url);
        
        // This is to check json error messages
        $jsonError = json_decode($url,true);
        
        // Check if json returns an error response
        if($jsonError['Response'] == "False"){
            
            // Checks the type of error according to error message
            if($jsonError['Error'] == "Movie not found!")
            {
                // Returns and Error Message to user
                $error = "Searched Movie Not Found!";
            }
            else
            {
                 // Returns and Error Message to user
                $error = "Please Enter A valid Search Term";
            }
        }
        // If json response doesnt retun an error, returned array gets sorted alphabatically
        // $valid returns a boolean value to show page is valid
        else
        {
            sort($json->Search);
            $valid = true;
        }

    }
}
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset "UTF-8"/>
        <title>Movie Search</title>
        <?php include_once("package.php");?>
    </head>

    <body>
        <div class="container">
            <div class="jumbotron">
                <h1><i class="fa fa-search" aria-hidden="true">&nbsp;</i>Movie Search</h1>
                <form name="movieSearch" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                    <label id="errorMessage" class="errMsg">
                        <?php echo "$error"; // Displays the respective error message to user?>
                    </label>
                    <input id="search" type="text" name="search" placeholder="Search..." onkeydown="testUp();" />
                    <input id="submitButton" type="submit" name="submit" value="submit">
                </form>
            </div>
        </div>

        <?php if($valid == true): // check if the search is term is true?>
            <div class="container">
                <div class="tbl-header">
                    <table>
                        <thead>
                            <tr>
                                <th>IMDB ID</th>
                                <th>Title</th>
                                <th>Genre</th>
                                <th>Year Released</th>
                                <th>Poster</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div class="tbl-content">
                    <table>
                        <tbody>

                            <?php foreach ($json->Search as $movie): // Loops through returned json array to extract values?>
                                <tr>
                                    <td class="imdbID">
                                        <?php
                                            // Display movie ID with a link to movie hero page
                                            echo "<a href=\"getinfo.php?id=$movie->imdbID\">$movie->imdbID</a>";
                                        ?></td>
                                    <td>
                                        <?php 
                                            // Display Movie Title
                                            echo $movie->Title; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            // Display Type of the movie2
                                            echo $movie->Type; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            // Display Year of the Movie
                                            echo $movie->Year; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            // Display Movie Poster
                                            echo "<img src=\"$movie->Poster\"";
                                        ?>
                                    </td>
                                </tr>

                                <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif;?>
    </body>

    </html>