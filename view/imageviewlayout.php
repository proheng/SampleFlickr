<?php
if(!defined('ACCESS_PERMIT')) {
     header('HTTP/1.0 401 Unauthorized');
     die;
} 
ob_clean();
$image   = $data['image'];
$keyword = $data[0]['keyword'];
?>
<!DOCTYPE html>
<html>
	<?php require_once 'partial/_head.php' ?> 
	<body>
		<center>
			<div style="border: 1px solid grey; box-shadow: 10px 10px 20px black; margin:30px;padding:20px;width:1000px;">
				<?php 
					$prev_id = $data['imagePrev']->id();

					if(!empty($prev_id)){
						echo "<a href='/images/$prev_id?keyword=$keyword'>Prev Image</a>";
					}
				?>
				<img style="width:1000px;" src="<?php echo $image->imageUrl()?>" alt="">
				<h1><?php echo $image->name() ?></h1>
				<p><?php echo $image->description() ?></p>

				<?php 
					$next_id = $data['imageNext']->id();

					if(!empty($next_id)){
						echo "<a href='/images/$next_id?keyword=$keyword'>Next Image</a>";
					}
				?>
				
			</div>
			<button onclick="history.go(-1)">Go Back</button>
			<button onclick="window.location='/images?keyword=<?php echo $keyword?>&offset=<?php echo $_COOKIE['offset']?>&limit=<?php echo $_COOKIE['limit']?>'">Home Page</button>
		</center>
	</body>
</html>
<?php ob_flush(); ?>