<?php
/*
Theme Name:     Etch: _s Child
Theme URI:      http://www.etchsoftware.com/
Description:    Child theme for common Admin-UX & plugin helpers & customizations
Author:         mbijon
Author URI:     http://www.mbijon.com/
Template:       _s
Version:        1.0
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: _s
Domain Path: /languages/
*/


/*
 * Gravity Forms Placeholders
 *
 * @author not me: Sadly, didn't track where this is from
 *     ( Please msg @geekcode if you know & will credit )
 * 
 */
function placeholder_gform_standard_settings($position, $form_id) {

	// Create settings on position 25 (right after Field Label)
	
	if($position == 25){
	?>
			
	<li class="admin_label_setting field_setting" style="display: list-item; ">
	<label for="field_placeholder">Placeholder Text
	
	<!-- Tooltip to help users understand what this field does -->
	<a href="javascript:void(0);" class="tooltip tooltip_form_field_placeholder" tooltip="&lt;h6&gt;Placeholder&lt;/h6&gt;Enter the placeholder/default text for this field.">(?)</a>
				
	</label>
			
	<input type="text" id="field_placeholder" class="fieldwidth-3" size="35" onkeyup="SetFieldProperty('placeholder', this.value);">
			
	</li>
	<?php
	}
}
add_action( 'gform_field_standard_settings', 'placeholder_gform_standard_settings', 10, 2 );


/*
 * Gravity Forms Placeholders
 *
 * Load admin-only javascript for the field
 */
function placeholder_gform_editor_js() {
?>
	<script>
	//binding to the load field settings event to initialize the checkbox
	jQuery(document).bind("gform_load_field_settings", function(event, field, form){
	jQuery("#field_placeholder").val(field["placeholder"]);
	});
	</script>
	
<?php
}
add_action( 'gform_editor_js', 'placeholder_gform_editor_js' );


/*
 * Gravity Forms Placeholders:
 * 
 * Use jQuery to read    
 */
function placeholder_gform_enqueue_scripts($form, $is_ajax=false) {
?>
	<script>
	
	jQuery(function(){
	<?php
	
	/* Go through each one of the form fields */
	
	foreach($form['fields'] as $i=>$field){
	
	/* Check if the field has an assigned placeholder */
				
	if(isset($field['placeholder']) && !empty($field['placeholder'])){
					
	/* If a placeholder text exists, inject it as a new property to the field using jQuery */
					
	?>
					
	jQuery('#input_<?php echo $form['id']?>_<?php echo $field['id']?>').attr('placeholder','<?php echo $field['placeholder']?>');
					
	<?php
	}
	}
	?>
	});
	</script>
<?php
}
add_action( 'gform_enqueue_scripts', 'placeholder_gform_enqueue_scripts', 10, 2 );
