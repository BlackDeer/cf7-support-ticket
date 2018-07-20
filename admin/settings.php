<div class="wrap">
	<h1>Tickets Settings</h1>
	<form method="POST">
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

				            foreach( $managers as $manager ){ 
				            	echo '<li>' . $manager->display_name . '</li>';
							}
						?>
					</ul>
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<?php wp_nonce_field( 'jyp_tickets_settings_nonce' ); ?>
		<input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
	</p>
	</form>
</div>	