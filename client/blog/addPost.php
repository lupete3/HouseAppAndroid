<?php 
 include("fonctions.php");
	
	$title = $_POST['title'];
	$body = $_POST['body'];
	$category_name = $_POST['category_name'];
	$author = $_POST['author'];
	$recentDate = date('d-m-Y');
	$comment = 0;
	$like = 0;

	$image = $_FILES['image']['name'];
	$imagePath = 'uploads/'.$image;

	$tmp_name = $_FILES['image']['tmp_name'];
	move_uploaded_file($tmp_name, $imagePath);

	$req = addPost($title,$body,$category_name,$image,$author,$recentDate,$comment,$like);

	if ($req == 1){

		echo json_encode('SUCCESS');

	}else if ($req == -1) {

		echo json_encode('ERROR');
	}
		          			
?>