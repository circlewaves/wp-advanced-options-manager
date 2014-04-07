<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   WP Advanced options manager
 * @author    Circlewaves Team <support@circlewaves.com>
 * @license   GPL-2.0+
 * @link      http://circlewaves.com
 * @copyright 2014 Circlewaves Team <support@circlewaves.com>
 */
?>


<?php
$hasError=false;
$msgValue=$msgClass=null;
$get_option_value=$get_option_name=null;

if(isset($_POST['cw_wpaom_get_option_nonce']) && wp_verify_nonce( $_POST['cw_wpaom_get_option_nonce'], 'cw_wpaom_get_option' ) && current_user_can( 'manage_options' ) ){
	$get_option_name=esc_attr($_POST['get_option_name']);
	if(!$get_option_name){
		$hasError=true;
		$msgClass='error';
		$msgValue='Please enter option name';
	}else{
		$get_option_value=get_option($get_option_name);
		$msgClass='updated';
		$msgValue='Value has been retrieved successfully';		
	}
	$_POST=null;
}


$update_option_value=$update_option_name=$get_option_value_old=$get_option_value_new=null;

if(isset($_POST['cw_wpaom_update_option_nonce']) && wp_verify_nonce( $_POST['cw_wpaom_update_option_nonce'], 'cw_wpaom_update_option' ) && current_user_can( 'manage_options' ) ){
$update_option_value=esc_attr($_POST['update_option_value']);
$update_option_name=esc_attr($_POST['update_option_name']);
	if(!$update_option_name){
		$hasError=true;
		$msgClass='error';
		$msgValue='Please enter option name';
	}else{
		$get_option_value_old=get_option($update_option_name);
		if($update_option_value){
			update_option($update_option_name,$update_option_value);
			$msgValue='Option has been updated successfully';		
		}else{
			delete_option($update_option_name);
			$msgValue='Option has been deleted successfully';		
		}
		$get_option_value_new=get_option($update_option_name);
		$msgClass='updated';
	}
	$_POST=null;
}
?>

<div class="wrap bmplayer_options_page">
	
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php if( isset($msgValue) && isset($msgClass)) { ?>
	<div id="message" class="<?php echo $msgClass;?>">
			<p><strong><?php _e($msgValue,$cw_wpaom_plugin_slug) ?></strong></p>
	</div>
	<?php } ?>
	
	<div id="poststuff">
	
		<div id="post-body" class="metabox-holder columns-2">
		
			<!-- main content -->
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<div class="inside">
							<h3>GET OPTION</h3>
							<form method="POST">
								<?php wp_nonce_field( 'cw_wpaom_get_option', 'cw_wpaom_get_option_nonce' );?>
								<p>
									<label for="get_option_name">Option Name:</label>
									<input type="text" class="all-options" id="get_option_name" name="get_option_name" value="" />
								</p>
								<p>
									<input class="button-primary" type="submit" value="<?php _e( 'Get value',$cw_wpaom_plugin_slug); ?>" />
								</p>
							</form>			
							<?php 
							if($get_option_name){
							echo "<p class='alternate'>Value of <strong>$get_option_name</strong>:</p>";
							var_dump($get_option_value);
							}
							?>						
							<h3>UPDATE OPTION</h3>
							<form method="POST">
								<?php wp_nonce_field( 'cw_wpaom_update_option', 'cw_wpaom_update_option_nonce' );?>
								<p>
									<label for="update_option_name">Option Name:</label>
									<input type="text" class="all-options" id="update_option_name" name="update_option_name" value="" />
								</p>								
								<p>
									<label for="update_option_value">Option Value:</label>
									<input type="text" class="all-options" id="update_option_value" name="update_option_value" value="" />
									<span class="description">Leave value blank if you want to delete option</span>
								</p>	
								<p>
									<input class="button-primary" type="submit" value="<?php _e( 'Update value',$cw_wpaom_plugin_slug); ?>" onclick="return confirm('Are you sure you want to update this option?')" />
								</p>
							</form>	
							<?php 
							if($update_option_name){
							echo "<p class='alternate'>Old value of <strong>$update_option_name</strong>:</p>";
							var_dump($get_option_value_old);
							echo "<p class='alternate'>New value of <strong>$update_option_name</strong>:</p>";
							var_dump($get_option_value_new);
							}
							?>								
						</div>	
					</div>
				</div>
			</div>
			<!-- end main content -->
			
			<!-- sidebar -->
			<?php include_once( 'sidebar-right.php' );?>
			<!-- end sidebar -->
			
		</div> 
		<!-- end post-body-->
		
		<br class="clear">
	</div>
	<!-- end poststuff -->
	
</div>