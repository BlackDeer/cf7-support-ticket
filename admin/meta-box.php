<div>
    <label>List of Forms</label>
    <ul>
        <?php
            $posts = get_posts( array(
                'post_type'     => 'wpcf7_contact_form',
                'numberposts'   => -1
            ));
            foreach ( $posts as $p ) {
                echo '<li>' . $p->ID . ' ' . $p->post_title . '</li>';
        } ?>
    </ul>

    <br>

    <label for="department">Department</label>
    <select name="department">
    	<?php 
            $option_values = array( 'Basement', 'Elevator', 'Heat' );
    		foreach ($option_values as $key => $value) 
    		{
    			if($value == get_post_meta($object->ID, 'department', true))
    			{ 
    			?>
    				<option selected><?php echo $value; ?></option>
    			<?php
    			}else{
    			?>
    				<option><?php echo $value; ?></option>
    			<?php
    			}
    		}
    	?>
    </select>

    <br>

    <label for="importance">Importance</label>
    <select name="importance">
        <?php 
            $option_values = array( 'High', 'Normal', 'Low');

            foreach($option_values as $key => $value) 
            {
                if($value == get_post_meta($object->ID, 'importance', true))
                {
                    ?>
                        <option selected><?php echo $value; ?></option>
                    <?php    
                }
                else
                {
                    ?>
                        <option><?php echo $value; ?></option>
                    <?php
                }
            }
        ?>
    </select>

    <br>

    <label for="assigned-to">Assigned To</label>
    <select name="assigned-to">
        <?php //role list
            $managers = get_users( array(
                'role'      => 'jyp_ticket_manager',
                'order_by'  => 'user_nicename',
                'order'     => 'ASC', 
            ) );

            foreach( $managers as $user ) 
            {
                if($user == get_post_meta($object->ID, 'assigned_to', true))
                {
                    ?>
                        <option selected><?php echo $user->display_name; ?></option>
                    <?php    
                }
                else
                {
                    ?>
                        <option><?php echo $user->display_name; ?></option>
                    <?php
                }
            }
        ?>
    </select>

    <br>

    <label for="building">Building #</label>
    <input type="text" name="building" id="building" placeholder=" <?php 
        $value = get_post_meta($object->ID, 'building', true); echo $value; ?>" />

    <br>

    <label for="unit">Unit #</label>
    <input type="text" name="unit" id="unit" placeholder="<?php 
        $value = get_post_meta($object->ID, 'unit', true); echo $value; ?>" />

    <br>


</div>