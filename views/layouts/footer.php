<div class="fooo">
	<div class="fooo_conten-copy">
		<p>
			<script type="text/javascript">
				copyright = new Date();
				update = copyright.getFullYear();
				document.write("Copyright &copy; " + update);
				<?php if (isset($_SESSION["Usuario"])) { ?>
					document.write("  <a href='./'> D & A</a>, <b> v1.0");
				<?php } else { ?>
					document.write("  <a href='./'> D & A,</a>     Designed by <b><a href='https://www.sorian.ml/' target='_blank'>Sorian</a>");
				<?php } ?>
			</script>
		</p>
	</div>
</div>