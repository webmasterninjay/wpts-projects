<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function wpts_projects_add_meta_boxes( $post ){
	add_meta_box( 'wpts_projects_meta_box', __( 'Project Details', 'wpts-projects' ), 'wpts_projects_build_meta_box', 'wpts_projects', 'normal', 'high' );
}
add_action( 'add_meta_boxes_wpts_projects', 'wpts_projects_add_meta_boxes' );

function wpts_projects_build_meta_box( $post ){
  // form nonce
  wp_nonce_field( basename( __FILE__ ), 'wpts_projects_meta_box_nonce' );
  // check for current value of fields
  $current_project_owner      = get_post_meta( $post->ID, '_wpts_projects_project_owner', true );
  $current_project_feedback   = get_post_meta( $post->ID, '_wpts_projects_project_feedback', true );
	$current_project_featured   = get_post_meta( $post->ID, '_wpts_projects_project_featured', true );

	if ($current_project_featured == '1') {
		$project_is_featured = '1';
	} else {
		$project_is_featured = '0';
	}

  ?>
  <p>
    <label for="_wpts_projects_project_owner"><strong><?php echo __( 'Project Owner', 'wpts-projects' ); ?></strong></label><br />
    <input class="widefat" type="text" name="_wpts_projects_project_owner" value="<?php echo $current_project_owner; ?>" />
  </p>
	<p>
    <label for="_wpts_projects_project_featured"><strong><?php echo __( 'Project is Featured?', 'wpts-projects' ); ?></strong> <em>(<?php echo __( 'Project will show up on homepage Featured Project section', 'wpts-projects' ); ?>)</em></label><br>
		<input type="radio" name="_wpts_projects_project_featured" value="1" <?php checked( $project_is_featured, '1' ); ?> /> Yes
		<input type="radio" name="_wpts_projects_project_featured" value="0" <?php checked( $project_is_featured, '0' ); ?> style="margin-left: 20px" /> No
  </p>
  <p>
    <label for="_wpts_projects_project_feedback"><strong><?php echo __( 'Project Feedback', 'wpts-projects' ); ?></strong></label><br />
    <?php
    $current_project_feedback_id = '_wpts_projects_project_feedback';
    $args = array(
      'textarea_name'=>'_wpts_projects_project_feedback'
    );
    wp_editor( $current_project_feedback, $current_project_feedback_id, $args );
    ?>
  </p>
  <?php
}

function wpts_projects_save_meta_boxes_data( $post_id ){
	// check the nonce
  if ( !isset( $_POST['wpts_projects_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wpts_projects_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}
  // return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
  // Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	// featured
	if ( isset( $_REQUEST['_wpts_projects_project_featured'] ) ) {
		update_post_meta( $post_id, '_wpts_projects_project_featured', sanitize_text_field( $_POST['_wpts_projects_project_featured'] ) );
	}
  // If fields is change/set, update
  if ( isset( $_REQUEST['_wpts_projects_project_owner'] ) ) {
		update_post_meta( $post_id, '_wpts_projects_project_owner', sanitize_text_field( $_POST['_wpts_projects_project_owner'] ) );
	}
  if ( isset( $_REQUEST['_wpts_projects_project_feedback'] ) ) {
		update_post_meta( $post_id, '_wpts_projects_project_feedback', esc_textarea( $_POST['_wpts_projects_project_feedback'] ) );
	}
}
add_action( 'save_post_wpts_projects', 'wpts_projects_save_meta_boxes_data', 10, 2 );
