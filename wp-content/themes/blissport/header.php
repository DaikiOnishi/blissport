<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 ">
	<title>
		<?php
		global $page, $paged;
		if(is_front_page()) : //トップページ
		bloginfo('name');
		elseif(is_home()) : //ブログページ（ブログサイトの場合はトップページ）
		wp_title('|', true, 'right');
		bloginfo('name');
		elseif(is_single()) : //記事ページ
		wp_title('');
		elseif(is_page()) : //固定ページ
		wp_title('|', true, 'right');
		bloginfo('name');
		elseif(is_author()): //著者ページ
		wp_title('|', true, 'right');
		bloginfo('name');
		elseif(is_archive()) : //アーカイブページ（カテゴリーページなど）
		wp_title('|', true, 'right');
		bloginfo('name');
		elseif(is_search()) : //検索結果ページ
		wp_title('');
		elseif(is_404()): //404ページ
		echo '404|';
		bloginfo('name');
		endif;
		if($paged >= 2 || $page >= 2) : //２ページ目以降の場合
		echo '-' . sprintf('%sページ',
						   max($paged,$page));
		endif;
		?>
	</title>
	<meta name="keywords" content="blissport">
	<meta name="author" content="株式会社blissport">
	<link rel="canonical" href="https://blissport.co.jp/">
	<link rel="shortcut icon" href=<?php echo get_template_directory_uri(); ?>/img/logo/favicon.ico">
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
	<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@500&family=Varela+Round&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<!-- Google Tag Manager -->
	<script>
	(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-TPHKRD2');</script>
	<!-- End Google Tag Manager -->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TPHKRD2"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<header>
	<div class="header-inner">
		<div class="menu-box">
			<a class="menu">
				<span class="menu__line menu__line--top"></span>
				<span class="menu__line menu__line--center"></span>
				<span class="menu__line menu__line--bottom"></span>
			</a>
		</div>
		<nav class="gnav">
			<div class="gnav__wrap">
				<ul class="gnav__menu">
					<a href="https://blissport.co.jp">Top<li class="gnav__menu__item"></li></a>
					<a href="https://blissport.co.jp/company/"><li class="gnav__menu__item">Company</li></a>
					<a href="https://blissport.co.jp/service/"><li class="gnav__menu__item">Service</li></a>
					<!--<li class="gnav__menu__item"><a href="">News</a></li>-->
					<a href="https://blissport.co.jp/contact/"><li class="gnav__menu__item">Contact</li></a>
				</ul>
			</div><!--gnav-wrap-->
		</nav>
		<div class="hero"></div>
	</div><!--end header-inner-->
</header>

<!-- bottom navigation -->
<ul class="bottom-menu">
    <li>
    	<a href="#"><i class="blogicon-home"></i><br><span class="mini-text">ホーム</span></a>
    </li>
    <li class="menu-width-max">
	<!-- ↓↓項目2. おすすめ　すぐ下の"＃"はそのまま -->
        <a href="#"><i class="blogicon-list"></i><br><span class="mini-text">おすすめ</span></a>
        <ul class="menu-second-level">
        	<li><a href="#">タイトル１</a></li>
        	<li><a href="#">タイトル２</a></li>
        	<li><a href="#">タイトル３</a></li>
        	<li><a href="#">タイトル４</a></li>
        	<li><a href="#">タイトル５</a></li>
        </ul>
    </li>
    <li>
    	<a href="#" target="_blank"><i class="blogicon-hatenablog"></i><br><span class="mini-text">読者登録</span></a>
    </li>
    <li>
    	<a href="https://twitter.com/intent/follow?screen_name=自分のツイッターID"><i class="blogicon-twitter"></i><br><span class="mini-text">Follow</span></a>
    </li>
</ul>
<!-- bottom navigation end-->