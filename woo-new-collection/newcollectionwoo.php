<?php
/**
* Plugin Name: Woocommerce Nieuwe collectie metabox
* Plugin URI: https://bkleder.nl
* Description: Woocommerce Nieuwe collectie metabox
* Author: APR Webdesign
* Author URI: https://aprwebdesign.com
* Version: 1.0
*/

function aprwoo_add_meta_box() {
 
add_meta_box(
 
'custom_post_metabox',
 
'Nieuwe collectie?',
 
'aprwoo_display_meta_box',
 
'product',
 
'side',
 
'high'
 
);
 
}
 
add_action( 'add_meta_boxes', 'aprwoo_add_meta_box' );

function aprwoo_display_meta_box( $post ) {
 
wp_nonce_field( plugin_basename(__FILE__), 'aprwoo_nonce_field' );
 


if(get_post_meta( $post->ID, 'product-title', true ) == 'yes'){
	$check =  'selected';
}
else{
	$check =  '';
}
 
$html .= '<select name="product-title">
  <option value="No">No</option>
  <option '.$check.' value="yes">Yes</option>
  
</select>';

$html .= '<hr><label id="product-title" for="product-title">';
 $html .= "Gebruiken in thema: <br /><i> \$woonew = get_post_meta( get_the_ID(), 'product-title', true );
if ( ! empty( \$woonew ) && \$woonew == 'yes' ) {
    echo '&lt;span class='woonew-badge'&gt;Nieuwe Collectie&lt;/span&gt;';
}</i>";
$html .= '</label>';
 
echo $html;
 
}

function aprwoo_save_meta_box_data( $post_id ) {
 
if ( aprwoo_user_can_save( $post_id, 'aprwoo_nonce_field' ) ) {
 
if ( isset( $_POST['product-title'] ) ) {
 
$product_title = stripslashes( strip_tags( $_POST['product-title'] ) );
 
update_post_meta( $post_id, 'product-title', $product_title );
 
}
 
}
 
}
 
add_action( 'save_post', 'aprwoo_save_meta_box_data' );
 
function aprwoo_display_product( $content ) {
 
if ( is_single () ){
 
$html = 'The Product Title is: ' . get_post_meta( get_the_ID(), 'product-title', true );
 
$content .= $html;
 
}
 
return $content;
 
}
 
add_action('the_content', 'aprwoo_display_product');
 
function aprwoo_user_can_save( $post_id, $nonce ) {
 
$is_autosave = wp_is_post_autosave( $post_id );
 
$is_revision = wp_is_post_revision( $post_id );
 
$is_valid_nonce = ( isset( $_POST[ $nonce ] ) && wp_verify_nonce( $_POST [ $nonce ], plugin_basename( __FILE__ ) ) );
 
return ! ( $is_autosave || $is_revision ) && $is_valid_nonce;
 
}

/*
CSS


.woonew-badge{
background:blue;
color:#fff;


font-size:0.7em;
font-weight:bold;
line-height:15px;
-ms-transform: rotate(-20deg); 
-webkit-transform: rotate(-20deg);
transform: rotate(-20deg);

display:block;
height:60px;
width:60px;
border-radius:50%;

box-sizing:border-box;
padding-top:15px;

text-align:center;

position:absolute;
left:-10px;
top:-10px;

}
*/
