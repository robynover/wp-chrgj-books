<?php
/*
Plugin Name: Post Type for Books
Plugin URI: https://github.com/robynover/wp-chrgj-books
Description: Defines a post type for books on chrgj.org
Version: 1.0
Author: Robyn
Author URI: http://robynoverstreet.com
License: GPL2
*/
//Constants
define('BOOK_URLPATH', trailingslashit( WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) ) );

add_action('init', 'book_register');
 
function book_register() {
 
	$labels = array(
		'name' => _x('Books', 'post type general name'),
		'singular_name' => _x('Book', 'post type singular name'),
		'add_new' => _x('Add New', 'Book'),
		'add_new_item' => __('Add New Book'),
		'edit_item' => __('Edit Book'),
		'new_item' => __('New Book'),
		'view_item' => __('View Book'),
		'search_items' => __('Search Books'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'book'),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 5,
		'show_in_menu' => true,
		//'has_archive' => true,
		'supports' => array('title','editor','thumbnail','category'),
		'taxonomies' => array('category')
	  ); 
	
 
	register_post_type( 'chrgj_book' , $args );
}
/**********************************
3 = Metaboxes
**********************************/
add_action("admin_init", "chrgj_books_mb_create");
add_action('save_post', 'chrgj_books_mb_save');

function chrgj_books_mb_create(){
	add_meta_box('chrgj_books_mb_author', 'Author','book_author','chrgj_book','normal','high');
	add_meta_box('chrgj_books_mb_pubyear', 'Publication Year','book_pubyear','chrgj_book','normal','high');
	add_meta_box( 'chrgj_books_mb_publisher', 'Publisher', 'book_publisher', 'chrgj_book', 'normal', 'high' );
	add_meta_box( 'chrgj_books_mb_url', 'URL', 'book_url', 'chrgj_book', 'normal', 'high' );
}

function chrgj_books_mb_save(){
	global $post;
	update_post_meta($post->ID, 'book_url', $_POST['book_url']);
	//update_post_meta($post->ID, 'journals_description', $_POST['journals_description']);
	update_post_meta($post->ID, 'book_publisher', $_POST['book_publisher']);
	update_post_meta($post->ID, 'book_author', $_POST['book_author']);
	update_post_meta($post->ID, 'book_pubyear', $_POST['book_pubyear']);
}

/****************
URL
****************/
function book_url(){
	global $post;
	$custom = get_post_custom($post->ID);
	$book_url = $custom["book_url"][0];
	?>
	<input type="text" name="book_url" id="book_url" class="text" size="64" tabindex="1" value="<?php echo $book_url; ?>" />
	<p>Provide the link to the book.</p>
<?php
}
/****************
Publisher
****************/
function book_publisher(){
	global $post;
	$custom = get_post_custom($post->ID);
	$book_publisher = $custom["book_publisher"][0];
	?>
	<input type="text" name="book_publisher" id="book_publisher" class="text" size="64" value="<?php echo $book_publisher; ?>" />
	<p>The publisher of the book.</p>
<?php
}
/****************
Author
****************/
function book_author(){
	global $post;
	$custom = get_post_custom($post->ID);
	$book_author = $custom["book_author"][0];
	?>
	
	<input type="text" name="book_author" id="book_author" class="text" size="64" value="<?php echo $book_author; ?>" />
	<p>The author of the book.</p>
<?php
}

/****************
Publication Year
****************/
function book_pubyear(){
	global $post;
	$custom = get_post_custom($post->ID);
	$book_pubyear = $custom["book_pubyear"][0];
	?>
	<input type="text" name="book_pubyear" id="book_pubyear" class="regular-date datepicker" size="4" value="<?php echo $book_pubyear; ?>" />
	<p>The publication year of the book.</p>
<?php
}

//trying to make the editor work right
/*add_filter( 'user_can_richedit', 'enable_rich' );
function enable_rich( $default ) {
    global $post;
    return $default;
}*/





