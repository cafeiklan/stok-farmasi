<?php
	if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Error , Contact oetjoe.soerjadi@gmail.com');};
	
	$return = "<script>alert('Password telah diubah. Silahkan login');document.location='logout.php'</script>";
	if($_POST){
		$username = $_SESSION['username'];
		$nama_user = isset($_POST['nama_user']) ? $_POST['nama_user'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		$password2 = isset($_POST['password2']) ? $_POST['password2'] : '';
		
		if($password != $password2){
			$errMsg = 'Kolom password tidak sama. Mohon ulangi';
		}else{
			function rand_string($length) {
				$str="";
				$chars = "subinsblogabcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				$size = strlen($chars);
				for($i = 0;$i < $length;$i++) {
					$str .= $chars[rand(0,$size-1)];
				}
				return $str; 
			}
			$p_salt = rand_string(20); 
			$site_salt="urangciparieuy"; 
			$salted_hash = hash('sha256', $password.$site_salt.$p_salt);
			$asup = $db->prepare("UPDATE far_user set nama_user = ?, password = ?, psalt = ? WHERE username = ?");
			$asup->bindParam(1, $nama_user);
			$asup->bindParam(2, $salted_hash);
			$asup->bindParam(3, $p_salt);
			$asup->bindParam(4, $username);
			if (!$asup->execute()) {
				print_r($asup->errorInfo());
			}else{
			echo $return;
			}
		}
	}
?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-success">
			<div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-key fa-fw"></i>Ganti Password Laboran</h3>
            </div>
			<div class="box-body">
				<?php if(isset($errMsg)){ ?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?php echo $errMsg; ?>
					</div>
				<?php } ?>
				<?php
					$user = $_SESSION['username'];					
					$query=$db->prepare("SELECT id_user, username, nama_user FROM far_user WHERE username = ?");
					$query->execute(array($user));
					$user = $query->fetchAll();
					foreach($user as $user){
				?>
					<form method="post" action="" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label">Username Login</label>
							<div class="col-sm-4">
								<input type="text" name="username" class="form-control" value="<?php echo $_SESSION['username'];?>" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Nama</label>
							<div class="col-sm-4">
								<input type="text" name="nama_user" class="form-control" value="<?php echo $_SESSION['pengguna'];?>" />
								<p class="help-text">Nama lengkap laboran</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Password Baru</label>
							<div class="col-sm-4">
								<input type="password" name="password" class="form-control" required />
								<p class="help-text">Sebaiknya diisi dengan karakter yang mudah diingat tapi susah ditebak. Bingung kan?</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Ulangi Password</label>
							<div class="col-sm-4">
								<input type="password" name="password2" class="form-control" required />
								<p class="help-text">Samakan dengan karakter yang diisi dikolom atas</p>
							</div>
						</div>
						<div class="form-group">
							<label>&nbsp;</label>
							<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Simpan</button>&nbsp;<button type="reset" class="btn btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;Batal</button>
						</div>
					</form>
				<?php
					}
				?>
			</div>
		</div>
	</div>
</div>