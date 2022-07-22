<?php
    require_once "config.php";


	function getPost(){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM post ORDER BY id DESC ");
	  $req->execute();

	  return $req;
	}
	function getCategory(){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM category ORDER BY name ");
	  $req->execute();

	  return $req;
	}

	function getPostById($id){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM post WHERE id = ? ");
	  $req->execute(array($id));

	  return $req;
	}

	function getPostSearch($title){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM post WHERE title LIKE '%$title%' ");
	  $req->execute();

	  return $req;
	}

	function getPostByCategory($category_name){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM post WHERE category_name = ? ");
	  $req->execute(array($category_name));

	  return $req;
	}


	function getSelectLike($user_email,$post_id){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT id, COUNT(id) AS totLike FROM post_like WHERE user_email = ? AND post_id = ? ");
	  $req->execute(array($user_email,$post_id));

	  return $req;
	}

	function getCommentNotification($isSeen){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT COUNT(id) AS totCommentNonSeen FROM comment WHERE isSeen = ? ");
	  $req->execute(array($isSeen));

	  return $req;
	}

	function getCommentUnSeenNotification($isSeen){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM comment WHERE isSeen = ? ");
	  $req->execute(array($isSeen));

	  return $req;
	}

	function getUserAfterSignUp($name){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM users WHERE name = ? ");
	  $req->execute(array($name));

	  return $req;
	}

	function userExist($username,$password){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM users WHERE username = ? AND password = ? ");
	  $req->execute(array($username,$password));

	  return $req;
	}

	function categoryExist($name){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM category WHERE name = ? ");
	  $req->execute(array($name));

	  return $req;
	}

	function addUser($name,$username,$password,$phone,$statut){
		$bdd = connect();

		$test = userExist($username,$password);
		$res = $test->fetch(PDO::FETCH_ASSOC);
		if ($res > 0) {
			return -1;
		}else

		$req = $bdd->prepare("INSERT INTO users (name,username,password,phone,status) VALUES (?,?,?,?,?) ");
		$req->execute(array($name,$username,$password,$phone,$statut));

		return 1;
	}


	function addComment($comment,$user_email,$post_id,$curDate){
		$bdd = connect();

		$req = $bdd->prepare("INSERT INTO comment (comment,user_email,post_id,date_comment) VALUES (?,?,?,?) ");
		$req->execute(array($comment,$user_email,$post_id,$curDate));

		return 1;
	}

	function addCategory($name,$current_date){
		$bdd = connect();

		$test = categoryExist($name);
		$res = $test->fetch(PDO::FETCH_ASSOC);
		if ($res > 0) {
			return -1;
		}else

		$req = $bdd->prepare("INSERT INTO category (name,created_date) VALUES (?,?) ");
		$req->execute(array($name,$current_date));

		return 1;
	}

	function addPost($title,$body,$category_name,$image,$author,$recentDate,$comment,$like){
		$bdd = connect();

		$req = $bdd->prepare("INSERT INTO post (title,body,category_name,image,author,post_date,comments,total_like) VALUES (?,?,?,?,?,?,?,?) ");
		$req->execute(array($title,$body,$category_name,$image,$author,$recentDate,$comment,$like));

		return 1;
	}

	function addPostLike($user_email,$post_id,$isLike,$curDate){
		$bdd = connect();

		$req = $bdd->prepare("INSERT INTO post_like (user_email,post_id,isLike,date_like) VALUES (?,?,?,?) ");
		$req->execute(array($user_email,$post_id,$isLike,$curDate));

		return 1;
	}

	function editCategory($name,$current_date,$id){
		$bdd = connect();

		$req = $bdd->prepare("UPDATE category SET name = ?, created_date = ? WHERE id = ? ");
		$req->execute(array($name,$current_date,$id));

		return $req;
	}

	function editSeenCategory($isSeen,$id){
		$bdd = connect();

		$req = $bdd->prepare("UPDATE comment SET isSeen = ? WHERE id = ? ");
		$req->execute(array($isSeen,$id));

		return $req;
	}

	function editPost($title,$body,$category_name,$image,$author,$recentDate,$id){
		$bdd = connect();

		$req = $bdd->prepare("UPDATE post SET title = ?,body = ?,category_name = ?,image = ?,author = ?,post_date = ? WHERE id = ? ");
		$req->execute(array($title,$body,$category_name,$image,$author,$recentDate,$id));

		return $req;
	}

	function editPostTotLike($newTotLike,$id){
		$bdd = connect();

		$req = $bdd->prepare("UPDATE post SET total_like = ? WHERE id = ? ");
		$req->execute(array($newTotLike,$id));

		return $req;
	}

	function deleteCategory($id){
		$bdd = connect();

		$req = $bdd->prepare("DELETE FROM category WHERE id = ? ");
		$req->execute(array($id));

		return $req;
	}

	function deletePost($id){
		$bdd = connect();

		$req = $bdd->prepare("DELETE FROM post WHERE id = ? ");
		$req->execute(array($id));

		return $req;
	}

	function deleteFromPostLike($id){
		$bdd = connect();

		$req = $bdd->prepare("DELETE FROM post_like WHERE id = ? ");
		$req->execute(array($id));

		return $req;
	}
