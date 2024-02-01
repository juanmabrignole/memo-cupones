<?php
require (dirname(__FILE__) .'/vendor/autoload.php');


add_filter('pre_get_posts','lw_search_filter_pages');
function lw_search_filter_pages($query) {
    if ( ! is_admin() && $query->is_search() ) {
        $query->set('post_type', 'product');
        $query->set( 'wc_query', 'product_query' );
    }
    return $query;
}

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */


 function mychildtheme_enqueue_styles() {
     $parent_style = 'parent-style';
 
     wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
     wp_enqueue_style( 'child-style',
         get_stylesheet_directory_uri() . '/style.css',
         array( $parent_style )
     );
 }
 add_action( 'wp_enqueue_scripts', 'mychildtheme_enqueue_styles' );
 
 /*******
 /**	Remove comments in total
 *******/
 
 /* Disable the Gutenberg editor. */
 add_filter('use_block_editor_for_post', '__return_false');
 
 /*
 // Disable support for comments and trackbacks in post types
 function df_disable_comments_post_types_support() {
     $post_types = get_post_types();
     foreach ($post_types as $post_type) {
         if(post_type_supports($post_type, 'comments')) {
             remove_post_type_support($post_type, 'comments');
             remove_post_type_support($post_type, 'trackbacks');
         }
     }
 }
 
 add_action('admin_init', 'df_disable_comments_post_types_support');
 
 // Close comments on the front-end
 function df_disable_comments_status() {
     return false;
 }
 add_filter('comments_open', 'df_disable_comments_status', 20, 2);
 add_filter('pings_open', 'df_disable_comments_status', 20, 2);
 
 // Hide existing comments
 function df_disable_comments_hide_existing_comments($comments) {
     $comments = array();
     return $comments;
 }
 add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);
 
 // Remove comments page in menu
 function df_disable_comments_admin_menu() {
     remove_menu_page('edit-comments.php');
 }
 add_action('admin_menu', 'df_disable_comments_admin_menu');
 
 // Redirect any user trying to access comments page
 function df_disable_comments_admin_menu_redirect() {
     global $pagenow;
     if ($pagenow === 'edit-comments.php') {
         wp_redirect(admin_url()); exit;
     }
 }
 add_action('admin_init', 'df_disable_comments_admin_menu_redirect');
 
 // Remove comments metabox from dashboard
 function df_disable_comments_dashboard() {
     remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 }
 add_action('admin_init', 'df_disable_comments_dashboard');
 
 // Remove comments links from admin bar
 function df_disable_comments_admin_bar() {
     if (is_admin_bar_showing()) {
         remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
     }
 }
 add_action('init', 'df_disable_comments_admin_bar');
 */
 
 /*** Soporte para CPT */
//  add_action( 'init', function () {
//      add_ux_builder_post_type( 'custom_post_type' );
//  } );
  
 
 /*** Login Customization ***/
 function custon_login_logo() { ?>
     <style type="text/css">
     body.login  {
         background: #faf7ee;
     }
     #login h1 a,
     .login h1 a {
         background-image: url('https://memorable.com.ar/wp-content/uploads/2019/04/Memorable_Logo.png');
         background-size: contain;
         background-repeat: no-repeat;
         padding-bottom: 0px;
         margin-bottom: 0px;
         width: 250px;    
     }
     .login #wp-submit.button {
         height: 30px;
         line-height: 28px;
         background-color: #753532;
         padding: 0 12px 2px;
         border-color: #753532;
         box-shadow: none;
         text-shadow: none;
         text-transform: uppercase;
     }
     </style>
     <?php }
     add_action( 'login_enqueue_scripts', 'custon_login_logo' );
     
     function custom_login_logo_url() {
         return home_url();
     }
     add_filter( 'login_headerurl', 'custom_login_logo_url' );
     
     function custom_login_logo_url_title() {
         return 'Memorable';
     }
     add_filter( 'login_headertext', 'custom_login_logo_url_title' );
     
     /*** End Login Customization ***/
 
     add_shortcode('whatsapp_floating', 'add_whatsapp_icon');
 
     function add_whatsapp_icon($atts = array()) {
 
         // set up default parameters
         extract(shortcode_atts(array(
             'phone' => ''
         ), $atts));
 
         echo '<a href="https://wa.me/' . $phone . '" target="_blank" class="btn-telefono-home">
             <img src="' . esc_url( get_stylesheet_directory_uri() ) . '/img/whatsapp.svg">
         </a>';
     }
 
 
     add_filter( 'woocommerce_bacs_account_fields', 'change_labels_account_fields', 10, 2 );
 
     function change_labels_account_fields($args, $order_id) {
         if($args) {
             $args['iban']['label'] = 'CBU';
             $args['bic']['label'] = 'Alias';
         }
 
         return $args;
     }
 
     function add_theme_scripts() {
 
         wp_enqueue_style( 'scss-styles', get_stylesheet_directory_uri() . '/assets/css/style.min.css', array(), '1.1.1.9', 'all');
 
     }
     add_action( 'wp_enqueue_scripts', 'add_theme_scripts', 1 );
 
     function enqueue_js() {
 
     wp_register_script('custom-js', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.3', true); // Custom scripts
     wp_register_script('parallax-js', get_stylesheet_directory_uri() . '/assets/js/parallax.min.js', array('jquery'), '1.0.2', true);
     wp_enqueue_script('custom-js'); // Enqueue it!
     wp_enqueue_script('parallax-js'); // Enqueue it!
 
     }
     add_action( 'init', 'enqueue_js' );
 
 /*
     $account_fields = apply_filters(
         'woocommerce_bacs_account_fields',
         array(
             'bank_name'      => array(
                 'label' => __( 'Bank', 'woocommerce' ),
                 'value' => $bacs_account->bank_name,
             ),
             'account_number' => array(
                 'label' => __( 'Account number', 'woocommerce' ),
                 'value' => $bacs_account->account_number,
             ),
             'sort_code'      => array(
                 'label' => $sortcode,
                 'value' => $bacs_account->sort_code,
             ),
             'iban'           => array(
                 'label' => __( 'IBAN', 'woocommerce' ),
                 'value' => $bacs_account->iban,
             ),
             'bic'            => array(
                 'label' => __( 'BIC', 'woocommerce' ),
                 'value' => $bacs_account->bic,
             ),
         ),
         $order_id
     );*/
 
 
     // To change add to cart text on single product page
 add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
 function woocommerce_custom_single_add_to_cart_text() {
     return __( 'Agregar al pedido', 'woocommerce' ); 
 }
 
 // To change add to cart text on product archives(Collection) page
 add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
 function woocommerce_custom_product_add_to_cart_text() {
     return __( 'Agregar al pedido', 'woocommerce' );
 }
 
 if( function_exists('acf_add_options_page') ) {
     
     acf_add_options_page(array(
         'page_title' 	=> 'Slides',
         'menu_title'	=> 'Slides',
         'menu_slug' 	=> 'theme-general-settings',
         'capability'	=> 'edit_posts',
         'redirect'		=> false
     ));
     
 }
 
 if( function_exists('acf_add_options_page') ) {
     
     acf_add_options_page(array(
         'page_title' 	=> 'Banners tienda',
         'menu_title'	=> 'Banners tienda',
         'menu_slug' 	=> 'banners-general-settings',
         'capability'	=> 'edit_posts',
         'redirect'		=> false
     ));
     
 }
 
 if( function_exists('acf_add_options_page') ) {
     
     acf_add_options_page(array(
         'page_title' 	=> 'Menu QR',
         'menu_title'	=> 'Menu QR',
         'menu_slug' 	=> 'menu-general-settings',
         'capability'	=> 'edit_posts',
         'redirect'		=> false
     ));
     
 }
 
 /*  ADD CUSTOM FIELD CAJA TO ORDER */
 
 
  // Display custom field on single product page
     function caja_extra_product_field(){
         $value = '';
         printf( '<label>%s</label><input type="hidden" name="caja_product_field" value="%s" />', __( '' ), esc_attr( $value ) );
     }
     add_action( 'woocommerce_before_add_to_cart_button', 'caja_extra_product_field', 9 );
 
     // validate when add to cart
     function d_extra_field_validation($passed, $product_id, $qty){
             if(get_field('habilitar_selector', $product_id)){
                 if( isset( $_POST['caja_product_field'] ) && sanitize_text_field( $_POST['caja_product_field'] ) == '' ){
                     $product = wc_get_product( $product_id );
                     wc_add_notice( sprintf( __( 'Selecciona los sabores de tu %s para continuar.' ), $product->get_title() ), 'error' );
                     return false;
                 }
             }
         
 
         return $passed;
 
     }
     add_filter( 'woocommerce_add_to_cart_validation', 'd_extra_field_validation', 10, 3 );
 
      // add custom field data in to cart
     function d_add_cart_item_data( $cart_item, $product_id ){
 
         if( isset( $_POST['caja_product_field'] ) ) {
             $cart_item['caja_product_field'] = $_POST['caja_product_field'];
         }
 
         return $cart_item;
 
     }
     add_filter( 'woocommerce_add_cart_item_data', 'd_add_cart_item_data', 10, 2 );
 
     // load data from session
     function d_get_cart_data_f_session( $cart_item, $values ) {
 
         if ( isset( $values['caja_product_field'] ) ){
             $cart_item['caja_product_field'] = $values['caja_product_field'];
         }
 
         return $cart_item;
 
     }
     add_filter( 'woocommerce_get_cart_item_from_session', 'd_get_cart_data_f_session', 20, 2 );
 
 
     //add meta to order
     function d_add_order_meta( $item_id, $values ) {
 
         if ( ! empty( $values['caja_product_field'] ) ) {
             woocommerce_add_order_item_meta( $item_id, 'Sabores seleccionados ', $values['caja_product_field'] );           
         }
     }
     add_action( 'woocommerce_add_order_item_meta', 'd_add_order_meta', 10, 2 );
 
     // display data in cart
     function d_get_itemdata( $other_data, $cart_item ) {
 
         if ( isset( $cart_item['caja_product_field'] ) ){
 
             /*$other_data[] = array(
                 'name' => __( 'Sabores seleccionados ' ),
                 'value' => sanitize_text_field( $cart_item['caja_product_field'] )
             );*/
 
         }
 
         return $other_data;
 
     }
     add_filter( 'woocommerce_get_item_data', 'd_get_itemdata', 10, 2 );
 
     // display custom field data in order view
     function d_dis_metadata_order( $cart_item, $order_item ){
 
         if( isset( $order_item['caja_product_field'] ) ){
             $cart_item_meta['caja_product_field'] = $order_item['caja_product_field'];
         }
 
         return $cart_item;
 
     }
     add_filter( 'woocommerce_order_item_product', 'd_dis_metadata_order', 10, 2 );
 
 
     // add field data in email
     function d_order_email_data( $fields ) { 
         $fields['caja_product_field'] = __( 'Sabores seleccionados ' ); 
         return $fields; 
     } 
     add_filter('woocommerce_email_order_meta_fields', 'd_order_email_data');
 
     // again order
     function d_order_again_meta_data( $cart_item, $order_item, $order ){
 
         if( isset( $order_item['caja_product_field'] ) ){
             $cart_item_meta['caja_product_field'] = $order_item['caja_product_field'];
         }
 
         return $cart_item;
 
     }
     add_filter( 'woocommerce_order_again_cart_item_data', 'd_order_again_meta_data', 10, 3 );
 
 
 // Prepara scripts de cupones de descuento para la Landing Page por QR
 
 function cupones_js() {
 
         wp_register_script('cupones-js', get_stylesheet_directory_uri() . '/assets/js/cupones.js', array('jquery'), '1.0.4', true); // Custom scripts
         wp_localize_script( 'cupones-js', 'params', array(
             'url'    => admin_url( 'admin-ajax.php' ),
             'nonce'  => wp_create_nonce( 'cupones-nonce' ),
             'action' => 'crear-cupon'
         ) );      
         wp_enqueue_script('cupones-js'); // Enqueue it
 
 }
 
 add_action( 'init', 'cupones_js' );
 
 add_action( 'wp_ajax_nopriv_crear-cupon', 'solicitudDeCupon' );
 add_action( 'wp_ajax_crear-cupon', 'solicitudDeCupon' );


 

 function mem_cupon_shortcode() {

    $cupon = isset($_GET['cupon']) ? sanitize_text_field($_GET['cupon']) : '';
    return $cupon;
}
add_shortcode('mem_cupon_shortcode', 'mem_cupon_shortcode');


 // Funcion que crea cupones de descuento para la Landing Page por QR
 function solicitudDeCupon(){

     //Check for nonce security
     $nonce = sanitize_text_field( $_POST['nonce'] );
     $name = $_POST['nombre'];
     $email = $_POST['email'];
     $donde = $_POST['donde'];
     $cliente = $_POST['cliente'];
     $edad = $_POST['edad'];
     $provincia = $_POST['provincia'];
     $newsletter = $_POST['newsletter'];
     $cupon = false;
 
     if ( ! wp_verify_nonce( $nonce, 'cupones-nonce' ) ) {
         die ( 'Hubo un error..');
     }
    // echo json_encode($res);

    $subscribersApi = (new MailerLiteApi\MailerLite('d8c793bc983a4484d78098edc11e5ef5'))->subscribers();
    // $res = 'ok API - subscribersApi';
    // echo json_encode($res);

     $subscriber = $subscribersApi->find($email); // returns object of subscriber by its email
 
    if(isset($subscriber->id)){
 
         $groupsApi = (new MailerLiteApi\MailerLite('d8c793bc983a4484d78098edc11e5ef5'))->groups();
 
         $groupId = 106149961;
         $subscriberId = $subscriber->id;
         $groupSubscribers = $groupsApi->getSubscriber($groupId, $subscriberId);
 
         if(isset($subscriberGroups->error)){ // Si el usuario no existe en la lista, procedemos
                 //Add suscriber to mailerlite
                 if($newsletter == 'true'){
 
                     suscribirMailerLite($name, $email, $donde, $cliente, $edad, $provincia, 106149961);
 
                 }
 
                 $cupon = createCoupon($email);
 
         }
 
    }else{ // Si el usuario no existe en MailerLite, procedemos
 
         //Add suscriber to mailerlite 
         if($newsletter == 'true'){
 
             suscribirMailerLite($name, $email, $donde, $cliente, $edad, $provincia, 106149961);
 
         }
 
         $cupon = createCoupon($email);
 
    }
 
    // Si se creo el cupón, enviamos un mail
     if($cupon){
         sendCouponEmail($name, $email, $cupon);
     }
 
     $return_arr = array(
         "cupon" => $cupon,
         "nombre" => $name,
         "email" => $email,
         "donde" => $donde,
         "cliente" => $cliente,
         "edad" => $edad
     );
 
     echo json_encode($return_arr);
 
 }
 
 function random_strings($length_of_string) 
 { 
   
     // String of all alphanumeric character 
     $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
   
     // Shufle the $str_result and returns substring 
     // of specified length 
     return substr(str_shuffle($str_result), 0, $length_of_string); 
 } 
 
 function createCoupon($email){
     $random = random_strings(6);
     $coupon_code = 'MEMO' . $random; // Code
     $amount = '10'; // Amount
     $discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product
 
     $coupon = array(
     'post_title' => $coupon_code,
     'post_content' => '',
     'post_excerpt' => $email,
     'post_status' => 'publish',
     'post_author' => 1,
     'post_type' => 'shop_coupon');
 
     $new_coupon_id = wp_insert_post( $coupon );
 
     // Add meta
     update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
     update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
     update_post_meta( $new_coupon_id, 'individual_use', 'yes' );
     update_post_meta( $new_coupon_id, 'description', 'no' );
     update_post_meta( $new_coupon_id, 'product_ids', '' );
     update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
     update_post_meta( $new_coupon_id, 'usage_limit', '1' );
     update_post_meta( $new_coupon_id, 'expiry_date', '30 days' );
     update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
     //update_post_meta( $new_coupon_id, 'free_shipping', 'yes' );
     update_post_meta( $new_coupon_id, 'minimum_amount', '10000' );
 
     return $coupon_code;
 }
 
 function suscribirMailerLite($name, $email, $donde, $cliente, $edad, $provincia, $grupo){
         $groupsApi = (new MailerLiteApi\MailerLite("d8c793bc983a4484d78098edc11e5ef5"))->groups();
         $groups = $groupsApi->get();
         $subscriber = [
             'email' => $email,
             'fields' => [
                 'name' => $name,
                 'como_nos_conocio' => $donde,
                 'es_cliente' => $cliente,
                 'rango_de_edad' => $edad,
                 'provincia' => $provincia
             ]
         ];
 
         $response = $groupsApi->addSubscriber($grupo, $subscriber); 
 }
 
 function sendCouponEmail($name, $email, $coupon){
     add_filter( 'wp_mail_content_type', 'set_html_mail_content_type' );
 
     $subject = 'Has recibido un cupón de descuento | Memorable';
     $body = '<!doctype html>
 <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
     <head>
         <!-- NAME: Cupones QR -->
         <!--[if gte mso 15]>
         <xml>
             <o:OfficeDocumentSettings>
             <o:AllowPNG/>
             <o:PixelsPerInch>96</o:PixelsPerInch>
             </o:OfficeDocumentSettings>
         </xml>
         <![endif]-->
         <meta charset="UTF-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <title>*|MC:SUBJECT|*</title>
         
     <style type="text/css">
         p{
             margin:10px 0;
             padding:0;
         }
         table{
             border-collapse:collapse;
         }
         h1,h2,h3,h4,h5,h6{
             display:block;
             margin:0;
             padding:0;
         }
         img,a img{
             border:0;
             height:auto;
             outline:none;
             text-decoration:none;
         }
         body,#bodyTable,#bodyCell{
             height:100%;
             margin:0;
             padding:0;
             width:100%;
         }
         .mcnPreviewText{
             display:none !important;
         }
         #outlook a{
             padding:0;
         }
         img{
             -ms-interpolation-mode:bicubic;
         }
         table{
             mso-table-lspace:0pt;
             mso-table-rspace:0pt;
         }
         .ReadMsgBody{
             width:100%;
         }
         .ExternalClass{
             width:100%;
         }
         p,a,li,td,blockquote{
             mso-line-height-rule:exactly;
         }
         a[href^=tel],a[href^=sms]{
             color:inherit;
             cursor:default;
             text-decoration:none;
         }
         p,a,li,td,body,table,blockquote{
             -ms-text-size-adjust:100%;
             -webkit-text-size-adjust:100%;
         }
         .ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
             line-height:100%;
         }
         a[x-apple-data-detectors]{
             color:inherit !important;
             text-decoration:none !important;
             font-size:inherit !important;
             font-family:inherit !important;
             font-weight:inherit !important;
             line-height:inherit !important;
         }
         .templateContainer{
             max-width:600px !important;
         }
         a.mcnButton{
             display:block;
         }
         .mcnImage,.mcnRetinaImage{
             vertical-align:bottom;
         }
         .mcnTextContent{
             word-break:break-word;
         }
         .mcnTextContent img{
             height:auto !important;
         }
         .mcnDividerBlock{
             table-layout:fixed !important;
         }
     /*
     @tab Page
     @section Heading 1
     @style heading 1
     */
         h1{
             /*@editable*/color:#222222;
             /*@editable*/font-family:Helvetica;
             /*@editable*/font-size:40px;
             /*@editable*/font-style:normal;
             /*@editable*/font-weight:bold;
             /*@editable*/line-height:150%;
             /*@editable*/letter-spacing:normal;
             /*@editable*/text-align:center;
         }
     /*
     @tab Page
     @section Heading 2
     @style heading 2
     */
         h2{
             /*@editable*/color:#222222;
             /*@editable*/font-family:Helvetica;
             /*@editable*/font-size:34px;
             /*@editable*/font-style:normal;
             /*@editable*/font-weight:bold;
             /*@editable*/line-height:150%;
             /*@editable*/letter-spacing:normal;
             /*@editable*/text-align:left;
         }
     /*
     @tab Page
     @section Heading 3
     @style heading 3
     */
         h3{
             /*@editable*/color:#444444;
             /*@editable*/font-family:Helvetica;
             /*@editable*/font-size:22px;
             /*@editable*/font-style:normal;
             /*@editable*/font-weight:bold;
             /*@editable*/line-height:150%;
             /*@editable*/letter-spacing:normal;
             /*@editable*/text-align:left;
         }
     /*
     @tab Page
     @section Heading 4
     @style heading 4
     */
         h4{
             /*@editable*/color:#949494;
             /*@editable*/font-family:Georgia;
             /*@editable*/font-size:20px;
             /*@editable*/font-style:italic;
             /*@editable*/font-weight:normal;
             /*@editable*/line-height:125%;
             /*@editable*/letter-spacing:normal;
             /*@editable*/text-align:left;
         }
     /*
     @tab Header
     @section Header Container Style
     */
         #templateHeader{
             /*@editable*/background-color:#ededd8;
             /*@editable*/background-image:none;
             /*@editable*/background-repeat:no-repeat;
             /*@editable*/background-position:center;
             /*@editable*/background-size:cover;
             /*@editable*/border-top:0;
             /*@editable*/border-bottom:0;
             /*@editable*/padding-top:45px;
             /*@editable*/padding-bottom:45px;
         }
     /*
     @tab Header
     @section Header Interior Style
     */
         .headerContainer{
             /*@editable*/background-color:transparent;
             /*@editable*/background-image:none;
             /*@editable*/background-repeat:no-repeat;
             /*@editable*/background-position:center;
             /*@editable*/background-size:cover;
             /*@editable*/border-top:0;
             /*@editable*/border-bottom:0;
             /*@editable*/padding-top:0;
             /*@editable*/padding-bottom:0;
         }
     /*
     @tab Header
     @section Header Text
     */
         .headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
             /*@editable*/color:#757575;
             /*@editable*/font-family:Helvetica;
             /*@editable*/font-size:16px;
             /*@editable*/line-height:150%;
             /*@editable*/text-align:left;
         }
     /*
     @tab Header
     @section Header Link
     */
         .headerContainer .mcnTextContent a,.headerContainer .mcnTextContent p a{
             /*@editable*/color:#007C89;
             /*@editable*/font-weight:normal;
             /*@editable*/text-decoration:underline;
         }
     /*
     @tab Body
     @section Body Container Style
     */
         #templateBody{
             /*@editable*/background-color:#FFFFFF;
             /*@editable*/background-image:none;
             /*@editable*/background-repeat:no-repeat;
             /*@editable*/background-position:center;
             /*@editable*/background-size:cover;
             /*@editable*/border-top:0;
             /*@editable*/border-bottom:0;
             /*@editable*/padding-top:36px;
             /*@editable*/padding-bottom:45px;
         }
     /*
     @tab Body
     @section Body Interior Style
     */
         .bodyContainer{
             /*@editable*/background-color:transparent;
             /*@editable*/background-image:none;
             /*@editable*/background-repeat:no-repeat;
             /*@editable*/background-position:center;
             /*@editable*/background-size:cover;
             /*@editable*/border-top:0;
             /*@editable*/border-bottom:0;
             /*@editable*/padding-top:0;
             /*@editable*/padding-bottom:0;
         }
     /*
     @tab Body
     @section Body Text
     */
         .bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
             /*@editable*/color:#757575;
             /*@editable*/font-family:Helvetica;
             /*@editable*/font-size:16px;
             /*@editable*/line-height:150%;
             /*@editable*/text-align:left;
         }
     /*
     @tab Body
     @section Body Link
     */
         .bodyContainer .mcnTextContent a,.bodyContainer .mcnTextContent p a{
             /*@editable*/color:#007C89;
             /*@editable*/font-weight:normal;
             /*@editable*/text-decoration:underline;
         }
     /*
     @tab Footer
     @section Footer Style
     */
         #templateFooter{
             /*@editable*/background-color:#ffffff;
             /*@editable*/background-image:none;
             /*@editable*/background-repeat:no-repeat;
             /*@editable*/background-position:center;
             /*@editable*/background-size:cover;
             /*@editable*/border-top:0;
             /*@editable*/border-bottom:0;
             /*@editable*/padding-top:45px;
             /*@editable*/padding-bottom:63px;
         }
     /*
     @tab Footer
     @section Footer Interior Style
     */
         .footerContainer{
             /*@editable*/background-color:transparent;
             /*@editable*/background-image:none;
             /*@editable*/background-repeat:no-repeat;
             /*@editable*/background-position:center;
             /*@editable*/background-size:cover;
             /*@editable*/border-top:0;
             /*@editable*/border-bottom:0;
             /*@editable*/padding-top:0;
             /*@editable*/padding-bottom:0;
         }
     /*
     @tab Footer
     @section Footer Text
     */
         .footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
             /*@editable*/color:#FFFFFF;
             /*@editable*/font-family:Helvetica;
             /*@editable*/font-size:12px;
             /*@editable*/line-height:150%;
             /*@editable*/text-align:center;
         }
     /*
     @tab Footer
     @section Footer Link
     */
         .footerContainer .mcnTextContent a,.footerContainer .mcnTextContent p a{
             /*@editable*/color:#FFFFFF;
             /*@editable*/font-weight:normal;
             /*@editable*/text-decoration:underline;
         }
     @media only screen and (min-width:768px){
         .templateContainer{
             width:600px !important;
         }
 
 }	@media only screen and (max-width: 480px){
         body,table,td,p,a,li,blockquote{
             -webkit-text-size-adjust:none !important;
         }
 
 }	@media only screen and (max-width: 480px){
         body{
             width:100% !important;
             min-width:100% !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcnRetinaImage{
             max-width:100% !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcnImage{
             width:100% !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
             max-width:100% !important;
             width:100% !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcnBoxedTextContentContainer{
             min-width:100% !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcnImageGroupContent{
             padding:9px !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
             padding-top:9px !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
             padding-top:18px !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcnImageCardBottomImageContent{
             padding-bottom:9px !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcnImageGroupBlockInner{
             padding-top:0 !important;
             padding-bottom:0 !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcnImageGroupBlockOuter{
             padding-top:9px !important;
             padding-bottom:9px !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcnTextContent,.mcnBoxedTextContentColumn{
             padding-right:18px !important;
             padding-left:18px !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
             padding-right:18px !important;
             padding-bottom:0 !important;
             padding-left:18px !important;
         }
 
 }	@media only screen and (max-width: 480px){
         .mcpreview-image-uploader{
             display:none !important;
             width:100% !important;
         }
 
 }	@media only screen and (max-width: 480px){
     /*
     @tab Mobile Styles
     @section Heading 1
     @tip Make the first-level headings larger in size for better readability on small screens.
     */
         h1{
             /*@editable*/font-size:30px !important;
             /*@editable*/line-height:125% !important;
         }
 
 }	@media only screen and (max-width: 480px){
     /*
     @tab Mobile Styles
     @section Heading 2
     @tip Make the second-level headings larger in size for better readability on small screens.
     */
         h2{
             /*@editable*/font-size:26px !important;
             /*@editable*/line-height:125% !important;
         }
 
 }	@media only screen and (max-width: 480px){
     /*
     @tab Mobile Styles
     @section Heading 3
     @tip Make the third-level headings larger in size for better readability on small screens.
     */
         h3{
             /*@editable*/font-size:20px !important;
             /*@editable*/line-height:150% !important;
         }
 
 }	@media only screen and (max-width: 480px){
     /*
     @tab Mobile Styles
     @section Heading 4
     @tip Make the fourth-level headings larger in size for better readability on small screens.
     */
         h4{
             /*@editable*/font-size:18px !important;
             /*@editable*/line-height:150% !important;
         }
 
 }	@media only screen and (max-width: 480px){
     /*
     @tab Mobile Styles
     @section Boxed Text
     @tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
     */
         .mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
             /*@editable*/font-size:14px !important;
             /*@editable*/line-height:150% !important;
         }
 
 }	@media only screen and (max-width: 480px){
     /*
     @tab Mobile Styles
     @section Header Text
     @tip Make the header text larger in size for better readability on small screens.
     */
         .headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
             /*@editable*/font-size:16px !important;
             /*@editable*/line-height:150% !important;
         }
 
 }	@media only screen and (max-width: 480px){
     /*
     @tab Mobile Styles
     @section Body Text
     @tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
     */
         .bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
             /*@editable*/font-size:16px !important;
             /*@editable*/line-height:150% !important;
         }
 
 }	@media only screen and (max-width: 480px){
     /*
     @tab Mobile Styles
     @section Footer Text
     @tip Make the footer content text larger in size for better readability on small screens.
     */
         .footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
             /*@editable*/font-size:14px !important;
             /*@editable*/line-height:150% !important;
         }
 
 }</style></head>
     <body>
         <center>
             <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                 <tr>
                     <td align="center" valign="top" id="bodyCell">
                         <!-- BEGIN TEMPLATE // -->
                         <table border="0" cellpadding="0" cellspacing="0" width="100%">
                             <tr>
                                 <td align="center" valign="top" id="templateHeader" data-template-container>
                                     <!--[if (gte mso 9)|(IE)]>
                                     <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                     <tr>
                                     <td align="center" valign="top" width="600" style="width:600px;">
                                     <![endif]-->
                                     <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                         <tr>
                                             <td valign="top" class="headerContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
     <tbody class="mcnImageBlockOuter">
             <tr>
                 <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                     <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                         <tbody><tr>
                             <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                 
                                     <a href="https://memorable.com.ar/" title="" class="" target="_self">
                                         <img align="center" alt="" src="https://mcusercontent.com/a15b0b29165dc0643c9cac49f/images/c4e034bc-c1b1-4c49-bc5c-a706b1bf49ff.png" width="247" style="max-width:247px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                     </a>
                                 
                             </td>
                         </tr>
                     </tbody></table>
                 </td>
             </tr>
     </tbody>
 </table></td>
                                         </tr>
                                     </table>
                                     <!--[if (gte mso 9)|(IE)]>
                                     </td>
                                     </tr>
                                     </table>
                                     <![endif]-->
                                 </td>
                             </tr>
                             <tr>
                                 <td align="center" valign="top" id="templateBody" data-template-container>
                                     <!--[if (gte mso 9)|(IE)]>
                                     <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                     <tr>
                                     <td align="center" valign="top" width="600" style="width:600px;">
                                     <![endif]-->
                                     <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                         <tr>
                                             <td valign="top" class="bodyContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
     <tbody class="mcnTextBlockOuter">
         <tr>
             <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                   <!--[if mso]>
                 <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                 <tr>
                 <![endif]-->
                 
                 <!--[if mso]>
                 <td valign="top" width="600" style="width:600px;">
                 <![endif]-->
                 <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                     <tbody><tr>
                         
                         <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                         
                             <h1 style="text-align: center;"><span style="font-family:lato,helvetica neue,helvetica,arial,sans-serif">¡Bienvenido a la comunidad Memorable!</span></h1>
 
                         </td>
                     </tr>
                 </tbody></table>
                 <!--[if mso]>
                 </td>
                 <![endif]-->
                 
                 <!--[if mso]>
                 </tr>
                 </table>
                 <![endif]-->
             </td>
         </tr>
     </tbody>
 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
     <!--[if gte mso 9]>
     <table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
     <![endif]-->
     <tbody class="mcnBoxedTextBlockOuter">
         <tr>
             <td valign="top" class="mcnBoxedTextBlockInner">
                 
                 <!--[if gte mso 9]>
                 <td align="center" valign="top" ">
                 <![endif]-->
                 <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
                     <tbody><tr>
                         
                         <td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                         
                             <table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #EDEDD8;">
                                 <tbody><tr>
                                     <td valign="top" class="mcnTextContent" style="padding: 18px;color: #111111;font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, Verdana, sans-serif;font-size: 14px;font-weight: normal;text-align: center;">
                                         <h2 class="null" style="text-align: center;"><span style="font-size:16px">Ya podés disfrutar de nuestros productos con un&nbsp;<strong>10% OFF</strong></span></h2>
 
 <h3 style="text-align: center;"><span style="font-family:helvetica neue,helvetica,arial,verdana,sans-serif"><span style="font-size:18px"><span style="color:#000000">TU CUPÓN DE DESCUENTO ES</span></span></span></h3>
 &nbsp;
 
 <!--ACA HAY CÓDIGO MUY SIMILAR A LO QUE LLEGA POR MAIL-->
 
 <div style="text-align: center;"><strong><span style="padding: 10px 15px; border: 2px solid #cb333b; color:#cb333b; display:inline-block;"><span style="font-weight: bold;font-size:26px">' . $coupon . '</span></span></strong><br>
 &nbsp;
 <p style="color: #111111;font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, Verdana, sans-serif;font-size: 14px;font-weight: normal;text-align: center;">Para utilizarlo copialo y pegalo en tu formulario de compra.<br>
 <span style="font-size:12px">Únicamente válido para compras mayores a $10.000.</span></p>
 </div>
 
                                     </td>
                                 </tr>
                             </tbody></table>
                         </td>
                     </tr>
                 </tbody></table>
                 <!--[if gte mso 9]>
                 </td>
                 <![endif]-->

                 <!--[if gte mso 9]>
                 </tr>
                 </table>
                 <![endif]-->
             </td>
         </tr>
     </tbody>
 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
   
 
  <tbody class="mcnDividerBlockOuter">
         <tr>
             <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                 <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;">
                     <tbody><tr>
                         <td>
                             <span></span>
                         </td>
                     </tr>
                 </tbody></table>
 <!--            
                 <td class="mcnDividerBlockInner" style="padding: 18px;">
                 <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
 -->
             </td>
         </tr>
     </tbody>
 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
     <tbody class="mcnButtonBlockOuter">
         <tr>
             <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                 <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #CB333B;">
                     <tbody>
                         <tr>
                             <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Helvetica; font-size: 18px; padding: 18px;">
                                 <a class="mcnButton " title="Ir a la tienda Memorable" href="https://memorable.com.ar/" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Ir a la tienda Memorable</a>
                             </td>
                         </tr>
                     </tbody>
                 </table>
             </td>
         </tr>
     </tbody>
 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
     
 /*A partir de aquí quitamos en código del envío gratis*/
 
 <tbody class="mcnDividerBlockOuter">
         <tr>
             <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                 <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;">
                     <tbody><tr>
                         <td>
                             <span></span>
                         </td>
                     </tr>
                 </tbody></table>
 <!--            
                 <td class="mcnDividerBlockInner" style="padding: 18px;">
                 <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
 -->
             </td>
         </tr>
     </tbody>
 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
     <!--[if gte mso 9]>
     <table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
     <![endif]-->
     <tbody class="mcnBoxedTextBlockOuter">
         <tr>
             <td valign="top" class="mcnBoxedTextBlockInner">
                 
                 <!--[if gte mso 9]>
                 <td align="center" valign="top" ">
                 <![endif]-->
                 <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
                     <tbody><tr>
                         
                         <td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                         
                             <table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #CB333B;">
                                 <tbody><tr>
                                     <td valign="top" class="mcnTextContent" style="padding: 18px;color: #F2F2F2;font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, Verdana, sans-serif;font-size: 14px;font-weight: normal;text-align: center;">
                                         <p style="text-align: center;color: #F2F2F2;font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, Verdana, sans-serif;font-size: 14px;font-weight: normal;"><span style="font-size:18px"><strong>ENVÍO GRATIS A TODO EL PAÍS</strong></span><br>
 <br>
 Además del descuento, te lo enviamos&nbsp;<strong>sin costo</strong>&nbsp;a tu casa!<br>
 &nbsp;</p>
 
/*-----------------------------*/

 <div style="text-align: center;"><img data-file-id="1507666" height="200" src="https://mcusercontent.com/a15b0b29165dc0643c9cac49f/images/861b3765-5d67-4841-843f-0f360c43d398.png" style="border: 0px  ; width: 200px; height: 200px; margin: 0px;" width="200"></div>
 
                                     </td>
                                 </tr>
                             </tbody></table>
                         </td>
                     </tr>
                 </tbody></table>
                 <!--[if gte mso 9]>
                 </td>
                 <![endif]-->
                 
                 <!--[if gte mso 9]>
                 </tr>
                 </table>
                 <![endif]-->
             </td>
         </tr>
     </tbody>
 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
     <tbody class="mcnImageBlockOuter">
             <tr>
                 <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                     <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                         <tbody><tr>
                             <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                 
                                     
                                         <img align="center" alt="" src="https://mcusercontent.com/a15b0b29165dc0643c9cac49f/images/72dd1e79-d527-42c0-a381-63044c84c79d.jpeg" width="564" style="max-width:900px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                     
                                 
                             </td>
                         </tr>
                     </tbody></table>
                 </td>
             </tr>
     </tbody>
 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
     <tbody class="mcnImageBlockOuter">
             <tr>
                 <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                     <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                         <tbody><tr>
                             <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                 
                                     
                                         <img align="center" alt="" src="https://mcusercontent.com/a15b0b29165dc0643c9cac49f/images/3f48081a-62f3-4c99-9846-d28bbdf26022.png" width="564" style="max-width:735px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                     
                                 
                             </td>
                         </tr>
                     </tbody></table>
                 </td>
             </tr>
     </tbody>
 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
     <tbody class="mcnFollowBlockOuter">
         <tr>
             <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                 <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
     <tbody><tr>
         <td align="center" style="padding-left:9px;padding-right:9px;">
             <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;background-color: #FFFFFF;" class="mcnFollowContent">
                 <tbody><tr>
                     <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                         <table align="center" border="0" cellpadding="0" cellspacing="0">
                             <tbody><tr>
                                 <td align="center" valign="top">
                                     <!--[if mso]>
                                     <table align="center" border="0" cellspacing="0" cellpadding="0">
                                     <tr>
                                     <![endif]-->
                                     
                                         <!--[if mso]>
                                         <td align="center" valign="top">
                                         <![endif]-->
                                         
                                         
                                             <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                 <tbody><tr>
                                                     <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                         <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                             <tbody><tr>
                                                                 <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                     <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                         <tbody><tr>
                                                                             
                                                                                 <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
/* hasta acá sacamos el código*/                                                                                     <a href="https://www.facebook.com/memorablegourmet/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-dark-facebook-48.png" alt="Facebook" style="display:block;" height="24" width="24" class=""></a>
                                                                                 </td>
                                                                             
                                                                             
                                                                         </tr>
                                                                     </tbody></table>
                                                                 </td>
                                                             </tr>
                                                         </tbody></table>
                                                     </td>
                                                 </tr>
                                             </tbody></table>
                                         
                                         <!--[if mso]>
                                         </td>
                                         <![endif]-->
                                     
                                         <!--[if mso]>
                                         <td align="center" valign="top">
                                         <![endif]-->
                                         
                                         
                                             <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                 <tbody><tr>
                                                     <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                         <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                             <tbody><tr>
                                                                 <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                     <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                         <tbody><tr>
                                                                             
                                                                                 <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                     <a href="https://www.instagram.com/memorablegourmet/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-dark-instagram-48.png" alt="Link" style="display:block;" height="24" width="24" class=""></a>
                                                                                 </td>
                                                                             
                                                                             
                                                                         </tr>
                                                                     </tbody></table>
                                                                 </td>
                                                             </tr>
                                                         </tbody></table>
                                                     </td>
                                                 </tr>
                                             </tbody></table>
                                         
                                         <!--[if mso]>
                                         </td>
                                         <![endif]-->
                                     
                                         <!--[if mso]>
                                         <td align="center" valign="top">
                                         <![endif]-->
                                         
                                         
                                             <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                 <tbody><tr>
                                                     <td valign="top" style="padding-right:0; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                         <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                             <tbody><tr>
                                                                 <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                     <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                         <tbody><tr>
                                                                             
                                                                                 <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                     <a href="https://memorable.com.ar/" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-dark-link-48.png" alt="Website" style="display:block;" height="24" width="24" class=""></a>
                                                                                 </td>
                                                                             
                                                                             
                                                                         </tr>
                                                                     </tbody></table>
                                                                 </td>
                                                             </tr>
                                                         </tbody></table>
                                                     </td>
                                                 </tr>
                                             </tbody></table>
                                         
                                         <!--[if mso]>
                                         </td>
                                         <![endif]-->
                                     
                                     <!--[if mso]>
                                     </tr>
                                     </table>
                                     <![endif]-->
                                 </td>
                             </tr>
                         </tbody></table>
                     </td>
                 </tr>
             </tbody></table>
         </td>
     </tr>
 </tbody></table>
 
             </td>
         </tr>
     </tbody>
 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
     <tbody class="mcnTextBlockOuter">
         <tr>
             <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                   <!--[if mso]>
                 <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                 <tr>
                 <![endif]-->
                 
                 <!--[if mso]>
                 <td valign="top" width="600" style="width:600px;">
                 <![endif]-->
                 <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                     <tbody><tr>
                         
                         <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                         
                             <div style="text-align: center;"><img data-file-id="1507650" height="68" src="https://mcusercontent.com/a15b0b29165dc0643c9cac49f/images/c4e034bc-c1b1-4c49-bc5c-a706b1bf49ff.png" style="border: 0px initial ; width: 200px; height: 68px; margin: 0px;" width="200"><br>
 <strong><span style="color:#000000"><span style="font-family:helvetica neue,helvetica,arial,verdana,sans-serif"><span style="font-size:12px">Soberanía Nacional 850 Trelew, Chubut<br>
 Argentina</span></span></span></strong></div>
 
                         </td>
                     </tr>
                 </tbody></table>
                 <!--[if mso]>
                 </td>
                 <![endif]-->
                 
                 <!--[if mso]>
                 </tr>
                 </table>
                 <![endif]-->
             </td>
         </tr>
     </tbody>
 </table></td>
                                         </tr>
                                     </table>
                                     <!--[if (gte mso 9)|(IE)]>
                                     </td>
                                     </tr>
                                     </table>
                                     <![endif]-->
                                 </td>
                             </tr>
                             <tr>
                                 <td align="center" valign="top" id="templateFooter" data-template-container>
                                     <!--[if (gte mso 9)|(IE)]>
                                     <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                     <tr>
                                     <td align="center" valign="top" width="600" style="width:600px;">
                                     <![endif]-->
                                     <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                         <tr>
                                             <td valign="top" class="footerContainer"></td>
                                         </tr>
                                     </table>
                                     <!--[if (gte mso 9)|(IE)]>
                                     </td>
                                     </tr>
                                     </table>
                                     <![endif]-->
                                 </td>
                             </tr>
                         </table>
                         <!-- // END TEMPLATE -->
                     </td>
                 </tr>
             </table>
         </center>
     </body>
 </html>
 ';
     
     wp_mail( $email, $subject, $body );
     
     // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
     remove_filter( 'wp_mail_content_type', 'set_html_mail_content_type' );
 }
 
  
 function set_html_mail_content_type() {
     return 'text/html';
 }
 
//  function override_shortcodes(){
//    if(is_woocommerce_activated()){
//      require get_stylesheet_directory() . '/inc/shortcodes/ux_products.php';
//    }
//  }
//  add_action('wp_loaded', 'override_shortcodes', 10);
 
 function month_diff($date1, $date2)
 {
     $begin = new DateTime( $date1 );
     $end = new DateTime( $date2 );
 
     $interval = DateInterval::createFromDateString('1 month');
 
     $period = new DatePeriod($begin, $interval, $end);
     $counter = 0;
     foreach($period as $dt) {
         $counter++;
     }
 
     return $counter;
 }
 
 function calculate_arboles($months, $arboles_per_month){
     $totalArboles = $months * $arboles_per_month;
     return $totalArboles;
 }
 
 function getSaboresImageUrl($sabor){
     switch ($sabor) {
         case 'Boysenberry':
             return bloginfo('url') . '/wp-content/uploads/2019/07/boysenberry.png';
             break;
         case 'Frambuesa':
             return bloginfo('url') . '/wp-content/uploads/2019/07/frambuesa.png';
             break;
         case 'Frutilla':
             return bloginfo('url') . '/wp-content/uploads/2019/07/frutilla.png';
             break;
         case 'Frutos del Bosque':
             return bloginfo('url') . '/wp-content/uploads/2019/07/frutos-rojos.png';
             break;
         case 'Sauco':
             return bloginfo('url') . '/wp-content/uploads/2019/07/sauco.png';
             break;
         case 'Calafate':
             return bloginfo('url') . '/wp-content/uploads/2019/07/calafate.png';
             break;
         case 'Rosa Mosqueta':
             return bloginfo('url') . '/wp-content/uploads/2019/07/rosa-mosqueta.png';
             break;
         case 'Cassis':
             return bloginfo('url') . '/wp-content/uploads/2019/07/cassis.png';
             break;
         case 'Dulce de Leche':
             return bloginfo('url') . '/wp-content/uploads/2019/07/dulce-de-leche.png';
             break;
         case 'Bocadito Torta Galesa':
             return bloginfo('url') . '/wp-content/uploads/2019/07/bocadito.png';
             break;
         case 'Dulce de Leche con Chocolate Blanco':
             return bloginfo('url') . '/wp-content/uploads/2019/07/choco-blanco.png';
             break;
         default:
             
             break;
     }
 }
 
 
 /*Adding client phone to the order columns in WooCommerce -> Pedidos table*/
 add_action( 'manage_shop_order_posts_custom_column' , 'custom_orders_list_column_content', 50, 2 );
 function custom_orders_list_column_content( $column, $post_id ) {
     if ( $column == 'order_number' )
     {
         global $the_order;
 
         if( $phone = $the_order->get_billing_phone() ){
         
             $filtered_content = preg_replace('/[^0-9]/', '', $phone);
             
             $phone_wp_dashicon = '<span class="dashicons dashicons-phone"></span> ';
             echo '<br><strong><a href="https://wa.me/' . $filtered_content . '">' . $phone_wp_dashicon . $phone.'</a></strong>';
         }
 
   
     }
 }
 
 /*See used template for each page if superadmin*/
 function show_template() {
     if( is_super_admin() ){
         global $template;
         print_r($template);
     } 
 }
 add_action('wp_footer', 'show_template');
 
 /*Add placehoder for Phone number in WooCommerce forms, checkout*/
 add_filter( 'woocommerce_checkout_fields' , 'override_billing_checkout_fields', 20, 1 );
 function override_billing_checkout_fields( $fields ) {
     $fields['billing']['billing_phone']['label'] = 'Teléfono (WhatsApp)';
     $fields['billing']['billing_phone']['placeholder'] = '54 11 1234 1234';
     return $fields;
 }
 
/*-----------------VALIDACION DEL TELÉFONO CLIENTE----------------------*/
 // Custom validation for Billing Phone checkout field
 /*add_action('woocommerce_checkout_process', 'custom_validate_billing_phone');
 function custom_validate_billing_phone() {
     $is_correct = preg_match('/^[0-9]{12,20}$/', $_POST['billing_phone']);
     if ( $_POST['billing_phone'] && !$is_correct) {
         wc_add_notice( __( 'Por favor incluya el prefijo, por ejemplo <strong>54 11</strong>1234 1234.' ), 'error' );
     }
 }*/

 
 

 // Custom Swiper Slider
 add_shortcode( 'custom_slider_products', 'custom_swiper_slider_shortcode' );

function custom_swiper_slider_shortcode($atts) {

    $atts = shortcode_atts( array(
        'posts_per_page' => 6, // Número de productos a mostrar
        'navigation' => true // Mostrar controles de navegación
    ), $atts, 'custom_swiper_slider' );
    
    $output = '<div class="elementor-swiper">';
    $output .= '<div class="swiper-container essentials">';
    $output .= '<div class="swiper-wrapper">';
    
    // Obtener los productos de WooCommerce
    $products = get_posts( array(
        'post_type' => 'product',
        'posts_per_page' => $atts['posts_per_page'],
    ) );
    
    foreach ( $products as $product ) {
        setup_postdata( $product );
        $product_id = $product->ID;
        $product = wc_get_product( $product_id );
        // $product_price_regular =     $product->get_regular_price();
        // $product_price_sale = $product->get_sale_price();
        $product_price =  $product->get_price();
        // $product = wc_get_product($product_id);
        //   $product_price = wc_price( get_post_meta( $product_id, 'regular_price', true ) );
        //   $product_price = $product->get_regular_price();
        //   echo '$product_price'.$product_price;
        
        $product_image = get_the_post_thumbnail_url( $product_id, 'large' );
        $product_permalink = get_permalink( $product_id ); 

        $output .= '<div class="swiper-slide">';
        $output .= '<h2 class="product-title"><a href="' . $product_permalink . '">';

        $output .= '<div class="product-image"><img src="' . $product_image . '"></div>';
        // $output .= '<div class="product-details">';
        $output .= '<p class="product-price">€ ' . $product_price . '</p>';
        // $output .= '</div>';
        $output .= '</a></div>';
    }
    
    $output .= '</div>';
    $output .= '</div>';
    
    // if ( $atts['navigation'] ) {
    //     $output .= '<div class="swiper-button-next"></div>';
    //     $output .= '<div class="swiper-button-prev"></div>';
    // }
    $output .= '<div class="swiper-pagination pag_essentials"></div>';   
    $output .= '</div>';


    wp_reset_postdata();
    
    // Agregar el script de inicialización de Swiper
    $output .= '';
    
    return $output;
}



/// Juanma //// -------------------------------
add_shortcode( 'custom_slider_products_jnma', 'custom_swiper_slider_shortcode_jnma' );

function custom_swiper_slider_shortcode_jnma($atts) {

    $atts = shortcode_atts( array(
        'posts_per_page' => 6, // Número de productos a mostrar
        'navigation' => true // Mostrar controles de navegación
    ), $atts, 'custom_swiper_slider' );
    
    $output = '<div class="elementor-swiper">';
    $output .= '<div class="swiper-container essentials">';
    $output .= '<div class="swiper-wrapper">';
    
    // Obtener los productos de WooCommerce
    $products = get_posts( array(
        'post_type' => 'product',
        'posts_per_page' => $atts['posts_per_page'],
    ) );
    
    foreach ( $products as $product ) {
        setup_postdata( $product );
        $product_id = $product->ID;
        $product = wc_get_product( $product_id );
        // $product_price_regular =     $product->get_regular_price();
        // $product_price_sale = $product->get_sale_price();
        $product_price =  $product->get_price();
        // $product = wc_get_product($product_id);
        //   $product_price = wc_price( get_post_meta( $product_id, 'regular_price', true ) );
        //   $product_price = $product->get_regular_price();
        //   echo '$product_price'.$product_price;
        
        $product_image = get_the_post_thumbnail_url( $product_id, 'large' );
        $product_permalink = get_permalink( $product_id ); 

        $output .= '<div class="swiper-slide">';
        $output .= '<h2 class="product-title"><a href="' . $product_permalink . '">';

        $output .= '<div class="product-image"><img src="' . $product_image . '"></div>';
        // $output .= '<div class="product-details">';
        $output .= '<p class="product-price">€ ' . $product_price . '</p>';
        // $output .= '</div>';
        $output .= '</a></div>';
    }
    
    $output .= '</div>';
    $output .= '</div>';
    
    // if ( $atts['navigation'] ) {
    //     $output .= '<div class="swiper-button-next"></div>';
    //     $output .= '<div class="swiper-button-prev"></div>';
    // }
    $output .= '<div class="swiper-pagination pag_essentials"></div>';   
    $output .= '</div>';


    wp_reset_postdata();
    
    // Agregar el script de inicialización de Swiper
    $output .= '';
    
    return $output;
}


// Función Página Compromiso Verde -- Verifica si es el primer día del mes,
// de serlo, suma 70 arboles al campo
//
//
function asignar_valor_numero_de_nuevos_arboles_compromiso_verde() {
    // Verifica si es el primer día del mes y si la función ya se ejecutó este mes
    $ultima_ejecucion = get_option('ultima_ejecucion_asignar_valor_numero_de_nuevos_arboles_compromiso_verde', 0);
    if (date('j') == 1 && $ultima_ejecucion != date('n')) {
        // Asigna el valor 70 al campo personalizado 'numero_de_nuevos_arboles' en la página con ID 58
        update_post_meta(58, 'numero_de_nuevos_arboles', 70);
        
        // Actualiza la opción para marcar que la función se ejecutó este mes
        update_option('ultima_ejecucion_asignar_valor_numero_de_nuevos_arboles_compromiso_verde', date('n'));
    } elseif (date('j') == 2 && $ultima_ejecucion == date('n')) {
        // En el segundo día del mes, asigna el valor 0 al campo personalizado 'numero_de_nuevos_arboles' en la página con ID 58
        update_post_meta(58, 'numero_de_nuevos_arboles', 0);
    }
}

// Hook para ejecutar la función diariamente
add_action('init', 'asignar_valor_numero_de_nuevos_arboles_compromiso_verde');