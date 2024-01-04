<?php
/**
 * Utils for the plugin
 *
 * @package ContactPlugin
 */

/**
 * Get plugin option form Carbon Fields
 *
 * @param string $name Name of the option.
 * @return mixed|null
 */
function get_plugin_option( string $name ): mixed {
	return carbon_get_theme_option( $name );
}
