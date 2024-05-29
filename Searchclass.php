<?php 
class Searchclass
{
	protected $con;

	public function __construct($link)
	{
		$this->con = $link;
	}
	protected function searchKeyword($table, $column, $keyword, $start='', $finish='')
	{
		try
		{
			$sql = "SELECT * FROM $table WHERE $column";
			(!empty($finish))
			?
			$sql.= " LIKE '%$keyword%' LIMIT $start, $finish"
			:
			$sql.= " LIKE '%$keyword%'";
			
			$stmt = $this->con->prepare($sql);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function limitSearch($table, $column, $keyword, $number, $name)
	{
		$finish = $number;
		$page = isset($_GET[$name])?(int)($_GET[$name]):1;
		$start = ($page>1)?($page*$finish)-$finish:0;
		$stmt = 
		[
			1=>Searchclass::searchKeyword($table, $column, $keyword),
			2=>Searchclass::searchKeyword($table, $column, $keyword, $start, $finish)
		];
		return $stmt;
	}
	public function limitSearch__paging($number, $url='', $name='', $total)
	{
		$nopage = isset($_GET[$name])?(int)$_GET[$name]:1;
		$total_page = ceil($total / $number);
		static::Previous($nopage, $url, $name);
		for($page=1; $page<=$total_page; $page++)
		{
			if(($page>=$nopage-2)&&($page<=$nopage+2)||($page==1)||($page==$total_page))
			{
				$class = ($page==$nopage)?'active':'page-item';
				echo '<li class="page-item"><a class="page-link '.$class.'" href="?'.$url.'&'.$name.'='.$page.'">'.$page.'</a></li>';
			}
		}
		static::nextPage($nopage, $url, $name, $total_page);
	}
	public function Previous($nopage, $url, $name)
	{
		echo '<nav aria-label="Page navigation example">
		  <ul class="pagination justify-content-center">';
		  echo ($nopage>1)?'
		    <li class="page-item">
		      <a class="page-link" href="'.$url.'&'.$name.'='.($nopage-1).'" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		       
		      </a>
		    </li>':NULL;
	}
	public function nextPage($nopage, $url, $name, $total_page)
	{
		echo ($nopage>=$total_page)?NULL:'<li class="page-item">
		      <a class="page-link" href="'.$url.'&'.$name.'='.($nopage+1).'" aria-label="Next">
		        <span aria-hidden="true">&raquo;</span>
		      
		      </a>
		    </li>
		  </ul>
		</nav>';
	}


		
}
