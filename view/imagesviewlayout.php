<?php
if(!defined('ACCESS_PERMIT')) {
     header('HTTP/1.0 401 Unauthorized');
     die;
} 
ob_clean();
setcookie('offset' , $data['offset']);
setcookie('limit' , $data['limit']);

?>
<!DOCTYPE html>
<html>
	<?php require_once 'partial/_head.php' ?> 
	<body>
		<center>
		<form action="/images" method="GET">
			<label for="keyword">Search Keyword</label>
			<input type = "text" id="keyword" name ="keyword" value="<?php echo $data['keyword'] ?>" />
			<input type = "submit" value = "search" />
			<br/>
			<?php 
				echo "Total:".$data['count'][0].'<br/>';
				$page_no = ceil (($data['offset'] + 1) / $data['limit'] );
				$page = ceil( $data['count'][0] / $data['limit']  );
				if($page_no > 1) echo "<a href='/images?offset=".($data['offset']-$data['limit'])."&limit=".$data['limit']."&keyword=".$data['keyword']."'>PREV</a>";
				echo 'current page:'.$page_no;
				echo '/';
				echo 'total pages:'.$page;
				if($page_no < $page) echo "<a href='/images?offset=".($data['offset']+$data['limit'])."&limit=".$data['limit']."&keyword=".$data['keyword']."'>NEXT</a>";
			?>
		</form>

		<?php 
			foreach ($data['image_list'] as $key => $value) {
				?>
				<div style="border: 1px solid grey; box-shadow: 10px 10px 20px black; margin:30px;padding:20px;width:500px;">
					<img style="width:300px;" src="<?php echo $value->imageUrl()?>" alt="">
					<h1><?php echo $value->name() ?></h1>
					<p><?php echo $value->description() ?></p>
					<?php if(empty($data['keyword'])){?>
						<a href="/images/<?php echo $value->id()?>">View Full Image</a>
					<?php }else{ ?>
						<a href="/images/<?php echo $value->id()?>?keyword=<?php echo $data['keyword']?>">View Full Image</a>
					<?php } ?>
					
					
				</div>
		<?php }?>
		</center>
	</body>
</html>
<?php ob_flush(); ?>