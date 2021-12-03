<?php
function my_scripts() {
	wp_enqueue_style( 'top', get_template_directory_uri() . '/css/top.css', array(), 'all' );
	wp_enqueue_style( 'page', get_template_directory_uri() . '/css/page.css', array(), 'all' );
	wp_enqueue_style( 'service', get_template_directory_uri() . '/css/service.css', array(), 'all' );
	wp_enqueue_style( 'company', get_template_directory_uri() . '/css/company.css', array(), 'all' );
	wp_enqueue_style( 'oldtop', get_template_directory_uri() . '/css/oldtop.css', array(), 'all' );
	wp_enqueue_style( 'menu', get_template_directory_uri() . '/css/menu.css', array(), 'all' );
	wp_enqueue_style( 'footer', get_template_directory_uri() . '/css/footer.css', array(), 'all' );
	wp_enqueue_style( 'contact', get_template_directory_uri() . '/css/contact.css', array(), 'all' );
	wp_enqueue_style( 'reset', get_template_directory_uri() . '/css/reset.css', array(), 'all' );
	/*wp_enqueue_style( 'sp-menu', get_template_directory_uri() . '/css/sp-menu.css', array(), 'all' );*/
	wp_enqueue_style( 'title', get_template_directory_uri() . '/css/title.css', array(), 'all' );
	wp_enqueue_style( 'menu-sp', get_template_directory_uri() . '/css/menu-sp.css', array(), 'all' );
	wp_enqueue_script( 'sp-menu', get_template_directory_uri() . '/js/sp-menu.js', array( 'jquery' ), true );
	wp_enqueue_script( 'menu-sp', get_template_directory_uri() . '/js/menu-sp.js', array( 'jquery' ), true );
	wp_enqueue_script( 'menu', get_template_directory_uri() . '/js/menu.js', array( 'jquery' ), true );
}
add_action( 'wp_enqueue_scripts', 'my_scripts' );

/**
 * WP-SCSS：ページをロードするたびにscssファイルを強制的にコンパイル.
 */
define( 'WP_SCSS_ALWAYS_RECOMPILE', true );

//テーマのセットアップ
// HTML5でマークアップさせる
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
// Feedのリンクを自動で生成する
add_theme_support( 'automatic-feed-links' );
//アイキャッチ画像を使用する設定
add_theme_support( 'post-thumbnails' );

//コンタクトフォーム７読み込み制限 
/*function wpcf7_file_load() {
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
if( is_page( 'otoiawase' ) ){
if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
wpcf7_enqueue_scripts();
}
if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
wpcf7_enqueue_styles();
}
}
}
add_action( 'template_redirect', 'wpcf7_file_load' );*/

?>