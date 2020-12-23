<div class="wrap">
	<h2>AMS Google Webmaster Tools</h2>
	<form method="post" action="options.php">
		<?php wp_nonce_field('amsgwmt-options'); ?>
		<?php settings_fields('amsgwmt_webmaster_tools'); ?>

		<p>Insert your Google Webmaster Tools verification code below:</p>

		<textarea name="amsgwmt_setting" id="amsgwmt_setting" rows="15"  cols="100">
<?php echo get_option('amsgwmt_setting'); ?> </textarea>

		<input type="hidden" name="action" value="update"/>
		
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>

	</form>
</div>
