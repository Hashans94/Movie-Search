<?php

$valid = false;
$error = "";	

if(isset($_POST["submit"])){
$name = $_POST["search"];

	if(empty($name))
	{
		$error = "A Search Term Is Required In order To Conduct A Search, Please Enter A Search Term";
	}
    else{
		$url = file_get_contents("http://www.omdbapi.com/?s=$name&y=&plot=short&r=json", true);
		$json = json_decode($url);
		$jsonError = json_decode($url,true);
		

		if($jsonError['Response'] == "False"){

			if($jsonError['Error'] == "Movie not found!")
			{
				$error = "Searched Movie Not Found!";
			}
			else
			{
				$error = "Please Enter A valid Search Term";
			}
		}
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
                        <?php echo "$error";?>
                    </label>
                    <input id="search" type="text" name="search" placeholder="Search..." onkeydown="testUp();" />
                    <input id="submitButton" type="submit" name="submit" value="submit">
                </form>
            </div>
        </div>

        <?php if($valid == true):?>
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

                            <?php foreach ($json->Search as $movie):?>
                                <tr>
                                    <td class="imdbID">
                                        <?php echo "<a href=\"getinfo.php?id=$movie->imdbID\">$movie->imdbID</a>";?></td>
                                    <td>
                                        <?php echo $movie->Title; ?>
                                    </td>
                                    <td>
                                        <?php echo $movie->Type; ?>
                                    </td>
                                    <td>
                                        <?php echo $movie->Year; ?>
                                    </td>
                                    <td>
                                        <?php echo "<img src=\"$movie->Poster\"";?></td>
                                </tr>

                                <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif;?>
    </body>

    </html>