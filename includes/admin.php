<?php

add_action( 'admin_init', 'cun_settings_init' );
add_action( 'admin_menu', 'cun_options_page' );

function cun_settings_init() {
  register_setting( 'cun_option_group', 'cun_api_endpoint', 'trim' );
  register_setting( 'cun_option_group', 'cun_api_key', 'trim' );
  register_setting( 'cun_option_group', 'cun_enabled', [ 'type' => 'boolean', 'default' => false ] );

  add_settings_section(
    'cun_settings_section',
    'Settings',
    function () {},
    'cun_options_page'
  );

  add_settings_field(
    'cun_api_endpoint',
    'API Endpoint',
    'cun_api_endpoint_display',
    'cun_options_page',
    'cun_settings_section',
    [
      'label_for' => 'cun_api_endpoint'
    ]
  );

  add_settings_field(
    'cun_api_key',
    'API Key',
    'cun_api_key_display',
    'cun_options_page',
    'cun_settings_section',
    [
      'label_for' => 'cun_api_key'
    ]
  );

  add_settings_field(
    'cun_enabled',
    'Enabled',
    'cun_enabled_display',
    'cun_options_page',
    'cun_settings_section',
    [
      'label_for' => 'cun_enabled'
    ]
  );
}

function cun_api_key_display( $args ) {
  $api_key = get_option( 'cun_api_key' );
  ?>
    <p>
      <input
        type="text"
        style="width: 100%"
        id="<?php echo esc_attr( $args['label_for'] ) ?>"
        name="<?php echo esc_attr( $args['label_for'] ) ?>"
        value="<?php echo esc_attr( $api_key )?>"
      >
    </p>
  <?php
}

function cun_api_endpoint_display( $args ) {
  $api_endpoint = get_option( 'cun_api_endpoint' );
  ?>
    <p>
      <input
        type="text"
        style="width: 100%"
        id="<?php echo esc_attr( $args['label_for'] ) ?>"
        name="<?php echo esc_attr( $args['label_for'] ) ?>"
        value="<?php echo esc_attr( $api_endpoint )?>"
      >
    </p>
  <?php
}

function cun_enabled_display( $args ) {
  $enabled = get_option( 'cun_enabled' );
  ?>
    <p>
      <input
        type="checkbox"
        id="<?php echo esc_attr( $args['label_for'] ) ?>"
        name="<?php echo esc_attr( $args['label_for'] ) ?>"
        <?php echo $enabled ? 'checked' : '' ?>
      >
    </p>
  <?php
}

function cun_options_page_display() {
  if ( ! current_user_can( 'manage_options' ) ) return;

  if ( isset( $_GET['settings-updated'] ) ) {
    add_settings_error( 'cun_messages', 'cun_message', 'Settings Saved', 'updated' );
  }

  settings_errors( 'cun_messages' );

  ?>
    <div class="wrap">
      <h1><?= esc_html( get_admin_page_title() ); ?></h1>
      <form action="options.php" method="post">
        <?php
          settings_fields( 'cun_option_group' );
          do_settings_fields( 'cun_options_page', 'cun_settings_section' );
          submit_button( 'Save Settings' );
        ?>
      </form>
    </div>
  <?php
}

function cun_options_page() {
  add_menu_page(
    'Content update notifier',
    'Update notifier',
    'manage_options',
    'cun_options_page',
    'cun_options_page_display'
  );
}
