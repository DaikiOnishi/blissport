<?php get_header(); ?>
<div class="container">
	<div class="contents">
		<div class="layer layer-bg">
			<!--<h1 class="layer-txt">Create a port to share the joy.</h1>-->
		</div>
	</div><!--end contents-->
	<svg viewBox="0 0 800 600">
		<symbol id="s-text">
			<!--<text text-anchor="middle"
				  x="50%"
				  y="35%"
				  class="text--line"
				  >
				Elastic
			</text>-->
			<text text-anchor="middle"
				  x="50%"
				  y="50%"
				  class="text--line2"
				  >
				blissport
			</text>
		</symbol>
		
		<g class="g-ants">
			<use xlink:href="#s-text"
				 class="text-copy"></use>
			<use xlink:href="#s-text"
				 class="text-copy"></use>
			<use xlink:href="#s-text"
				 class="text-copy"></use>
			<use xlink:href="#s-text"
				 class="text-copy"></use>
			<use xlink:href="#s-text"
				 class="text-copy"></use>
		</g>
	</svg>
	<div class="topvector"><img src="<?php echo get_template_directory_uri(); ?>/img/logo/vector.png" alt="ロゴシンボル"></div>
</div><!--end container-->
<?php get_footer(); ?>