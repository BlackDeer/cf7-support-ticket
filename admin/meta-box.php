<div>

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

            foreach( $managers as $manager ) 
            {
                if($manager == get_post_meta($object->ID, 'assigned_to', true))
                {
                    ?>
                        <option selected><?php echo $manager->display_name; ?></option>
                    <?php    
                }
                else
                {
                    ?>
                        <option><?php echo $manager->display_name; ?></option>
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

    <label for="status">Resolved</label>
    <input type="checkbox" name="status" id="status" 
        <?php if( get_post_meta($object->ID, 'status', true) == 1 ){ echo 'checked'; } ?> />

</div>