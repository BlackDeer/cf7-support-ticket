<div class="wrap">
	<h1>Tickets Settings</h1>
	<form method="POST">
	 <?php
		//settings_fields( 'jyp_tickets_options' );
		wp_nonce_field( 'settings_nonce' );
    ?>
    <table class="form-table">
    	<tbody>
			<tr>
				<th scope="row">
					<label>Choose Form</label>
				</th>
				<td>
					<select name="cf7-form">
						<?php
						    foreach ( $forms as $form ) {
						    	if( $form->post_title == $options ){
						    	?>
						    		<option selected><?php echo $form->post_title; ?></option>
						    	<?php
						    	}else{
						    	?>
						    		<option><?php echo $form->post_title; ?></option>
								<?php
								}	
						    }
						?>

					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label>Ticket Managers</label>					
				</th>
				<td>
					<ul>
						<?php 
				            $managers = get_users( array(
				                'role'      => 'jyp_ticket_manager',
				                'order_by'  => 'user_nicename',
				                'order'     => 'ASC', 
				            ) );

				            foreach( $managers as $user ){ 
				            	echo '<li>' . $user->display_name . '</li>';
							}
						?>
					</ul>
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" class="button-primary" value=" <?php _e('Save Changes') ?>" />
	</p>
	</form>
	<h2><?php var_dump( $options ); ?></h2>
	<?php 
		var_dump($forms);
		// wpcf7_contactform['scanned_from_tags'][0]['type', 'name', 'options'[0]]
	?>
	<h2>Validation</h2>
	<p><?php var_dump($is_valid_nonce); var_dump($can_edit_tickets); ?></p>
</div>	