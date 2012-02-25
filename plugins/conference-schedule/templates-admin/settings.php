<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>

<div class="wrap" id="<?php echo esc_attr( $this->name ); ?>-options">

	<div id="icon-options-general" class="icon32"><br /></div>
	<h2><?php _e( 'Conference Settings', $this->name ); ?></h2>
	
	<?php if ( $theme_copy ) : ?>

		<h3><?php _e( 'Theme', $this->name ); ?></h3>
	
		<form method="post" action="">
			<?php wp_nonce_field( 'copy_theme', '_cs_copy_theme' ); ?>

			<p><?php printf( __( 'Copy the TwentyTen Conference child theme into my theme directory: %s', $this->name ), $theme_copy_button ); ?></p>
			
		</form>

		<h3><?php _e( 'Settings', $this->name ); ?></h3>

	<?php elseif ( $theme_manual_copy ) : ?>

		<h3><?php _e( 'Theme', $this->name ); ?></h3>
		
		<p><?php printf( __( 'You can manually copy the TwentyTen Conference from the %s dir into your WP themes folder to use or build upon this theme.', $this->name ), '<kbd><em>this plugin directory</em>/themes/<strong>twentyten-conference</strong></kbd>' ); ?></p>

		<h3><?php _e( 'Settings', $this->name ); ?></h3>
		
	<?php elseif ( $theme_copied ) : ?>

		<h3><?php _e( 'Theme', $this->name ); ?></h3>

		<p><?php _e( 'You have installed the TwentyTen Conference child theme.', $this->name ); ?></p>

		<h3><?php _e( 'Settings', $this->name ); ?></h3>
		
	<?php endif; ?>
	
	<form method="post" action="options.php">
		<?php settings_fields( $this->name ); ?>

		<table class="form-table">
			<?php // @TODO: Show dates above in human readable format, and ask "is this right?" ?>
			<tr valign="top"><th scope="row"><?php _e( 'Conference days', $this->name ); ?></th>
				<td>
					<input type="text" name="<?php echo esc_attr( $this->name ); ?>[days]" value="<?php echo esc_attr( $options['days'] ); ?>" class="regular-text" /><br />
					<span class="description"><?php _e( 'Please enter the days over which your conference runs, separating multiple days with a comma (<kbd>,</kbd>) and using this format: <kbd>YYYY-MM-DD,YYYY-MM-DD</kbd>', $this->name ) ?></span>
				</td>
			</tr>
			<tr valign="top"><th scope="row"><?php _e( 'Time Format', $this->name ); ?></th>
				<td>
					<input type="text" name="<?php echo esc_attr( $this->name ); ?>[time_format]" value="<?php echo esc_attr( $options['time_format'] ); ?>" class="small-text" /> <span class="example"><?php echo esc_html( date( $options['time_format'] ) ); ?></span><br />
					<span class="description"><?php _e( 'This is the date format used for schedule times which are not exactly on the hour.', $this->name ) ?></span>
				</td>
			</tr>
			<tr valign="top"><th scope="row"><?php _e( 'Short Time Format', $this->name ); ?></th>
				<td>
					<input type="text" name="<?php echo esc_attr( $this->name ); ?>[short_time_format]" value="<?php echo esc_attr( $options['short_time_format'] ); ?>" class="small-text" /> <span class="example"><?php echo esc_html( date( $options['short_time_format'] ) ); ?></span><br />
					<span class="description"><?php _e( 'This is the date format used for schedule times which <strong>are</strong> exactly on the hour.', $this->name ) ?></span><br />
					<a href="http://codex.wordpress.org/Formatting_Date_and_Time">Documentation on date and time formatting</a>
				</td>
			</tr>
		</table>

		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>

	</form>
	
</div>


