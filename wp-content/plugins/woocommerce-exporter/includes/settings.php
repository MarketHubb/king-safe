<?php
function woo_ce_export_settings_quicklinks() {

	ob_start(); ?>
<li>| <a href="#xml-settings"><?php _e( 'XML Settings', 'woocommerce-exporter' ); ?></a> |</li>
<li><a href="#rss-settings"><?php _e( 'RSS Settings', 'woocommerce-exporter' ); ?></a> |</li>
<li><a href="#scheduled-exports"><?php _e( 'Scheduled Exports', 'woocommerce-exporter' ); ?></a> |</li>
<li><a href="#cron-exports"><?php _e( 'CRON Exports', 'woocommerce-exporter' ); ?></a> |</li>
<li><a href="#orders-screen"><?php _e( 'Orders Screen', 'woocommerce-exporter' ); ?></a></li>
<?php
	ob_end_flush();

}

function woo_ce_export_settings_csv() {

	$woo_cd_url = 'https://www.visser.com.au/plugins/store-exporter-deluxe/?platform=wc';
	$woo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'woocommerce-exporter' ) . '</a>', $woo_cd_url );

	ob_start(); ?>
<tr>
	<th>
		<label for="header_formatting"><?php _e( 'Header formatting', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<ul style="margin-top:0.2em;">
			<li><label><input type="radio" name="header_formatting" value="1"<?php checked( 1, 1 ); ?> />&nbsp;<?php _e( 'Include export field column headers', 'woocommerce-exporter' ); ?></label></li>
			<li><label><input type="radio" name="header_formatting" value="0" disabled="disabled" />&nbsp;<?php _e( 'Do not include export field column headers', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
		</ul>
		<p class="description"><?php _e( 'Choose the header format that suits your spreadsheet software (e.g. Excel, OpenOffice, etc.). This rule applies to CSV, XLS and XLSX export types.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<?php
	ob_end_flush();

}

// Returns the disabled HTML template for the Enable CRON and Secret Export Key options for the Settings screen
function woo_ce_export_settings_extend() {

	$woo_cd_url = 'https://www.visser.com.au/plugins/store-exporter-deluxe/?platform=wc';
	$woo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'woocommerce-exporter' ) . '</a>', $woo_cd_url );

	// RSS settings
	$rss_title = __( 'Title of your RSS feed', 'woocommerce-exporter' );
	$rss_link = __( 'URL to your RSS feed', 'woocommerce-exporter' );
	$rss_description = __( 'Summary description of your RSS feed', 'woocommerce-exporter' );

	// Scheduled exports
	$auto_commence_date = date( 'd/m/Y H:i', current_time( 'timestamp', 1 ) );
	// Override to enable the Export Type to include all export types
	$types = array(
		'product' => __( 'Products', 'woocommerce-exporter' ),
		'category' => __( 'Categories', 'woocommerce-exporter' ),
		'tag' => __( 'Tags', 'woocommerce-exporter' ),
		'brand' => __( 'Brands', 'woocommerce-exporter' ),
		'order' => __( 'Orders', 'woocommerce-exporter' ),
		'customer' => __( 'Customers', 'woocommerce-exporter' ),
		'user' => __( 'Users', 'woocommerce-exporter' ),
		'coupon' => __( 'Coupons', 'woocommerce-exporter' ),
		'subscription' => __( 'Subscriptions', 'woocommerce-exporter' ),
		'product_vendor' => __( 'Product Vendors', 'woocommerce-exporter' ),
		'shipping_class' => __( 'Shipping Classes', 'woocommerce-exporter' )
	);
	$order_statuses = woo_ce_get_order_statuses();
	$product_types = woo_ce_get_product_types();
	$args = array(
		'hide_empty' => 1
	);
	$product_categories = woo_ce_get_product_categories( $args );
	$product_tags = woo_ce_get_product_tags( $args );

	$auto_interval = 1440;
	$auto_format = 'csv';
	$order_filter_date_variable = '';

	// Send to e-mail
	$email_to = get_option( 'admin_email', '' );
	$email_subject = __( '[%store_name%] Export: %export_type% (%export_filename%)', 'woocommerce-exporter' );

	// Post to remote URL
	$post_to = 'http://www.domain.com/custom-post-form-processor.php';

	// Export to FTP
	$ftp_method_host = 'ftp.domain.com';
	$ftp_method_port = '';
	$ftp_method_protocol = 'ftp';
	$ftp_method_user = 'export';
	$ftp_method_pass = '';
	$ftp_method_path = 'wp-content/uploads/export/';
	$ftp_method_filename = 'fixed-filename';
	$ftp_method_passive = 'auto';
	$ftp_method_timeout = '';

	$scheduled_fields = 'all';

	// CRON exports
	$secret_key = '-';
	$cron_fields = 'all';

	$cron_fields = 'all';

	// Orders Screen
	$order_actions_csv = 1;
	$order_actions_tsv = 1;
	$order_actions_xml = 0;
	$order_actions_xls = 1;
	$order_actions_xlsx = 1;

	$troubleshooting_url = 'http://www.visser.com.au/documentation/store-exporter-deluxe/usage/';

	ob_start(); ?>
<tr id="xml-settings">
	<td colspan="2" style="padding:0;">
		<hr />
		<h3><div class="dashicons dashicons-media-code"></div>&nbsp;<?php _e( 'XML Settings', 'woocommerce-exporter' ); ?></h3>
	</td>
</tr>
<tr>
	<th>
		<?php _e( 'Attribute display', 'woocommerce-exporter' ); ?>
	</th>
	<td>
		<ul>
			<li><label><input type="checkbox" name="xml_attribute_url" value="1" disabled="disabled" /> <?php _e( 'Site Address', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="xml_attribute_title" value="1" disabled="disabled" /> <?php _e( 'Site Title', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="xml_attribute_date" value="1" disabled="disabled" /> <?php _e( 'Export Date', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="xml_attribute_time" value="1" disabled="disabled" /> <?php _e( 'Export Time', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="xml_attribute_export" value="1" disabled="disabled" /> <?php _e( 'Export Type', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="xml_attribute_orderby" value="1" disabled="disabled" /> <?php _e( 'Export Order By', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="xml_attribute_order" value="1" disabled="disabled" /> <?php _e( 'Export Order', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="xml_attribute_limit" value="1" disabled="disabled" /> <?php _e( 'Limit Volume', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="xml_attribute_offset" value="1" disabled="disabled" /> <?php _e( 'Volume Offset', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
		</ul>
		<p class="description"><?php _e( 'Control the visibility of different attributes in the XML export.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<!-- #xml-settings -->

<tr id="rss-settings">
	<td colspan="2" style="padding:0;">
		<hr />
		<h3><div class="dashicons dashicons-media-code"></div>&nbsp;<?php _e( 'RSS Settings', 'woocommerce-exporter' ); ?></h3>
	</td>
</tr>
<tr>
	<th>
		<label for="rss_title"><?php _e( 'Title element', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<input name="rss_title" type="text" id="rss_title" value="<?php echo esc_attr( $rss_title ); ?>" class="regular-text" disabled="disabled" /><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
		<p class="description"><?php _e( 'Defines the title of the data feed (e.g. Product export for WordPress Shop).', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="rss_link"><?php _e( 'Link element', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<input name="rss_link" type="text" id="rss_link" value="<?php echo esc_attr( $rss_link ); ?>" class="regular-text" disabled="disabled" /><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
		<p class="description"><?php _e( 'A link to your website, this doesn\'t have to be the location of the RSS feed.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="rss_description"><?php _e( 'Description element', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<input name="rss_description" type="text" id="rss_description" value="<?php echo esc_attr( $rss_description ); ?>" class="large-text" disabled="disabled" /><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
		<p class="description"><?php _e( 'A description of your data feed.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<!-- #rss-settings -->

<tr id="scheduled-exports">
	<td colspan="2" style="padding:0;">
		<hr />
		<h3>
			<div class="dashicons dashicons-calendar"></div>&nbsp;<?php _e( 'Scheduled Exports', 'woocommerce-exporter' ); ?>
		</h3>
		<p class="description"><?php _e( 'Configure Store Exporter Deluxe to automatically generate exports, apply filters to export just what you need.<br />Adjusting options within the Scheduling sub-section will after clicking Save Changes refresh the scheduled export engine, editing filters, formats, methods, etc. will not affect the scheduling of the current scheduled export.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<tr>
	<th><label for="enable_auto"><?php _e( 'Enable scheduled exports', 'woocommerce-exporter' ); ?></label></th>
	<td>
		<select id="enable_auto" name="enable_auto">
			<option value="1" disabled="disabled"><?php _e( 'Yes', 'woocommerce-exporter' ); ?></option>
			<option value="0" selected="selected"><?php _e( 'No', 'woocommerce-exporter' ); ?></option>
		</select>
		<p class="description"><?php _e( 'Enabling Scheduled Exports will trigger automated exports at the interval specified under Once every (minutes).', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="export_type"><?php _e( 'Export type', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<select id="export_type" name="export_type">
<?php if( !empty( $types ) ) { ?>
	<?php foreach( $types as $key => $type ) { ?>
			<option value="<?php echo $key; ?>"><?php echo $type; ?></option>
	<?php } ?>
<?php } else { ?>
			<option value=""><?php _e( 'No export types were found.', 'woocommerce-exporter' ); ?></option>
<?php } ?>
		</select>
		<span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span>
		<p class="description"><?php _e( 'Select the data type you want to export.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<tr class="export_type_options">
	<th>
		<label><?php _e( 'Export filters', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<ul>

			<li class="export-options product-options">
				<p class="label"><?php _e( 'Product category', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></p>
<?php if( !empty( $product_categories ) ) { ?>
				<select data-placeholder="<?php _e( 'Choose a Product Category...', 'woocommerce-exporter' ); ?>" name="product_filter_category[]" multiple class="chzn-select" style="width:95%;">
	<?php foreach( $product_categories as $product_category ) { ?>
					<option><?php echo woo_ce_format_product_category_label( $product_category->name, $product_category->parent_name ); ?> (<?php printf( __( 'Term ID: %d', 'woocommerce-exporter' ), $product_category->term_id ); ?>)</option>
	<?php } ?>
				</select>
<?php } else { ?>
				<?php _e( 'No Product Categories were found.', 'woocommerce-exporter' ); ?>
<?php } ?>
				<p class="description"><?php _e( 'Select the Product Category\'s you want to filter exported Products by. Default is to include all Product Categories.', 'woocommerce-exporter' ); ?></p>
				<hr />
			</li>

			<li class="export-options product-options">
				<p class="label"><?php _e( 'Product tag', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></p>
<?php if( !empty( $product_tags ) ) { ?>
				<select data-placeholder="<?php _e( 'Choose a Product Tag...', 'woocommerce-exporter' ); ?>" name="product_filter_tag[]" multiple class="chzn-select" style="width:95%;">
	<?php foreach( $product_tags as $product_tag ) { ?>
					<option><?php echo $product_tag->name; ?> (<?php printf( __( 'Term ID: %d', 'woocommerce-exporter' ), $product_tag->term_id ); ?>)</option>
	<?php } ?>
				</select>
<?php } else { ?>
				<?php _e( 'No Product Tags were found.', 'woocommerce-exporter' ); ?>
<?php } ?>
				<p class="description"><?php _e( 'Select the Product Tag\'s you want to filter exported Products by. Default is to include all Product Tags.', 'woocommerce-exporter' ); ?></p>
				<hr />
			</li>

			<li class="export-options product-options">
				<p class="label"><?php _e( 'Product type', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></p>
<?php if( !empty( $product_types ) ) { ?>
				<select data-placeholder="<?php _e( 'Choose a Product Type...', 'woocommerce-exporter' ); ?>" name="product_filter_type[]" multiple class="chzn-select" style="width:95%;">
	<?php foreach( $product_types as $key => $product_type ) { ?>
					<option><?php echo woo_ce_format_product_type( $product_type['name'] ); ?> (<?php echo $product_type['count']; ?>)</option>
	<?php } ?>
				</select>
<?php } else { ?>
				<?php _e( 'No Product Types were found.', 'woocommerce-exporter' ); ?>
<?php } ?>
				<p class="description"><?php _e( 'Select the Product Type\'s you want to filter exported Products by. Default is to include all Product Types and Variations.', 'woocommerce-exporter' ); ?></p>
				<hr />
			</li>

			<li class="export-options product-options">
				<p class="label"><?php _e( 'Stock status', 'woocommerce-exporter' ); ?></p>
				<ul style="margin-top:0.2em;">
					<li><label><input type="radio" name="product_filter_stock" value="" disabled="disabled" /> <?php _e( 'Include both', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
					<li><label><input type="radio" name="product_filter_stock" value="instock" disabled="disabled" /> <?php _e( 'In stock', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
					<li><label><input type="radio" name="product_filter_stock" value="outofstock" disabled="disabled" /> <?php _e( 'Out of stock', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
				</ul>
				<p class="description"><?php _e( 'Select the Stock Status\'s you want to filter exported Products by. Default is to include all Stock Status\'s.', 'woocommerce-exporter' ); ?></p>
			</li>

			<li class="export-options order-options">
				<p class="label"><?php _e( 'Order date', 'woocommerce-exporter' ); ?></p>
				<ul style="margin-top:0.2em;">
					<li><label><input type="radio" name="order_dates_filter" value="" disabled="disabled" /><?php _e( 'All', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
					<li><label><input type="radio" name="order_dates_filter" value="today" disabled="disabled" /><?php _e( 'Today', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
					<li><label><input type="radio" name="order_dates_filter" value="yesterday" disabled="disabled" /><?php _e( 'Yesterday', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
					<li><label><input type="radio" name="order_dates_filter" value="current_week" disabled="disabled" /><?php _e( 'Current week', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
					<li><label><input type="radio" name="order_dates_filter" value="last_week" disabled="disabled" /><?php _e( 'Last week', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
					<li><label><input type="radio" name="order_dates_filter" value="current_month" disabled="disabled" /><?php _e( 'Current month', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
					<li><label><input type="radio" name="order_dates_filter" value="last_month" disabled="disabled" /><?php _e( 'Last month', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
					<li>
						<label><input type="radio" name="order_dates_filter" value="variable" disabled="disabled" /><?php _e( 'Variable date', 'woocommerce-exporter' ); ?></label>
						<div style="margin-top:0.2em;">
							<?php _e( 'Last', 'woocommerce-exporter' ); ?>
							<input type="text" name="order_dates_filter_variable" class="text" size="4" value="<?php echo $order_filter_date_variable; ?>" disabled="disabled" />
							<select name="order_dates_filter_variable_length">
								<option value="">&nbsp;</option>
								<option value="second" disabled="disabled"><?php _e( 'second(s)', 'woocommerce-exporter' ); ?></option>
								<option value="minute" disabled="disabled"><?php _e( 'minute(s)', 'woocommerce-exporter' ); ?></option>
								<option value="hour" disabled="disabled"><?php _e( 'hour(s)', 'woocommerce-exporter' ); ?></option>
								<option value="day" disabled="disabled"><?php _e( 'day(s)', 'woocommerce-exporter' ); ?></option>
								<option value="week" disabled="disabled"><?php _e( 'week(s)', 'woocommerce-exporter' ); ?></option>
								<option value="month" disabled="disabled"><?php _e( 'month(s)', 'woocommerce-exporter' ); ?></option>
								<option value="year" disabled="disabled"><?php _e( 'year(s)', 'woocommerce-exporter' ); ?></option>
							</select>
							<span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span>
						</div>
					</li>
					<li>
						<label><input type="radio" name="order_dates_filter" value="manual" disabled="disabled" /><?php _e( 'Fixed date', 'woocommerce-exporter' ); ?></label>
						<div style="margin-top:0.2em;">
							<input type="text" size="10" maxlength="10" class="text datepicker" /> to <input type="text" size="10" maxlength="10" class="text datepicker" /><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span>
						</div>
					</li>
				</ul>
				<p class="description"><?php _e( 'Filter the dates of Orders to be included in the export. If manually selecting dates ensure the Fixed date radio field is checked, likewise for variable dates. Default is to include all Orders made.', 'woocommerce-exporter' ); ?></p>
				<hr />
			</li>

			<li class="export-options order-options">
				<p class="label"><?php _e( 'Order status', 'woocommerce-exporter' ); ?></p>
				<select data-placeholder="<?php _e( 'Choose a Order Status...', 'woocommerce-exporter' ); ?>" name="order_filter_status[]" multiple class="chzn-select" style="width:95%;">
					<option value="" selected="selected"><?php _e( 'All', 'woocommerce-exporter' ); ?></option>
<?php if( !empty( $order_statuses ) ) { ?>
	<?php foreach( $order_statuses as $order_status ) { ?>
					<option value="<?php echo $order_status->name; ?>" disabled="disabled"><?php echo ucfirst( $order_status->name ); ?></option>
	<?php } ?>
<?php } ?>
				</select>
				<span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span>
				<p class="description"><?php _e( 'Select the Order Status you want to filter exported Orders by. Default is to include all Order Status options.', 'woocommerce-exporter' ); ?></p>
				<hr />
			</li>

			<li class="export-options order-options">
				<p class="label"><?php _e( 'Payment gateway', 'woocommerce-exporter' ); ?></p>
				<select data-placeholder="<?php _e( 'Choose a Payment Gateway...', 'woocommerce-exporter' ); ?>" name="order_filter_payment[]" multiple class="chzn-select" style="width:95%;">
					<option value="" selected="selected"><?php _e( 'All', 'woocommerce-exporter' ); ?></option>
				</select>
				<span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span>
				<p class="description"><?php _e( 'Select the Payment Gateways you want to filter exported Orders by. Default is to include all Payment Gateways.', 'woocommerce-exporter' ); ?></p>
				<hr />
			</li>

			<li class="export-options order-options">
				<p class="label"><?php _e( 'Shipping method', 'woocommerce-exporter' ); ?></p>
				<select data-placeholder="<?php _e( 'Choose a Shipping Method...', 'woocommerce-exporter' ); ?>" name="order_filter_shipping[]" multiple class="chzn-select" style="width:95%;">
					<option value="" selected="selected"><?php _e( 'All', 'woocommerce-exporter' ); ?></option>
				</select>
				<span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span>
				<p class="description"><?php _e( 'Select the Shipping Methods you want to filter exported Orders by. Default is to include all Shipping Methods.', 'woocommerce-exporter' ); ?></p>
				<hr />
			</li>

			<li class="export-options order-options">
				<p class="label"><?php _e( 'Billing country', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></p>
				<select data-placeholder="<?php _e( 'Choose a Billing Country...', 'woocommerce-exporter' ); ?>" name="order_filter_billing_country[]" multiple class="chzn-select" style="width:95%;">
					<option value="" selected="selected"><?php _e( 'All', 'woocommerce-exporter' ); ?></option>
				</select>
				<p class="description"><?php _e( 'Filter Orders by Billing Country to be included in the export. Default is to include all Countries.', 'woocommerce-exporter' ); ?></p>
				<hr />
			</li>

			<li class="export-options order-options">
				<p class="label"><?php _e( 'Shipping country', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></p>
				<select data-placeholder="<?php _e( 'Choose a Shipping Country...', 'woocommerce-exporter' ); ?>" id="order_filter_shipping_country" name="order_filter_shipping_country" class="chzn-select">
					<option value="" selected="selected"><?php _e( 'All', 'woocommerce-exporter' ); ?></option>
				</select>
				<p class="description"><?php _e( 'Filter Orders by Shipping Country to be included in the export. Default is to include all Countries.', 'woocommerce-exporter' ); ?></p>
			</li>

			<li class="export-options category-options tag-options brand-options customer-options user-options coupon-options subscription-options product_vendor-options commission-options shipping_class-options">
				<p><?php _e( 'No export filter options are available for this export type.', 'woocommerce-exporter' ); ?></p>
			</li>

		</ul>
	</td>
</tr>

<tr>
	<th>
		<label><?php _e( 'Scheduling', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<p><?php _e( 'How often do you want the export to run?', 'woocommerce-exporter' ); ?></p>
		<ul>
			<li>
				<label><input type="radio" name="auto_schedule" value="custom" disabled="disabled" /> <?php _e( 'Once every ', 'woocommerce-exporter' ); ?></label>
				<input name="auto_interval" type="text" id="auto_interval" value="<?php echo esc_attr( $auto_interval ); ?>" size="6" maxlength="6" class="text" disabled="disabled" />
				<?php _e( 'minutes', 'woocommerce-exporter' ); ?>
				<span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span>
			</li>
			<li><label><input type="radio" name="auto_schedule" value="daily" disabled="disabled" /> <?php _e( 'Daily', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
			<li><label><input type="radio" name="auto_schedule" value="weekly" disabled="disabled" /> <?php _e( 'Weekly', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
			<li><label><input type="radio" name="auto_schedule" value="monthly" disabled="disabled" /> <?php _e( 'Monthly', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
			<li><label><input type="radio" name="auto_schedule" value="one-time" disabled="disabled" /> <?php _e( 'One time', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
		</ul>
		<p class="description"><?php _e( 'Choose how often Store Exporter Deluxe generates new exports. Default is every 1440 minutes (once every 24 hours).', 'woocommerce-exporter' ); ?></p>
		<hr />
		<p><?php _e( 'When do you want scheduled exports to start?', 'woocommerce-exporter' ); ?></p>
		<ul>
			<li><label><input type="radio" name="auto_commence" value="now" disabled="disabled" /><?php _e( 'From now', 'woocommerce-exporter' ); ?></label><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
			<li><label><input type="radio" name="auto_commence" value="future" disabled="disabled" /><?php _e( 'From the following', 'woocommerce-exporter' ); ?></label>: <input type="text" name="auto_commence_date" size="20" maxlength="20" class="text datetimepicker" value="<?php echo $auto_commence_date; ?>" /><!--, <?php _e( 'at this time', 'woocommerce-exporter' ); ?>: <input type="text" name="auto_interval_time" size="10" maxlength="10" class="text timepicker" />--><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></li>
		</ul>
	</td>
</tr>

<tr>
	<th>
		<label><?php _e( 'Export format', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<ul style="margin-top:0.2em;">
			<li><label><input type="radio" name="auto_format" value="csv" disabled="disabled" /> <?php _e( 'CSV', 'woocommerce-exporter' ); ?> <span class="description"><?php _e( '(Comma Separated Values)', 'woocommerce-exporter' ); ?> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="radio" name="auto_format" value="xml" disabled="disabled" /> <?php _e( 'XML', 'woocommerce-exporter' ); ?> <span class="description"><?php _e( '(EXtensible Markup Language)', 'woocommerce-exporter' ); ?> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="radio" name="auto_format" value="xls" disabled="disabled" /> <?php _e( 'Excel (XLS)', 'woocommerce-exporter' ); ?> <span class="description"><?php _e( '(Excel 97-2003)', 'woocommerce-exporter' ); ?> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="radio" name="auto_format" value="xlsx" disabled="disabled" /> <?php _e( 'Excel (XLSX)', 'woocommerce-exporter' ); ?> <span class="description"><?php _e( '(Excel 2007-2013)', 'woocommerce-exporter' ); ?> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
		</ul>
		<p class="description"><?php _e( 'Adjust the export format to generate different export file formats. Default is CSV.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="auto_method"><?php _e( 'Export method', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<select id="auto_method" name="auto_method">
			<option value="archive"><?php _e( 'Archive to WordPress Media', 'woocommerce-exporter' ); ?></option>
			<option value="email"><?php _e( 'Send as e-mail', 'woocommerce-exporter' ); ?></option>
			<option value="post"><?php _e( 'POST to remote URL', 'woocommerce-exporter' ); ?></option>
			<option value="ftp"><?php _e( 'Upload to remote FTP', 'woocommerce-exporter' ); ?></option>
		</select>
		<span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span>
		<p class="description"><?php _e( 'Choose what Store Exporter Deluxe does with the generated export. Default is to archive the export to the WordPress Media for archival purposes.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<tr class="auto_method_options">
	<th>
		<label><?php _e( 'Export method options', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<ul>

			<li class="export-options email-options">
				<p>
					<label for="email_to"><?php _e( 'Default e-mail recipient', 'woocommerce-exporter' ); ?></label><br />
					<input name="email_to" type="text" id="email_to" value="<?php echo esc_attr( $email_to ); ?>" class="regular-text code" disabled="disabled" /><br /><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span>
				</p>
				<p class="description"><?php _e( 'Set the default recipient of scheduled export e-mails, multiple recipients can be added using the <code><attr title="comma">,</attr></code> separator. This option can be overriden via CRON using the <code>to</code> argument.<br />Default is the Blog Administrator e-mail address set on the WordPress &raquo; Settings screen.', 'woocommerce-exporter' ); ?></p>

				<p>
					<label for="email_subject"><?php _e( 'Default e-mail subject', 'woocommerce-exporter' ); ?></label><br />
					<input name="email_subject" type="text" id="email_subject" value="<?php echo esc_attr( $email_subject ); ?>" class="large-text code" disabled="disabled" /><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span>
				</p>
				<p class="description"><?php _e( 'Set the default subject of scheduled export e-mails, can be overriden via CRON using the <code>subject</code> argument. Tags can be used: <code>%store_name%</code>, <code>%export_type%</code>, <code>%export_filename%</code>.', 'woocommerce-exporter' ); ?></p>
			</li>

			<li class="export-options post-options">
				<p>
					<label for="post_to"><?php _e( 'Default remote POST URL', 'woocommerce-exporter' ); ?></label><br />
					<input name="post_to" type="text" id="post_to" value="<?php echo esc_url( $post_to ); ?>" class="large-text code" disabled="disabled" /><br /><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span>
				</p>
				<p class="description"><?php printf( __( 'Set the default remote POST address for scheduled exports, can be overriden via CRON using the <code>to</code> argument. Default is empty. See our <a href="%s" target="_blank">Usage</a> document for more information on Default remote POST URL.', 'woocommerce-exporter' ), $troubleshooting_url ); ?></p>
			</li>

			<li class="export-options ftp-options">
				<label for="ftp_method_host"><?php _e( 'Host', 'woocommerce-exporter' ); ?>:</label> <input type="text" id="ftp_method_host" name="ftp_method_host" size="15" class="regular-text code" value="<?php echo sanitize_text_field( $ftp_method_host ); ?>" disabled="disabled" />&nbsp;
				<label for="ftp_method_port" style="width:auto;"><?php _e( 'Port', 'woocommerce-exporter' ); ?>:</label> <input type="text" id="ftp_method_port" name="ftp_method_port" size="5" class="short-text code" value="<?php echo sanitize_text_field( $ftp_method_port ); ?>" disabled="disabled" maxlength="5" /><br />
				<label for="ftp_method_protocol"><?php _e( 'Protocol', 'woocommerce-exporter' ); ?></label>
				<select name="ftp_method_protocol">
					<option><?php _e( 'FTP - File Transfer Protocol', 'woocommerce-exporter' ); ?></option>
					<option disabled="disabled"><?php _e( 'SFTP - SSH File Transfer Protocol', 'woocommerce-exporter' ); ?></option>
				</select><br />
				<label for="ftp_method_user"><?php _e( 'Username', 'woocommerce-exporter' ); ?>:</label> <input type="text" id="ftp_method_user" name="ftp_method_user" size="15" class="regular-text code" value="<?php echo sanitize_text_field( $ftp_method_user ); ?>" disabled="disabled" /><br />
				<label for="ftp_method_pass"><?php _e( 'Password', 'woocommerce-exporter' ); ?>:</label> <input type="password" id="ftp_method_pass" name="ftp_method_pass" size="15" class="regular-text code" value="" disabled="disabled" /><?php if( !empty( $ftp_method_pass ) ) { echo ' ' . __( '(password is saved)', 'woocommerce-exporter' ); } ?><br />
				<label for="ftp_method_file_path"><?php _e( 'File path', 'woocommerce-exporter' ); ?>:</label> <input type="text" id="ftp_method_file_path" name="ftp_method_path" size="25" class="regular-text code" value="<?php echo sanitize_text_field( $ftp_method_path ); ?>" disabled="disabled" /><br />
				<label for="ftp_method_filename"><?php _e( 'Fixed filename', 'woocommerce-exporter' ); ?>:</label> <input type="text" id="ftp_method_filename" name="ftp_method_filename" size="25" class="regular-text code" value="<?php echo sanitize_text_field( $ftp_method_filename ); ?>" disabled="disabled" /><br />
				<label for="ftp_method_passive"><?php _e( 'Transfer mode', 'woocommerce-exporter' ); ?>:</label> 
				<select id="ftp_method_passive" name="ftp_method_passive">
					<option value="auto"><?php _e( 'Auto', 'woocommerce-exporter' ); ?></option>
					<option value="active" disabled="disabled"><?php _e( 'Active', 'woocommerce-exporter' ); ?></option>
					<option value="passive" disabled="disabled"><?php _e( 'Passive', 'woocommerce-exporter' ); ?></option>
				</select><br />
				<label for="ftp_method_timeout"><?php _e( 'Timeout', 'woocommerce-exporter' ); ?>:</label> <input type="text" id="ftp_method_timeout" name="ftp_method_timeout" size="5" class="short-text code" value="<?php echo sanitize_text_field( $ftp_method_timeout ); ?>" disabled="disabled" /><br />
				<p class="description"><?php _e( 'Enter the FTP host (minus <code>ftp://</code>), login details and path of where to save the export file, do not provide the filename, the export filename can be set on General Settings above. For file path example: <code>wp-content/uploads/exports/</code>', 'woocommerce-exporter' ); ?></p>
			</li>

			<li class="export-options archive-options">
				<p><?php _e( 'No export method options are available for this export method.', 'woocommerce-exporter' ); ?></p>
			</li>

		</ul>
	</td>
</tr>
<tr>
	<th>
		<label for="scheduled_fields"><?php _e( 'Export fields', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<ul style="margin-top:0.2em;">
			<li><label><input type="radio" id="scheduled_fields" name="scheduled_fields" value="all"<?php checked( $scheduled_fields, 'all' ); ?> /> <?php _e( 'Include all Export Fields for the requested Export Type', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="radio" name="scheduled_fields" value="saved"<?php checked( $scheduled_fields, 'saved' ); ?> disabled="disabled" /> <?php _e( 'Use the saved Export Fields preference set on the Export screen for the requested Export Type', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
		</ul>
		<p class="description"><?php _e( 'Control whether all known export fields are included or only checked fields from the Export Fields section on the Export screen for each Export Type. Default is to include all export fields.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>

<tr id="cron-exports">
	<td colspan="2" style="padding:0;">
		<hr />
		<h3><div class="dashicons dashicons-clock"></div>&nbsp;<?php _e( 'CRON Exports', 'woocommerce-exporter' ); ?></h3>
		<p class="description"><?php printf( __( 'Store Exporter Deluxe supports exporting via a command line request. For sample CRON requests and supported arguments consult our <a href="%s" target="_blank">online documentation</a>.', 'woocommerce-exporter' ), $troubleshooting_url ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="enable_cron"><?php _e( 'Enable CRON', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<select id="enable_cron" name="enable_cron">
			<option value="1" disabled="disabled"><?php _e( 'Yes', 'woocommerce-exporter' ); ?></option>
			<option value="0" selected="selected"><?php _e( 'No', 'woocommerce-exporter' ); ?></option>
		</select>
		<p class="description"><?php _e( 'Enabling CRON allows developers to schedule automated exports and connect with Store Exporter Deluxe remotely.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="secret_key"><?php _e( 'Export secret key', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<input name="secret_key" type="text" id="secret_key" value="<?php echo esc_attr( $secret_key ); ?>" class="large-text code" disabled="disabled" /><br /><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span>
		<p class="description"><?php _e( 'This secret key (can be left empty to allow unrestricted access) limits access to authorised developers who provide a matching key when working with Store Exporter Deluxe.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="cron_fields"><?php _e( 'Export fields', 'woocommerce-exporter' ); ?></label>
	</th>
	<td>
		<ul style="margin-top:0.2em;">
			<li><label><input type="radio" id="cron_fields" name="cron_fields" value="all"<?php checked( $cron_fields, 'all' ); ?> /> <?php _e( 'Include all Export Fields for the requested Export Type', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="radio" name="cron_fields" value="saved"<?php checked( $cron_fields, 'saved' ); ?> disabled="disabled" /> <?php _e( 'Use the saved Export Fields preference set on the Export screen for the requested Export Type', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
		</ul>
		<p class="description"><?php _e( 'Control whether all known export fields are included or only checked fields from the Export Fields section on the Export screen for each Export Type. Default is to include all export fields.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<!-- #cron-exports -->

<tr id="orders-screen">
	<td colspan="2" style="padding:0;">
		<hr />
		<h3><div class="dashicons dashicons-admin-settings"></div>&nbsp;<?php _e( 'Orders Screen', 'woocommerce-exporter' ); ?></h3>
	</td>
</tr>
<tr>
	<th>
		<?php _e( 'Actions display', 'woocommerce-exporter' ); ?>
	</th>
	<td>
		<ul>
			<li><label><input type="checkbox" name="order_actions_csv" value="1"<?php checked( $order_actions_csv ); ?> /> <?php _e( 'Export to CSV', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="order_actions_tsv" value="1"<?php checked( $order_actions_tsv ); ?> /> <?php _e( 'Export to TSV', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="order_actions_xls" value="1"<?php checked( $order_actions_xls ); ?> /> <?php _e( 'Export to XLS', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="order_actions_xlsx" value="1"<?php checked( $order_actions_xlsx ); ?> /> <?php _e( 'Export to XLSX', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="order_actions_xml" value="1"<?php checked( $order_actions_xml ); ?> /> <?php _e( 'Export to XML', 'woocommerce-exporter' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'woocommerce-exporter' ), $woo_cd_link ); ?></span></label></li>
		</ul>
		<p class="description"><?php _e( 'Control the visibility of different Order actions on the WooCommerce &raquo; Orders screen.', 'woocommerce-exporter' ); ?></p>
	</td>
</tr>
<?php
	ob_end_flush();

}

function woo_ce_export_settings_save() {

	// Strip file extension from export filename
	$export_filename = strip_tags( $_POST['export_filename'] );
	woo_ce_update_option( 'export_filename', $export_filename );
	woo_ce_update_option( 'delete_file', absint( $_POST['delete_file'] ) );
	woo_ce_update_option( 'encoding', sanitize_text_field( $_POST['encoding'] ) );
	woo_ce_update_option( 'delimiter', sanitize_text_field( $_POST['delimiter'] ) );
	woo_ce_update_option( 'category_separator', sanitize_text_field( $_POST['category_separator'] ) );
	woo_ce_update_option( 'bom', absint( $_POST['bom'] ) );
	woo_ce_update_option( 'escape_formatting', sanitize_text_field( $_POST['escape_formatting'] ) );
	if( $_POST['date_format'] == 'custom' && !empty( $_POST['date_format_custom'] ) ) {
		woo_ce_update_option( 'date_format', sanitize_text_field( $_POST['date_format_custom'] ) );
	} else {
		woo_ce_update_option( 'date_format', sanitize_text_field( $_POST['date_format'] ) );
	}

	$message = __( 'Changes have been saved.', 'woocommerce-exporter' );
	woo_ce_admin_notice( $message );

}
?>