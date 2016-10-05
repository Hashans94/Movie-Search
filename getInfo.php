<?php

$id = $_GET["id"];
$valid = false;

if($id == null)
{
	header('Location: index.php');
}
else{
$valid = true;
$url = file_get_contents("http://www.omdbapi.com/?i=$id&plot=short&r=json", true);
$json = json_decode($url,true);
$movieTitle = $json['Title'];
$movie_Genre = $json['Genre'];
$movieYear = $json['Year'];
$movie_Rated = $json['Rated'];
$moviePlot = $json['Plot'];
$movie_Poster = $json['Poster'];
$movie_actors = $json['Actors'];
}


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title><?php echo $movieTitle;?> | Info</title>
        <?php include_once("package.php");?>
    </head>

    <body>
        <?php if($valid == true):?>
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <img class="heroImg" src="<?php echo " $movie_Poster ";?>">
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <h1 class="heroHeader"><?php echo $movieTitle;?></h1>
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