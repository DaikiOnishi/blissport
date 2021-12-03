<?php
// var_dump($_POST);

define( "FILE_DIR", "img/form/");

// 変数の初期化
$page_flag = 0;
$clean = array();
$error = array();

// サニタイズ
if( !empty($_POST) ) {
	foreach( $_POST as $key => $value ) {
		$clean[$key] = htmlspecialchars( $value,  ENT_QUOTES, 'UTF-8');
	}
}

if( !empty($_POST['btn_confirm']) ) {

$error = validation($clean);

// ファイルのアップロード
	if( !empty($_FILES['attachment_file']['tmp_name']) ) {

		$upload_res = move_uploaded_file( $_FILES['attachment_file']['tmp_name'], FILE_DIR.$_FILES['attachment_file']['name']);

		if( $upload_res !== true ) {
			$error[] = 'ファイルのアップロードに失敗しました。';
		} else {
			$clean['attachment_file'] = $_FILES['attachment_file']['name'];
		}
	}



	if( empty($error) ) {
	$page_flag = 1;
        }

} elseif( !empty($_POST['btn_submit']) ) {

	$page_flag = 2;

	// 変数とタイムゾーンを初期化
	$header = null;
	$body = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	$admin_reply_subject = null;
	$admin_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	//日本語の使用宣言
	mb_language("ja");
	mb_internal_encoding("UTF-8");

        // ヘッダー情報を設定
	$header = "MIME-Version: 1.0\n";
	$header = "Content-Type: multipart/mixed;boundary=\"__BOUNDARY__\"\n";
	$header .= "From: blissport 担当窓口 <info@blissport.co.jp>\n";
	$header .= "Reply-To: blissport 担当窓口 <info@blissport.co.jp>\n";


	// 件名を設定
	$auto_reply_subject = 'お問い合わせありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お問い合わせ頂き誠にありがとうございます。
下記の内容でお問い合わせを受け付けました。\n\n";
	$auto_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	$auto_reply_text .= "氏名：" . $_POST['your_name'] . "\n";
	$auto_reply_text .= "ふりがな：" . $_POST['your_kana'] . "\n";
	$auto_reply_text .= "TEL：" . $_POST['tel'] . "\n";
	$auto_reply_text .= "メールアドレス：" . $_POST['email'] . "\n";
        if( $_POST['gender'] === "male" ) {
		$auto_reply_text .= "性別：男性\n";
	} else {
		$auto_reply_text .= "性別：女性\n";
	}
		if( $_POST['age'] === "1" ){
		$auto_reply_text .= "年齢：10代\n";
	} elseif ( $_POST['age'] === "2" ){
		$auto_reply_text .= "年齢：20代\n";
	} elseif ( $_POST['age'] === "3" ){
		$auto_reply_text .= "年齢：30代\n";
	} elseif ( $_POST['age'] === "4" ){
		$auto_reply_text .= "年齢：40代\n";
	} elseif( $_POST['age'] === "5" ){
		$auto_reply_text .= "年齢：50代&#12316;\n";
	}
		if( $_POST['job'] === "1" ){
		$auto_reply_text .= "ご職業：高校生\n";
	} elseif ( $_POST['job'] === "2" ){
		$auto_reply_text .= "ご職業：専門学生\n";
	} elseif ( $_POST['job'] === "3" ){
		$auto_reply_text .= "ご職業：大学・短大生\n";
	} elseif ( $_POST['job'] === "4" ){
		$auto_reply_text .= "ご職業：社会人\n";
	} elseif( $_POST['job'] === "5" ){
		$auto_reply_text .= "ご職業：フリーランス\n";
	} elseif( $_POST['job'] === "6" ){
		$auto_reply_text .= "ご職業：主婦\n";
	} elseif( $_POST['job'] === "7" ){
		$auto_reply_text .= "ご職業：その他\n";
	}
		if( $_POST['theme'] === "1" ){
		$auto_reply_text .= "内容：サービスについて\n";
	} elseif ( $_POST['theme'] === "2" ){
		$auto_reply_text .= "内容：発送商品について\n";
	} elseif ( $_POST['theme'] === "3" ){
		$auto_reply_text .= "内容：ログイン時のパスワード紛失について\n";
	} elseif ( $_POST['theme'] === "4" ){
		$auto_reply_text .= "内容：退会方法について\n";
	} elseif( $_POST['theme'] === "5" ){
		$auto_reply_text .= "内容：メイクルームへの掲載について\n";
	} elseif( $_POST['theme'] === "6" ){
		$auto_reply_text .= "内容：その他営業関連\n";
	} elseif ( $_POST['theme'] === "7" ){
		$auto_reply_text .= "内容：プレス関連\n";
	} 
	$auto_reply_text .= "お問い合わせ内容：" . nl2br($_POST['contact']) . "\n";
	$auto_reply_text .= "プライバシーポリシーの同意：" . $_POST['agreement'] . "\n";
	$auto_reply_text .= "blissport 担当窓口";

	// テキストメッセージをセット
	$body = "--__BOUNDARY__\n";
	$body .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\n\n";
	$body .= $auto_reply_text . "\n";
	$body .= "--__BOUNDARY__\n";

	// ファイルを添付
	if( !empty($clean['attachment_file']) ) {
		$body .= "Content-Type: application/octet-stream; name=\"{$clean['attachment_file']}\"\n";
		$body .= "Content-Disposition: attachment; filename=\"{$clean['attachment_file']}\"\n";
		$body .= "Content-Transfer-Encoding: base64\n";
		$body .= "\n";
		$body .= chunk_split(base64_encode(file_get_contents(FILE_DIR.$clean['attachment_file'])));
		$body .= "--__BOUNDARY__\n";
	}

	// メール送信
	mb_send_mail( $_POST['email'], $auto_reply_subject, $body, $header);

        // 運営側へ送るメールの件名
	$admin_reply_subject = "お問い合わせを受け付けました";
	
	// 本文を設定
	$admin_reply_text = "下記の内容でお問い合わせがありました。\n\n";
	$admin_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	$admin_reply_text .= "氏名：" . $_POST['your_name'] . "\n";
	$admin_reply_text .= "ふりがな：" . $_POST['your_kana'] . "\n";
	$admin_reply_text .= "TEL：" . $_POST['tel'] . "\n";
	$admin_reply_text .= "メールアドレス：" . $_POST['email'] . "\n\n";
        if( $_POST['gender'] === "male" ) {
		$admin_reply_text .= "性別：男性\n";
	} else {
		$admin_reply_text .= "性別：女性\n";
	}
		if( $_POST['age'] === "1" ){
		$admin_reply_text .= "年齢：10代\n";
	} elseif ( $_POST['age'] === "2" ){
		$admin_reply_text .= "年齢：20代\n";
	} elseif ( $_POST['age'] === "3" ){
		$admin_reply_text .= "年齢：30代\n";
	} elseif ( $_POST['age'] === "4" ){
		$admin_reply_text .= "年齢：40代\n";
	} elseif( $_POST['age'] === "5" ){
		$admin_reply_text .= "年齢：50代&#12316;\n";
	}
		if( $_POST['job'] === "1" ){
		$admin_reply_text .= "ご職業：高校生\n";
	} elseif ( $_POST['job'] === "2" ){
		$admin_reply_text .= "ご職業：専門学生\n";
	} elseif ( $_POST['job'] === "3" ){
		$admin_reply_text .= "ご職業：大学・短大生\n";
	} elseif ( $_POST['job'] === "4" ){
		$admin_reply_text .= "ご職業：社会人\n";
	} elseif( $_POST['job'] === "5" ){
		$admin_reply_text .= "ご職業：フリーランス\n";
	} elseif( $_POST['job'] === "6" ){
		$admin_reply_text .= "ご職業：主婦\n";
	} elseif( $_POST['job'] === "7" ){
		$admin_reply_text .= "ご職業：その他\n";
	}
		if( $_POST['theme'] === "1" ){
		$admin_reply_text .= "内容：サービスについて\n";
	} elseif ( $_POST['theme'] === "2" ){
		$admin_reply_text .= "内容：発送商品について\n";
	} elseif ( $_POST['theme'] === "3" ){
		$admin_reply_text .= "内容：ログイン時のパスワード紛失について\n";
	} elseif ( $_POST['theme'] === "4" ){
		$admin_reply_text .= "内容：退会方法について\n";
	} elseif( $_POST['theme'] === "5" ){
		$admin_reply_text .= "内容：メイクルームへの掲載について\n";
	} elseif( $_POST['theme'] === "6" ){
		$admin_reply_text .= "内容：その他営業関連\n";
	} elseif ( $_POST['theme'] === "7" ){
		$admin_reply_text .= "内容：プレス関連\n";
	} 
	$admin_reply_text .= "お問い合わせ内容：" . nl2br($_POST['contact']) . "\n\n";
	$admin_reply_text .= "プライバシーポリシーの同意：" . $_POST['agreement'] . "\n";

// テキストメッセージをセット
	$body = "--__BOUNDARY__\n";
	$body .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\n\n";
	$body .= $admin_reply_text . "\n";
	$body .= "--__BOUNDARY__\n";

	// ファイルを添付
	if( !empty($clean['attachment_file']) ) {
		$body .= "Content-Type: application/octet-stream; name=\"{$clean['attachment_file']}\"\n";
		$body .= "Content-Disposition: attachment; filename=\"{$clean['attachment_file']}\"\n";
		$body .= "Content-Transfer-Encoding: base64\n";
		$body .= "\n";
		$body .= chunk_split(base64_encode(file_get_contents(FILE_DIR.$clean['attachment_file'])));
		$body .= "--__BOUNDARY__\n";
	}


	// 運営側へメール送信
	mb_send_mail( 'info@blissport.co.jp', $admin_reply_subject, $body, $header);
}

function validation($data) {

	$error = array();

	// 氏名のバリデーション
	if( empty($data['your_name']) ) {
		$error[] = "「氏名」は必ず入力してください。";
	}elseif( 10 < mb_strlen($data['your_name']) ) {
		$error[] = "「氏名」は10文字以内で入力してください。";
	}

	// ふりがなのバリデーション
	if( empty($data['your_kana']) ) {
		$error[] = "「ふりがな」は必ず入力してください。";
	}elseif( 10 < mb_strlen($data['your_kana']) ) {
		$error[] = "「ふりがな」は10文字以内で入力してください。";
	}

	// TELのバリデーション
	if( empty($data['tel']) ) {
		$error[] = "「TEL」は必ず入力してください。";
	}elseif( !preg_match( "/^[0-9]+$/", $data['tel']) ) {
		$error[] = "「TEL」は西暦半角数字ハイフンなしで入力してください。";
	}
       // メールアドレスのバリデーション
	if( empty($data['email']) ) {
		$error[] = "「メールアドレス」は必ず入力してください。";
	}elseif( !preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $data['email']) ) {
	$error[] = "「メールアドレス」は正しい形式で入力してください。";
	}

	// 性別のバリデーション
	if( empty($data['gender']) ) {
		$error[] = "「性別」は必ず入力してください。";
	}elseif( $data['gender'] !== 'male' && $data['gender'] !== 'female' ) {
	$error[] = "「性別」は必ず入力してください。";
	}
	// 年齢のバリデーション
	if( empty($data['age']) ) {
		$error[] = "「年齢」は必ず入力してください。";
	}
		// ご職業のバリデーション
	if( empty($data['job']) ) {
		$error[] = "「ご職業」は必ず入力してください。";
	}
			// 内容のバリデーション
	if( empty($data['theme']) ) {
		$error[] = "「年齢」は必ず入力してください。";
	}
		// プライバシーポリシー同意のバリデーション
	if( empty($data['agreement']) ) {
		$error[] = "プライバシーポリシーをご確認ください。";
	}elseif( (int)$data['agreement'] !== 1 ) {
	$error[] = "プライバシーポリシーをご確認ください。";
	}

	return $error;
}


?>

<!DOCTYPE>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1, user-scalable=no">
 <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Sawarabi+Gothic" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

<!-- SEO -->
<title>お問合せ</title>
<meta name="keywords" content="blissport,ブリスポート,お問合せ,">
<meta name="description" content="お問合せはこちらとなります。必要事項をご確認のうえ入力をお願い致します。">
<meta name="author" content="株式会社blissport">
<link rel="canonical" href="http://blissport.co.jp/">

<link href="http://blissport.co.jp/css/form.css" rel="stylesheet" type="text/css">
<script src="https://ajaxzip3.github.io/ajaxzip3.js"></script>
<script src="https://zipaddr.github.io/bankauto0.js" charset="UTF-8"></script>

<!-- ▼▼▼InstanceEndEditable▼▼▼ -->
 <link href="http://blissport.co.jp/css/reset.css" rel="stylesheet" type="text/css">
 <link href="http://blissport.co.jp/css/basic.css" rel="stylesheet" type="text/css">
 <link href="http://blissport.co.jp/css/comm.css" rel="stylesheet" type="text/css">
 <link href="http://blissport.co.jp/css/top.css" rel="stylesheet" type="text/css">
<link href="http://blissport.co.jp/css/drawer.css" rel="stylesheet" type="text/css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/pagetop.js" type="text/javascript"></script>
<script src="js/sp_hover.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>



<!-- ▼▼▼drawer.css ナビ▼▼▼ -->
 <link rel="stylesheet" href="css/drawer.css" type="text/css">
<!-- ▼▼▼jquery & iScroll▼▼▼ -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script>
<!-- ▼▼▼drawer.js▼▼▼ -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.1.0/js/drawer.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!--<script src="../js/jquery-1.9.1.min.js" type="text/javascript"></script>
　[if lt IE 9]>
  <script src="../js/html5shiv.js"></script>
  <script src="../js/css3-mediaqueries.js"></script>
<![endif]-->
 <script src="../js/jquery.smoothscroll.js" type="text/javascript"></script>
 <script>
 $(function($) {
  $('html').smoothscroll({
        easing :'swing',
        speed :700,
        margintop :10,
        headerfix : $('#header')
    });
});
</script>
<script src="../js/jquery.matchHeight.js" type="text/javascript"></script>


<!-- ▼▼▼コンテンツ▼▼▼ -->
<link href="css/top.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css">
<link rel="apple-touch-icon" href="http://blissport.co.jp/img/logo/bliss_fabicon.jpg">  
<link rel="shortcut icon" href="http://blissport.co.jp/img/logo/bliss_fabicon.jpg"> 
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-107341006-3"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-107341006-3');
</script>
</head>
<body class="drawer drawer--left drawer-close" style="overflow: auto;">
<a name="top" id="top"></a>
     <!-- ■■■■■ スマホメニュー ■■■■■  -->
       <header role="banner">
        <center id="logo">
          <a href="#"><img src="http://blissport.co.jp/img/logo/blissport_logo_oblong.png" alt="blissport" alt="blissport"></a>
        </center>
     <!-- ハンバーガーボタン -->
       <button type="button" class="drawer-toggle drawer-hamburger">
        <span class="sr-only">toggle navigation</span>
        <span class="drawer-hamburger-icon"></span>
       </button>
     <!-- ナビゲーションの中身 -->
       <nav class="drawer-nav" role="navigation">
        <ul class="drawer-menu" style="transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);">
          <li><a href="#point">SERVICE</a></li>
          <li><a href="#service">CONPANY</a></li>
          <li><a href="#info">INFORMATION</a></li>
        </ul>
      </nav>
    </header>
    <!-- ■■■■■ PCメニュー ■■■■■  -->
      <div id="header">
       <div id="headerbox">
        <h1 id="logo"><a href="#"><img src="http://blissport.co.jp/img/logo/blissport_logo_oblong.png" alt="blissport"></a></h1>
        <ul id="dropmenu">
          <li><a href="#point">SERVICE</a></li>
          <li><a href="#service">COMPANY</a></li>
          <li><a href="#info">INFORMATION</a></li>
        </ul>
       </div>
      </div>
  <!-- / #header -->
<form method="post" action="" enctype="multipart/form-data">
<h1 class="comm_title_page">Contact form<br><span style="
    font-size: 13px;
">お問合せ</span></h1>
<div class="formbox">
<?php if( $page_flag === 1 ): ?>
　<div class="ownerinfo">
　　<h2 style="text-align:left;">お問合せ内容確認</h2>
	<div class="element_wrap">
		<label>氏名</label>
		<p><?php echo $_POST['your_name']; ?></p>
	</div>
	<div class="element_wrap">
		<label>ふりがな</label>
		<p><?php echo $_POST['your_kana']; ?></p>
	</div>
	<div class="element_wrap">
		<label>TEL</label>
		<p><?php echo $_POST['tel']; ?></p>
	</div>
	<div class="element_wrap">
		<label>メールアドレス</label>
		<p><?php echo $_POST['email']; ?></p>
	</div>
	<div class="element_wrap">
		<label>性別</label>
		<p><?php if( $_POST['gender'] === "male" ){ echo '男性'; }
		else{ echo '女性'; } ?></p>
	</div>
	<div class="element_wrap">
		<label>年齢</label>
		<p><?php if( $_POST['age'] === "1" ){ echo '10代'; }
		elseif( $_POST['age'] === "2" ){ echo '20代'; }
		elseif( $_POST['age'] === "3" ){ echo '30代'; }
		elseif( $_POST['age'] === "4" ){ echo '40代'; }
		elseif( $_POST['age'] === "5" ){ echo '50代~'; } ?></p>
	</div>
	<div class="element_wrap">
		<label>ご職業</label>
		<p><?php if( $_POST['job'] === "1" ){ echo '高校生'; }
		elseif( $_POST['job'] === "2" ){ echo '専門学生'; }
		elseif( $_POST['job'] === "3" ){ echo '大学・短大生'; }
		elseif( $_POST['job'] === "4" ){ echo '社会人'; }
		elseif( $_POST['job'] === "5" ){ echo 'フリーランス'; }
		elseif( $_POST['job'] === "6" ){ echo '主婦'; }
		elseif( $_POST['job'] === "7" ){ echo 'その他'; } ?></p>
	</div>
	<div class="element_wrap">
		<label>内容</label>
		<p><?php if( $_POST['theme'] === "1" ){ echo 'サービスについて'; }
		elseif( $_POST['theme'] === "2" ){ echo '発送商品について'; }
		elseif( $_POST['theme'] === "3" ){ echo 'ログイン時のパスワード紛失について'; }
		elseif( $_POST['theme'] === "4" ){ echo '退会方法について'; }
		elseif( $_POST['theme'] === "5" ){ echo 'メイクルームへの掲載について'; }
		elseif( $_POST['theme'] === "6" ){ echo 'その他営業関連'; }
		elseif( $_POST['theme'] === "7" ){ echo 'プレス関連'; } ?></p>
	</div>
	<div class="element_wrap">
		<label>お問い合わせ内容</label>
		<p><?php echo nl2br($_POST['contact']); ?></p>
	</div>
	<div class="element_wrap">
		<label>プライバシーポリシーに同意する</label>
		<p><?php if( $_POST['agreement'] === "1" ){ echo '同意する'; }
		else{ echo '同意しない'; } ?></p>
	</div>
 </div>


	<input type="submit" name="btn_back" value="戻る">
	<input type="submit" name="btn_submit" value="送信">
	</div>
	<input type="hidden" name="your_name" value="<?php echo $_POST['your_name']; ?>">
	<input type="hidden" name="your_kana" value="<?php echo $_POST['your_kana']; ?>">
	<input type="hidden" name="tel" value="<?php echo $_POST['tel']; ?>">
	<input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
    <input type="hidden" name="gender" value="<?php echo $_POST['gender']; ?>">
	<input type="hidden" name="contact" value="<?php echo $_POST['contact']; ?>">
	<input type="hidden" name="age" value="<?php echo $_POST['age']; ?>">
	<input type="hidden" name="job" value="<?php echo $_POST['job']; ?>">
	<input type="hidden" name="theme" value="<?php echo $_POST['theme']; ?>">
	<input type="hidden" name="agreement" value="<?php echo $_POST['agreement']; ?>">

</form>


<?php elseif( $page_flag === 2 ): ?>

<p>送信が完了しました。</p><br>
<a href="http://blissport.co.jp/contact.php" class="btn_last">TOPへ戻る</a>


<?php else: ?>

<?php if( !empty($error) ): ?>
	<ul class="error_list">
	<?php foreach( $error as $value ): ?>
		<li><?php echo $value; ?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>

<form method="post" action="" enctype="multipart/form-data">
　<div class="ownerinfo">
　　<h2 style="text-align:left;">お問合せ情報</h2>
	<div class="element_wrap">
		<label>氏名<span class="font_must">&nbsp;※必須</span></label>
		<input type="text" name="your_name" placeholder="○○&nbsp;○○" value="<?php if( !empty($_POST['your_name']) ){ echo $_POST['your_name']; } ?>">
	</div>
	<div class="element_wrap">
		<label>ふりがな<span class="font_must">&nbsp;※必須</span></label>
		<input type="text" name="your_kana" placeholder="まるまる&nbsp;まるまる" value="<?php if( !empty($_POST['your_kana']) ){ echo $_POST['your_kana']; } ?>">
	</div>
	<div class="element_wrap">
		<label>TEL<span class="font_must">&nbsp;※必須&nbsp;ハイフンなし</span></label>
		<input type="text" name="tel" placeholder="000000000" value="<?php if( !empty($_POST['tel']) ){ echo $_POST['tel']; } ?>">
	</div>
	<div class="element_wrap">
		<label>メールアドレス<span class="font_must">&nbsp;※必須</span></label>
		<input type="text" name="email" placeholder="test@blissport.co.jp" value="<?php if( !empty($_POST['email']) ){ echo $_POST['email']; } ?>">
	</div>
	<div class="element_wrap">
		<label>性別<span class="font_must">&nbsp;※必須</span></label>
		<label for="gender_male"><input id="gender_male" type="radio" name="gender" value="male" <?php if( !empty($_POST['gender']) && $_POST['gender'] === "male" ){ echo 'checked'; } ?>>男性</label>
		<label for="gender_female"><input id="gender_female" type="radio" name="gender" value="female" <?php if( !empty($_POST['gender']) && $_POST['gender'] === "female" ){ echo 'checked'; } ?>>女性</label>
	</div>
	<div class="element_wrap">
		<label>年齢<span class="font_must">&nbsp;※必須</span></label><br>
		<select name="age">
			<option value="">選択してください</option>
			<option value="1" <?php if( !empty($_POST['age']) && $_POST['age'] === "1" ){ echo 'selected'; } ?>>10代</option>
			<option value="2" <?php if( !empty($_POST['age']) && $_POST['age'] === "2" ){ echo 'selected'; } ?>>20代</option>
			<option value="3" <?php if( !empty($_POST['age']) && $_POST['age'] === "3" ){ echo 'selected'; } ?>>30代</option>
			<option value="4" <?php if( !empty($_POST['age']) && $_POST['age'] === "4" ){ echo 'selected'; } ?>>40代</option>
			<option value="5" <?php if( !empty($_POST['age']) && $_POST['age'] === "5" ){ echo 'selected'; } ?>>50代~</option>
		</select>
	</div>
	<div class="element_wrap">
		<label>ご職業<span class="font_must">&nbsp;※必須</span></label><br>
		<select name="job">
			<option value="">選択してください</option>
			<option value="1" <?php if( !empty($_POST['job']) && $_POST['job'] === "1" ){ echo 'selected'; } ?>>高校生</option>
			<option value="2" <?php if( !empty($_POST['job']) && $_POST['job'] === "2" ){ echo 'selected'; } ?>>専門学生</option>
			<option value="3" <?php if( !empty($_POST['job']) && $_POST['job'] === "3" ){ echo 'selected'; } ?>>大学・短大生</option>
			<option value="4" <?php if( !empty($_POST['job']) && $_POST['job'] === "4" ){ echo 'selected'; } ?>>社会人</option>
			<option value="5" <?php if( !empty($_POST['job']) && $_POST['job'] === "5" ){ echo 'selected'; } ?>>フリーランス</option>
			<option value="6" <?php if( !empty($_POST['job']) && $_POST['job'] === "6" ){ echo 'selected'; } ?>>主婦</option>
			<option value="7" <?php if( !empty($_POST['job']) && $_POST['job'] === "7" ){ echo 'selected'; } ?>>その他</option>
		</select>
	</div>
	<div class="element_wrap">
		<label>内容<span class="font_must">&nbsp;※必須</span></label><br>
		<select name="theme">
			<option value="">選択してください</option>
			<option value="1" <?php if( !empty($_POST['theme']) && $_POST['theme'] === "1" ){ echo 'selected'; } ?>>サービスについて</option>
			<option value="2" <?php if( !empty($_POST['theme']) && $_POST['theme'] === "2" ){ echo 'selected'; } ?>>発送商品について</option>
			<option value="3" <?php if( !empty($_POST['theme']) && $_POST['theme'] === "3" ){ echo 'selected'; } ?>>ログイン時のパスワード紛失について</option>
			<option value="4" <?php if( !empty($_POST['theme']) && $_POST['theme'] === "4" ){ echo 'selected'; } ?>>退会方法について</option>
			<option value="5" <?php if( !empty($_POST['theme']) && $_POST['theme'] === "5" ){ echo 'selected'; } ?>>メイクルームへの掲載について</option>
			<option value="6" <?php if( !empty($_POST['theme']) && $_POST['theme'] === "6" ){ echo 'selected'; } ?>>その他営業関連</option>
			<option value="7" <?php if( !empty($_POST['theme']) && $_POST['theme'] === "7" ){ echo 'selected'; } ?>>プレス関連</option>
		</select>
	</div>
	<div class="element_wrap">
		<label>お問い合わせ内容</label>
		<textarea name="contact"><?php if( !empty($_POST['contact']) ){ echo $_POST['contact']; } ?></textarea>
	</div>
	<div class="element_wrap">
		<label for="agreement"><input id="agreement" type="checkbox" name="agreement" value="1"><a href="http://blissport.co.jp" target="_blank">プライバシーポリシー</a>に同意する<span class="font_must">&nbsp;※必須</span></label>
	</div>
	
 
　</div>




	<input  type="submit" name="btn_confirm" value="入力内容を確認する">
</div>
</form>
</div>
<?php endif; ?>
</body>

  <div id="footer">
    <div id="navi">
      <div id="f_logo"><span>株式会社blissport</span><a href="#"><img src="http://blissport.co.jp/img/logo/blissport_logo_oblong.png" alt="blissport"></a></div>
    </div><!-- / #navi -->
    <p id="copyright">Copyright&#169;<script type="text/javascript">
    document.write(new Date().getFullYear());
  </script>blissport All Rights Reserved</p>
  </div><!-- / #footer -->
  <p id="page_top" style="display: none;"><a href="#top"><img src="img/	topback.png" alt="TOPへ戻る"></a></p>
  <!-- ドロワーメニューの利用宣言 -->
  <script>
    $(document).ready(function() {
      $('.drawer').drawer();
    });
  </script>
</body><!-- InstanceEnd -->
</html>