<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- link rel="shortcut icon" href="../../assets/ico/favicon.ico"-->

    <title>IWTL &middot For Free</title>

    <!-- Bootstrap core CSS -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Theme-->
    <link href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/superhero/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="jumbotron-narrow.css" rel="stylesheet">

	<script>
	function showHiddenAV() {
   	document.getElementById('hiddenResults').style.display = "block";
	document.getElementById('hiddenLink').style.display = "none";
	}
	</script>

        <script>
        function showHiddenBooks() {
        document.getElementById('hiddenResults2').style.display = "block";
        document.getElementById('hiddenLink2').style.display = "none";
        }
        </script>


    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="blog.html">Blog</a></li>
        </ul>
        <h3 class="text-muted">IWTL &middot For Free (Alpha)</h3>
      </div>

      <div class="row">

            <div class="well bs-component">
              <form class="form-horizontal" action="search.php" method="post">
                <fieldset>
                  <div class="form-group">
                    <label for="textArea" class="col-lg-2 control-label">What do you want to learn?</label>
                    <div class="col-lg-10">
                      <textarea class="form-control" rows="1" id="textArea" name="tags"></textarea>
                      <span class="help-block">Enter keywords related to the subject</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="textArea" class="col-lg-2 control-label">How do you want to learn?</label>
                    <div class="col-lg-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="video" id="optionsRadios1" value="video" checked="">
                          Audio and video lectures
                        </label>
                      </div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="book" id="optionsRadios1" value="book" checked="">
                          Books
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </fieldset>
              </form>
          </div>

        <h1>Results</h1>
            <div class="well bs-component">
              <?php
		try{
                $pdo = new PDO('mysql:dbname=xxxx;host=localhost;charset=utf8', 'xxxx', 'xxxx');
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pre_tags = explode(" ",$_POST["tags"]);
		$tags = implode(" +",$pre_tags);
		$include_books = $_POST["book"];
		$include_videos = $_POST["video"];
		if(!is_null($_POST["tags"])){
			if(!is_null($include_videos)){
				$count = 0;
				echo "\n\n<h2>Audio/Video Resources</h2>\n";
                                        $stmt = $pdo->prepare("SELECT * FROM RESOURCES WHERE MATCH(TAGS) AGAINST(:tags IN NATURAL LANGUAGE MODE) AND CONTENT_TYPE LIKE 1;");
                                        $stmt->execute(array(':tags' => $tags));
					$count+=$stmt->rowCount();
					if($count < 5){
                                        	foreach ($stmt as $row)
                                        	{
                                                	echo "<h3>".$row['NAME']."</h3> \n";
                                                	echo "<a target=\"_blank\" href = \"".$row['URL']."\">"."Check it out"."</a>";
                                        	}
					}
					else
					{
						$index = 0;
						foreach($stmt as $row){
							if($index < 5){
								echo "<h3>".$row['NAME']."</h3> \n";
                                                        	echo "<a target=\"_blank\" href = \"".$row['URL']."\">"."Check it out"."</a>";
							}
							if($index == 5){
								echo "<div id=\"hiddenResults\" style=\"display:none;\">\n";
								echo "<h3>".$row['NAME']."</h3> \n";
                                                                echo "<a target=\"_blank\" href = \"".$row['URL']."\">"."Check it out"."</a>";
							}
							if($index > 5){
								 echo "<h3>".$row['NAME']."</h3> \n";
                                                        	 echo "<a target=\"_blank\" href = \"".$row['URL']."\">"."Check it out"."</a>";
							}
							++$index;
						}
						echo "</div>";
						echo "<br><br><a id=\"hiddenLink\" style=\"display:block;\" href=\"javascript:void(0)\" onclick=\"showHiddenAV();\">"."<h4>Didn't find what you wanted? Click to show all matching results!</h4>"."</a>\n\n";
						
					}
					if($count ==0){
					echo "\nOh no! We didn't find any audio or video resources matching your search query! T_T\n";
					}
                        	
			}
			echo "</div>";
			echo "<br><br><div class=\"well bs-component\">";
			if(!is_null($include_books)){
				$count = 0;
				echo "\n\n<h2>Books</h2>\n";
	        	       		$stmt = $pdo->prepare("SELECT * FROM RESOURCES WHERE MATCH(TAGS) AGAINST(:tags IN NATURAL LANGUAGE MODE) AND CONTENT_TYPE LIKE 2;");
               				$stmt->execute(array(':tags' => "%".$tags."%"));
					$count +=$stmt->rowCount();
					if($count < 5){
                                                foreach ($stmt as $row)
                                                {
                                                        echo "<h3>".$row['NAME']."</h3> \n";
                                                        echo "<a target=\"_blank\" href = \"".$row['URL']."\">"."Check it out"."</a>";
                                                }
                                        }
                                        else
                                        {
                                                $index = 0;
                                                foreach($stmt as $row){
                                                        if($index < 5){
                                                                echo "<h3>".$row['NAME']."</h3> \n";
                                                                echo "<a target=\"_blank\" href = \"".$row['URL']."\">"."Check it out"."</a>";
                                                        }
                                                        if($index == 5){
                                                                echo "<div id=\"hiddenResults2\" style=\"display:none;\">\n";
                                                                echo "<h3>".$row['NAME']."</h3> \n";
                                                                echo "<a target=\"_blank\" href = \"".$row['URL']."\">"."Check it out"."</a>";
                                                        }
                                                        if($index > 5){
                                                                 echo "<h3>".$row['NAME']."</h3> \n";
                                                                 echo "<a target=\"_blank\" href = \"".$row['URL']."\">"."Check it out"."</a>";
                                                        }
                                                        ++$index;
                                                }
                                                echo "</div>";
                                                echo "<br><br><a id=\"hiddenLink2\" style=\"display:block;\" href=\"javascript:void(0)\" onclick=\"showHiddenBooks();\">"."<h4>Didn't find what you wanted? Click to show all matching results!</h4>"."</a>\n\n";

                                        }

                                if($count ==0){
                                echo "\nOh no! We didn't find any book resources matching your search query! T_T\n";
                                }

			}
		}
		else
		{
		echo "Try searching with at least one keyword.";
		}
		}
		catch(PDOException $e){
		echo "<p>There was an error! Please try your search again.<p>";
		}
              ?>

            </div>
      </div>
      <div class="footer">
        <p>&copy; IWTL &middot; For Free 2014</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>


