<?php
/********************************************************************************/
/* ヘッダーの追加設定 */
/********************************************************************************/
function ad_custom_head() {
	if ( !is_admin() ) {
		$ret  = "";

		$ret .= "\n";
		$ret .= "<meta http-equiv='X-Frame-Options' content='SAMEORIGIN'>" . "\n";
		$ret .= "<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>" . "\n";
//		$ret .= "<!--[if lt IE 7]>" . "\n";
//		$ret .= "<script type='text/javascript' src='";
//		$ret .= get_bloginfo("url");
//		$ret .= "/wp-content/js-custom/IE7.js'></script>" . "\n";
//		$ret .= "<script type='text/javascript' src='";
//		$ret .= get_bloginfo("url");
//		$ret .= "/wp-content/js-custom/ie7-squish.js'></script>" . "\n";
//		$ret .= "<script type='text/javascript' src='";
//		$ret .= get_bloginfo("url");
//		$ret .= "/wp-content/js-custom/minmax.js'></script>" . "\n";
//		$ret .= "<![endif]-->" . "\n";
		$ret .= "<!--[if lt IE 10]>" . "\n";
		$ret .= "<script type='text/javascript' src='";
		$ret .= get_bloginfo("url");
		$ret .= "/wp-content/js-custom/enhance.js'></script>" . "\n";
		$ret .= "<script type='text/javascript'>" . "\n";
		$ret .= "enhance({" . "\n";
		$ret .= "loadScripts: [{src: '";
		$ret .= get_bloginfo("url");
		$ret .= "/wp-content/js-custom/excanvas.js'";
		$ret .= ", iecondition: 'all'}]" . "\n";
		$ret .= "})" . "\n";
		$ret .= "</script>" . "\n";
		$ret .= "<![endif]-->";

		echo $ret, PHP_EOL;
	}
}

add_action( 'wp_head', 'ad_custom_head' );


/********************************************************************************/
/* editor-style */
/********************************************************************************/
/*add_editor_style();*/


/********************************************************************************/
/* attachment_id=ページに404を返す */
/********************************************************************************/
function gs_attachment_template_redirect() {
	if ( is_attachment() ) { // 添付ファイルの個別ページなら
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
	}
}

add_action( 'template_redirect', 'gs_attachment_template_redirect' );


/********************************************************************************/
/* ダッシュボードウィジェットを管理者以外には非表示 */
/********************************************************************************/
if ( !current_user_can( 'edit_users' ) ) {
	function remove_dashboard_widgets() {
		global $wp_meta_boxes;
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );	// 最近のコメント
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );		// 被リンク
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );			// プラグイン
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );			// クイック投稿
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );		// 最近の下書き
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );				// WordPressブログ
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );			// WordPressフォーラム
	}

	add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );
}


/********************************************************************************/
/* 投稿／ページ画面に Custom CSS File メタボックスを追加 */
/********************************************************************************/
function custom_css_file_hooks() {
	add_meta_box( 'custom_css_file', 'Custom CSS File', 'custom_css_file_input', 'post', 'normal', 'high' );
	add_meta_box( 'custom_css_file', 'Custom CSS File', 'custom_css_file_input', 'page', 'normal', 'high' );
}

function custom_css_file_input() {
	global $post;
	echo '<input type="hidden" name="custom_css_file_noncename" id="custom_css_file_noncename" value="' . wp_create_nonce( 'custom-css-file' ) . '" />';
	echo '<textarea name="custom_css_file" id="custom_css_file" rows="5" cols="30" style="width:100%;">' . get_post_meta( $post->ID, '_custom_css_file', true ) . '</textarea>';
}

function save_custom_css_file( $post_id ) {
	if ( !wp_verify_nonce( $_POST['custom_css_file_noncename'], 'custom-css-file' ) ) return $post_id;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;
	$custom_css = $_POST['custom_css_file'];
	update_post_meta( $post_id, '_custom_css_file', $custom_css );
}

function insert_custom_css_file() {
	if ( is_page() || is_single() ) {
		if ( have_posts() ) : while ( have_posts() ) : the_post();
			$content = get_post_meta( get_the_ID(), '_custom_css_file', true );
			if ( $content != '' ) {
				echo "<link type='text/css' href='" . $content . "' rel='stylesheet' media='all' />", PHP_EOL;
			}
		endwhile; endif;
		rewind_posts();
	}
}

add_action( 'admin_menu', 'custom_css_file_hooks' );
add_action( 'save_post', 'save_custom_css_file' );
add_action( 'wp_head','insert_custom_css_file' );


/* 管理者以外には表示しない */
if ( !current_user_can( 'edit_users' ) ) {
	function remove_custom_css_file_metaboxes() {
		remove_meta_box( 'custom_css_file' , 'post' , 'normal' );
		remove_meta_box( 'custom_css_file' , 'page' , 'normal' );
	}
	add_action( 'admin_menu' , 'remove_custom_css_file_metaboxes' );
}


/********************************************************************************/
/* 投稿／ページ画面に Custom CSS メタボックスを追加 */
/********************************************************************************/
function custom_css_hooks() {
	add_meta_box( 'custom_css', 'Custom CSS', 'custom_css_input', 'post', 'normal', 'high' );
	add_meta_box( 'custom_css', 'Custom CSS', 'custom_css_input', 'page', 'normal', 'high' );
}

function custom_css_input() {
	global $post;
	echo '<input type="hidden" name="custom_css_noncename" id="custom_css_noncename" value="' . wp_create_nonce( 'custom-css' ) . '" />';
	echo '<textarea name="custom_css" id="custom_css" rows="5" cols="30" style="width:100%;">' . get_post_meta( $post->ID, '_custom_css', true ) . '</textarea>';
}

function save_custom_css( $post_id ) {
	if ( !wp_verify_nonce( $_POST['custom_css_noncename'], 'custom-css' ) ) return $post_id;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;
	$custom_css = $_POST['custom_css'];
	update_post_meta( $post_id, '_custom_css', $custom_css );
}

function insert_custom_css() {
	if ( is_page() || is_single() ) {
		if ( have_posts() ) : while ( have_posts() ) : the_post();
			$content = get_post_meta( get_the_ID(), '_custom_css', true );
			if ( $content != '' ) {
				echo "<style type='text/css'>" . $content . "</style>", PHP_EOL;
			}
		endwhile; endif;
		rewind_posts();
	}
}

add_action( 'admin_menu', 'custom_css_hooks' );
add_action( 'save_post', 'save_custom_css' );
add_action( 'wp_head', 'insert_custom_css' );


/* 管理者以外には表示しない */
if ( !current_user_can( 'edit_users' ) ) {
	function remove_custom_css_metaboxes() {
		remove_meta_box( 'custom_css' , 'post' , 'normal' );
		remove_meta_box( 'custom_css' , 'page' , 'normal' );
	}
	add_action( 'admin_menu' , 'remove_custom_css_metaboxes' );
}


/********************************************************************************/
/* 投稿／ページ画面に Custom JS File メタボックスを追加 */
/********************************************************************************/
function custom_js_file_hooks() {
	add_meta_box( 'custom_js_file', 'Custom JS File', 'custom_js_file_input', 'post', 'normal', 'high' );
	add_meta_box( 'custom_js_file', 'Custom JS File', 'custom_js_file_input', 'page', 'normal', 'high' );
}

function custom_js_file_input() {
	global $post;
	echo '<input type="hidden" name="custom_js_file_noncename" id="custom_js_file_noncename" value="' . wp_create_nonce( 'custom-js-file' ) . '" />';
	echo '<textarea name="custom_js_file" id="custom_js_file" rows="5" cols="30" style="width:100%;">' . get_post_meta( $post->ID, '_custom_js_file', true ) . '</textarea>';
}

function save_custom_js_file( $post_id ) {
	if ( !wp_verify_nonce( $_POST['custom_js_file_noncename'], 'custom-js-file' ) ) return $post_id;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;
	$custom_js = $_POST['custom_js_file'];
	update_post_meta( $post_id, '_custom_js_file', $custom_js );
}

function insert_custom_js_file() {
	if ( is_page() || is_single() ) {
		if ( have_posts() ) : while ( have_posts() ) : the_post();
			$content = get_post_meta( get_the_ID(), '_custom_js_file', true );
			if ( $content != '' ) {
				echo "<script type='text/javascript' src='" . $content . "'></script>", PHP_EOL;
			}
		endwhile; endif;
		rewind_posts();
	}
}

add_action( 'admin_menu', 'custom_js_file_hooks' );
add_action( 'save_post', 'save_custom_js_file' );
add_action( 'wp_head', 'insert_custom_js_file' );


/* 管理者以外には表示しない */
if ( !current_user_can( 'edit_users' ) ) {
	function remove_custom_js_file_metaboxes() {
		remove_meta_box( 'custom_js_file' , 'post' , 'normal' );
		remove_meta_box( 'custom_js_file' , 'page' , 'normal' );
	}

	add_action( 'admin_menu' , 'remove_custom_js_file_metaboxes' );
}


/********************************************************************************/
/* 投稿／ページ画面に Custom JS メタボックスを追加 */
/********************************************************************************/
function custom_js_hooks() {
	add_meta_box( 'custom_js', 'Custom JS', 'custom_js_input', 'post', 'normal', 'high' );
	add_meta_box( 'custom_js', 'Custom JS', 'custom_js_input', 'page', 'normal', 'high' );
}

function custom_js_input() {
	global $post;
	echo '<input type="hidden" name="custom_js_noncename" id="custom_js_noncename" value="' . wp_create_nonce( 'custom-js' ) . '" />';
	echo '<textarea name="custom_js" id="custom_js" rows="5" cols="30" style="width:100%;">' . get_post_meta( $post->ID, '_custom_js', true ) . '</textarea>';
}

function save_custom_js( $post_id ) {
	if ( !wp_verify_nonce( $_POST['custom_js_noncename'], 'custom-js' ) ) return $post_id;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
	$custom_js = $_POST['custom_js'];
	update_post_meta( $post_id, '_custom_js', $custom_js );
}

function insert_custom_js() {
	if ( is_page() || is_single() ) {
		if ( have_posts() ) : while ( have_posts() ) : the_post();
			$content = get_post_meta( get_the_ID(), '_custom_js', true );
			if ( $content != '' ) {
				echo "<script type='text/javascript'>" . $content . "</script>", PHP_EOL;
			}
		endwhile; endif;
		rewind_posts();
	}
}

add_action( 'admin_menu', 'custom_js_hooks' );
add_action( 'save_post', 'save_custom_js' );
add_action( 'wp_head', 'insert_custom_js' );


/* 管理者以外には表示しない */
if ( !current_user_can( 'edit_users' ) ) {
	function remove_custom_js_metaboxes() {
		remove_meta_box( 'custom_js' , 'post' , 'normal' );
		remove_meta_box( 'custom_js' , 'page' , 'normal' );
	}
	add_action( 'admin_menu' , 'remove_custom_js_metaboxes' );
}
