<?php
/**
 * This function, hooked to display on the category/tag edit forms,
 * adds new fields to select a sidebar. The variables $tag and $taxonomy
 * are passed via the hook so that we can use them.
 */
function ss_term_edit_init() {

	$taxonomies = ss_get_taxonomies();

	if ( ! empty( $taxonomies ) && is_admin() && is_array( $taxonomies ) ) {

		foreach( $taxonomies as $tax )
			add_action( "{$tax}_edit_form", 'ss_term_sidebar', 9, 2 );

	}

}

function ss_term_sidebar($tag, $taxonomy) {

	//* Merge Defaults to prevent notices
	$tag->meta = wp_parse_args( $tag->meta, array( '_ss_sidebar' => '', '_ss_sidebar_alt' => '', '_ss_sidebar_header_right' => '' ) );

	//* Pull custom sidebars
	$_sidebars = stripslashes_deep( get_option( SS_SETTINGS_FIELD ) );

?>

	<h3><?php _e( 'Sidebar Options', 'ss' ); ?></h3>
	<table class="form-table">

	<tr class="form-field">
		<th scope="row" valign="top"><label for="genesis-meta[_ss_sidebar]"><?php _e( 'Primary Sidebar', 'ss' ); ?></label></th>
		<td>
			<select name="genesis-meta[_ss_sidebar]" id="genesis-meta[_ss_sidebar]" style="padding-right: 10px;">
				<option value=""><?php _e( 'Default', 'ss' ); ?></option>
				<?php
				foreach ( (array) $_sidebars as $id => $info ) {
					printf( '<option value="%s" %s>%s</option>', esc_html( $id ), selected( $id, $tag->meta['_ss_sidebar'] , false), esc_html( $info['name'] ) );
				}
				?>
			</select>
		</td>
	</tr>
<?php
	//* don't show the option if there are no 3 column layouts registered
	if ( ss_has_3_column_layouts() ) {
?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="genesis-meta[_ss_sidebar_alt]"><?php _e( 'Secondary Sidebar', 'ss' ); ?></label></th>
		<td>
			<select name="genesis-meta[_ss_sidebar_alt]" id="genesis-meta[_ss_sidebar_alt]" style="padding-right: 10px;">
				<option value=""><?php _e( 'Default', 'ss' ); ?></option>
				<?php
				foreach ( (array) $_sidebars as $id => $info ) {
					printf( '<option value="%s" %s>%s</option>', esc_html( $id ), selected( $id, $tag->meta['_ss_sidebar_alt'] , false), esc_html( $info['name'] ) );
				}
				?>
			</select>
		</td>
	</tr>
<?php
	}
?>
<?php
	//* don't show the option if header right is not registered
	if ( is_active_sidebar( 'header-right' ) ) {
?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="genesis-meta[_ss_sidebar_header_right]"><?php _e( 'Header Right Sidebar', 'ss' ); ?></label></th>
		<td>
			<select name="genesis-meta[_ss_sidebar_header_right]" id="genesis-meta[_ss_sidebar_header_right]" style="padding-right: 10px;">
				<option value=""><?php _e( 'Default', 'ss' ); ?></option>
				<?php
				foreach ( (array) $_sidebars as $id => $info ) {
					printf( '<option value="%s" %s>%s</option>', esc_html( $id ), selected( $id, $tag->meta['_ss_sidebar_header_right'] , false), esc_html( $info['name'] ) );
				}
				?>
			</select>
		</td>
	</tr>
<?php
	}
?>
	</table>

<?php
}
