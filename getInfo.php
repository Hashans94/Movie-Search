<?php
// gets value of the passed movie ID
$id = $_GET["id"];
// default page value is false
$valid = false;

// Checks of the passed ID Is null
if($id == null)
{
    // if the ID is null, page gets redirected to index.php
	header('Location: index.php');
}
else{
    // Returns a boolean as page valid    
    $valid = true;

    // Reads and return the json content as a string
    $url = file_get_contents("http://www.omdbapi.com/?i=$id&plot=short&r=json", true);

    // Decodes returned JSON as an array
    $json = json_decode($url,true);
    
    // Gets movie Title from JSON Array
    $movieTitle = $json['Title'];
    
    // Gets movie genre from JSON Array
    $movie_Genre = $json['Genre'];
    
    // Gets movie year from JSON Array
    $movieYear = $json['Year'];
    
    // Gets movie rating from JSON Array
    $movie_Rated = $json['Rated'];
    
    // Gets movie plot from JSON Array
    $moviePlot = $json['Plot'];
    
    // Gets movie poster from JSON Array
    $movie_Poster = $json['Poster'];
    
    // Gets movie Actors from JSON Array
    $movie_actors = $json['Actors'];
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title><?php 
            // Returns Movie title to title tag
            echo $movieTitle;?> | Info
        </title>
        <?php 
        // Package PHP contains style sheets and Javascripts
        include_once("package.php");
        ?>
    </head>

    <body>
        <?php // Checks if the page is Valid, if so content gets displayed
            if($valid == true):?>
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <img class="heroImg" src="<?php 
                                                      // Display Movie Poster
                                                      echo $movie_Poster;
                                                  ?>">
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <h1 class="heroHeader">
                        <?php 
                            // Dispplays Movie Title
                            echo $movieTitle;?>
                        </h1>
                    </div>
                </div>

                <section class="infoContainer">
                    <table>
                        <tr>
                            <th>
                                <p>ID</p>
                            </th>
                            <td>
                                <p>
                                    <!-- Display Movie ID -->
                                    <?php echo $id;?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                               
                                <p>Genre</p>
                            </th>
                            <td>
                                <p>
                                   <!-- Display Movie Genre -->
                                    <?php echo $movie_Genre;?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <p>Year</p>
                            </th>
                            <td>
                                <p>
                                   <!-- Display Movie Year -->
                                    <?php echo $movieYear;?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <p>Rated</p>
                            </th>
                            <td>
                                <p>
                                   <!-- Display Movie Rating -->
                                    <?php echo $movie_Rated;?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <p>Plot</p>
                            </th>
                            <td>
                                <p>
                                   <!-- Display Movie Plot -->
                                    <?php echo $moviePlot;?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th class="lastTD">
                                <p>Actors</p>
                            </th>
                            <td class="lastTD">
                                <p>
                                   <!-- Display Movie Actors -->
                                    <?php echo $movie_actors;?>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-md-12 backButton">
                            <a href="index.php">Back</a>
                        </div>
                    </div>
                </section>

            </div>

            <?php endif;?>
    </body>

    </html>