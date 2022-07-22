<?php 
 include("fonctions.php");
	
	$id = $_POST['id'];
	$title = $_POST['title'];
	$body = $_POST['body'];
	$category_name = $_POST['category_name'];
	$author = $_POST['author'];
	$recentDate = date('d-m-Y');
	

	$image = $_FILES['image']['name'];
	$imagePath = 'uploads/'.$image;

	$tmp_name = $_FILES['image']['tmp_name'];
	move_uploaded_file($tmp_name, $imagePath);

	$req = editPost($title,$body,$category_name,$image,$author,$recentDate,$id);

	if ($req == 1){

		echo json_encode('SUCCESS');

	}else if ($req == -1) {

		echo json_encode('ERROR');
	}
		          			
?>