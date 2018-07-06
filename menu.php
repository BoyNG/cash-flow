    <div class="cashflow-top">
		<div id="Logo" style="position:absolute;left:5px;top:16px;z-index:149;">
			<img src="img/logo.png" id="Image1" alt="logo" >
		</div>
		<nav>
		<div class="cashflow-top-text">
<?php 
				$page = "main";
				if (isset($_GET['page']))
				{
				    $page = $_GET['page'];  
				}
?>
		<?= "<a href='//".$_SERVER['SERVER_NAME']."'>".$_SERVER['SERVER_NAME']."</a>" ?>
		<a class="is<?= $page=='market'; ?>" href="market">маркетинг</a>
		<a class="is<?= $page=='faq'; ?>" href="faq">вопросы</a>
		<a class="is<?= $page=='rule'; ?>" href="rule">правила</a>
		<a class="is<?= $page=='cont'; ?>" href="cont">контакты</a>
		<a class="is<?= $page=='webinar'; ?>" href="webinar">вебинар</a>
		<span class="right">
	<?php 
	if(empty($_SESSION['login'])) 
		{ 
		echo "<a class='is".($page=='sign')."' href='sign'>Вход</a>";
		} else { 
				echo "<a class='is".($page=='cabinet')."' href='cabinet'>Кабинет";
				?>
				<div class="avatar-mini" style="background: no-repeat center url('/avatars/<?php echo $_SESSION['login'].".jpg?qwe=".time(); ?>'), url('/avatars/empty.jpg'); background-size: cover ;"></div></a>
				<?php
				} 
		?>
        </span>
		</div>
		</nav>
		<div class="cashflow-top-line"></div>
	    <div class="clr"></div>
    </div>
	