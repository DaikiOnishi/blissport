<?php
/*
Template Name: お問い合わせ
*/
?>

<?php get_header(); ?>
<?php if(have_posts()): while(have_posts()):the_post(); ?>
<div class="wrapper">
	<section class="page-head">
		<div class="logo">
			<h2>CONTACT</h2>
			<div class="headvector"><img src="<?php echo get_template_directory_uri(); ?>/img/logo/vector.png" alt="ロゴシンボル"></div>
			<h1><?php the_title(); ?></h1>
		</div>
	</section>
	<main id="contact">
		<section class="page-content">
			<?php the_content(); ?>
		</section>
		<?php endwhile; endif; ?>
	</main>
</div>
<?php get_footer(); ?>