<header>
  	<div class="logo">
  		<h1>Chibrick</h1>
	    <img src="Chib-transformed.png" width="40px" height="40px" />
	</div>
	
	<div class="menu">
	    <ul>
	      	<li><a href="<?php echo $www; ?>">Главная</a></li>
	      	<li><a href="<?php echo $www; ?>/admin.php?act=0">Админ</a><br /></li>
	      	<?php
			if (isset($_SESSION['logon']) && $_SESSION['logon'] == 'Ok'){
			?>	
			<li><a href="<?php echo $www; ?>/adm_login.php?act=2">Выход</a><br /></li>
			<?php
				}
			?>
	    </ul>
	</div>
	<div id="datenow"></div>
</header>