<?php 
	require_once 'db.php';

	$db = new Database();
	$connection = $db->openConnection();

	$request = $_SERVER['REQUEST_METHOD'];

	switch ($request) {
		case 'GET':
			if(empty($_GET['id'])){
				get_all_products();
			} else {
				$id = intval($_GET['id']);
				get_product($id);
			}
			break;
		case 'POST':
			insert_product();
			break;
		case 'PUT':
			$id = intval($_GET['id']);
			break;
		case 'DELETE':
			$id = intval($_GET['id']);
			delete_product($id);
			break;
		default:
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}

	function get_all_products(){
		global $connection;

		$query = "SELECT * FROM products";
		$response = array();
		$result = mysqli_query($connection, $query);
		while($row = mysqli_fetch_assoc($result)){
			$response[] = $row;
		}
		header("Content-Type: application/json");
		echo json_encode($response);
	}

	function get_product($id = 0){
		global $connection;

		$query = "SELECTR * FROM products";
		if($id != 0) {
			$query .= " WHERE products_id=".$id." LIMIT 1";
		}
		$response = array();
		$result = mysqli_query($connection, $query);
    	while($row = mysqli_fetch_assoc($result)){
        	$response[] = $row;
    	}
	    header("Content-Type: application/json");
	    echo json_encode($response);
	}

	function insert_product(){
		global $connection;
		$data = json_decode(file_get_contents("php://input"), true);

		$product_title = $data["title"];
		$product_item_number = $data["item_number"];
		$product_price = $data["price"];
		$product_stock = $data["stock"];

		$query = "INSERT INTO products (title, item_number, price, stock) VALUES ('".$product_title."'. '".$product_item_number."', '".$product_price."', '".$product_stock."')";
		if(mslqi_query($connection, $query)) {
			$response = array(
				"status" => 1,
				"message" => "Sikeres adatfelvétel"
			);
		} else {
			$response = array(
				"status" => 0,
				"message" => "Sikertelen adatfelvétel"
			);
		}
		header("Connect-Type: application/json");
		echo json_encode($response);
	}

	function update_product($id){
		global $connection;

		$data = json_decode(file_get_contents("php://input"), true);

		$product_title = $data["title"];
		$product_item_number = $data["item_number"];
		$product_price = $data["price"];
		$product_stock = $data["stock"];

		$query = "UPDATE products SET title = '".$product_title."',item_number = '".$product_item_number."', price = '".$product_price."', stock = '".$product_stock."' WHERE id = ".$id;
	    if(mysqli_query($connection, $query)){
	        $response = array(
	            "status" => 1,
	            "message" => "Sikeres adatmódosítás"
	        );
	    }else{
	        $response = array(
	            "status" => 0,
	            "message" => "Sikertelen adatmódosítás"
	        );
	    }
	    header("Content-Type: application/json");
	    echo json_encode($response);
	}

	function delete_product($id){
		 global $connection;

	    $query = "DELETE FROM products WHERE id=".$id;

	    if(mysqli_query($connection, $query)){
	        $response = array(
	            "status" => "1",
	            "message" => "Sikeres törlés"
	        );
	    }else{
	        $response = array(
	            "status" => "0",
	            "message" => "Sikertelen törlés"
	        );
	    }
	    header("Content-Type: application/json");
	    echo json_encode($response);
	}

 ?>