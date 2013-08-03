<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->helper('form');
$type_array = array(
    'artist' => 'Artist',
    'release' => 'Release',
    'feature' => 'Feature'
);
?>
<?php echo form_open_multipart('util/upload', array('id' => 'image-form')); ?>
    <input name="files" id="files" type="file" />
    <p>
        <input type="submit" value="Submit" class="k-button" />
    </p>
<?php echo form_close(); ?>
<script>
    $(document).ready(function() {
        $("#files").kendoUpload();
    });
</script>
