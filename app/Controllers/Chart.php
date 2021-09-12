<?php 

namespace App\Controllers;
 
use CodeIgniter\Controller;
 
class Chart extends Controller
{
 
	public function __construct()
	{
		helper(['html','url']);
	}
		
	public function index() {
		$db = \Config\Database::connect();
		$builder = $db->table('products');

		$query = $builder->select("COUNT(id) as count, sales, DAYNAME(created_at) as day");
		$query = $builder->where("DAY(created_at) GROUP BY DAYNAME(created_at), sales")->get();
		$record = $query->getResult();

		$productData = [];

		foreach($record as $row) {
			$productData[] = array(
				'day'   => $row->day,
				'sell' => floatval($row->sales)
			);
		}

		$data['productData'] = ($productData);    
		return view('index', $data);     
	}
 
}

?>