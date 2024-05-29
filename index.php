<?php 
require_once('Database.php');
require_once('Searchclass.php');
$link = new Database;
$obj = new Searchclass($link->link);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Test Librari</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<form class="d-flex" action="?" method="get">
			<input class="form-control" type="search" name="q" placeholder="Masukan kata kunci">
			<button type="submit" class="btn btn-outline-dark">Cari</button>
		</form>
	</div>
	<?php $keyword = isset($_GET['q'])?$_GET['q']:NULL; ?>
	<div class="container mt-4">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Nama lengkap</th>
					<th>Usia</th>
					<th>Jumlah Anak</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if(!empty($keyword)):
						$d = $obj->limitSearch('janda','nama', $keyword, 10, 'halaman');
						if($d[2]->rowCount()>0)
						{
							while($row=$d[2]->fetch(PDO::FETCH_ASSOC))
							{
				?>
								<tr>
									<td><?=$row['nama']?></td>
									<td><?=$row['usia']?></td>
									<td><?=$row['jumlah_anak']?></td>
									<td><?=$row['status']?></td>
								</tr>
				<?php 
							}
						}else{

							echo '<tr><td colspan="4">Data tidak ditemukan</td></tr>';
						}


				?>



			
		</table>
		<?=$obj->limitSearch__paging(10, "?q=$keyword", 'halaman', $d[1]->rowCount())?>
	<?php endif; ?>

	</div>
</body>
</html>
