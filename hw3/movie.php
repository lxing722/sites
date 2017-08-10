<?php
    $movie = $_GET["film"];
    $info = file("moviedb/$movie/info.txt");
    $overview_content = file("moviedb/$movie/overview.txt");
    for($i=0;$i<count($overview_content);$i++)
    {
    	$content_exp=explode(":", $overview_content[$i]);
    	$title[$i] = $content_exp[0];
    	$content[$i] = $content_exp[1];
    }
    if($info[2]>60)
	{
		$rate = "images/freshlarge.png";
	}
	else{
		$rate = "images/rottenlarge.png";
	}
	$review = glob("moviedb/$movie/review*.txt");
	$a = count($review);  
	$b = ($a-$a%2)/2+($a%2);  

    for($i=1;$i<=$a;$i++)
    {
    	if($a>=10 && $i<10)
    	{
    		$content_c = file("moviedb/$movie/review0$i.txt");
    	}
	    else{
	    	$content_c = file("moviedb/$movie/review$i.txt");
	    }
    	$comment[$i] = $content_c[0];
    	$imagetype[$i] = $content_c[1];
    	$name[$i] = $content_c[2];
    	$website[$i] = $content_c[3];
    	if(trim($imagetype[$i]) === "ROTTEN")
    		{$comment_image[$i] = "images/rotten.gif";}
	    else
	    	{$comment_image[$i] = "images/fresh.gif";}
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?=$info[0]?> - Rancid Tomatoes</title>

		<meta charset="utf-8" />
		<link href="movie.css" type="text/css" rel="stylesheet" />
	</head>

	<body>  
		<div id="rancidbanner"><img src="images/rancidbanner.png" alt="Rancid Tomatoes" />
		</div>
        
		<h1><?=$info[0]?> (<?=$info[1]?>)</h1>
		
		<a id="backbutton" href="home.html"><img src="images/goback.png" alt="gobackbutton" /></a>
	    <div id="overall">
		    <div id="right">
                <div id="A">	
			    <img src="moviedb/<?=$movie?>/overview.png" alt="general overview" />
		        </div>
		     
		        <dl>
			      
			        <?php for($i=0;$i<count($overview_content);$i++) { ?>
					<dt><?= $title[$i] ?></dt>
					<dd><?= $content[$i] ?></dd>
					<?php } ?>	 
		        
		        </dl>
              
            </div>
            <div id="left">
		        <div id="C">
		         <img src="<?=$rate?>" alt="Rotten" />
		         <span id="ratenum"><?=$info[2]?>%</span>
		        </div>
		        <div id="D">
		            <?php for($i=1;$i<=$b;$i++) { ?>
						<p class="comment">
							<img src="<?= $comment_image[$i] ?>" alt="<?= $imagetype[$i] ?>" />
							<q><?= $comment[$i] ?></q>
						</p>
						<p class="viewer">
							<img src="images/critic.gif" alt="Critic" />
							<?= $name[$i] ?> <br />
							<?= $website[$i] ?>
						</p>
					<?php } ?>
				</div>
		        <div id="E">
		            <?php for($i=$b+1;$i<=$a;$i++) { ?>
						<p class="comment">
							<img src="<?= $comment_image[$i] ?>" alt="<?= $imagetype[$i] ?>" />
							<q><?= $comment[$i] ?></q>
						</p>
						<p class="viewer">
							<img src="images/critic.gif" alt="Critic" />
							<?= $name[$i] ?> <br />
							<?= $website[$i] ?>
						</p>
					<?php } ?>
		    
                </div>
            </div>
            <div id="footer">
            	<p>(1-<?= $a ?>) of <?= $a ?></p>
            </div>
        </div>
	</body>
</html>