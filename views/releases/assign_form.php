<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->helper('form');
?>
<?php if ( $change_count > 0 ) echo '<p>Changes made: ' . $change_count . '</p>'; ?>
        <?php echo form_open('releases/assign', array('class' => 'well', 
		'id' => 'release-form')); ?>
	<?php echo form_hidden('user-id', $user_id); ?>
<table class="table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Artist &mdash; Title</th>
            <th>Assign</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($release_list as $id => $item) : ?>
        <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $item; ?></td>
            <td>
                <?php echo form_hidden('release-id[]', $id); ?>
                <?php echo form_dropdown('artist-id' . $id, $artist_select_list, '0'); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
	<?php echo form_submit('assign-submit', 'Submit', 'class="btn"'); ?>
        <?php form_close(); ?>
