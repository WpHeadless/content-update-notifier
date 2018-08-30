<?php

if (!get_option( 'cun_enabled' )) return;

const CUN_EXCLUDED_POST_TYPES = [
  'revision',
  'media'
];

const CUN_API_KEY_HEADER = 'x-api-key';

add_action( 'post_updated', 'cun_post_updated', 10, 3 );

function cun_post_updated( $post_id, $post_after, $post_before ) {
  if (
    in_array( $post_before->post_status, [ 'draft', 'trash' ] ) &&
    in_array( $post_after->post_status, [ 'draft', 'trash' ] )
  ) return;

  if ( in_array( $post_after->post_type, CUN_EXCLUDED_POST_TYPES ) ) return;
  cun_notify_endpoint();
}

function cun_notify_endpoint() {
  $api_endpoint = get_option( 'cun_api_endpoint' );
  $api_key = get_option( 'cun_api_key' );

  $ch = curl_init( $api_endpoint );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  if ( $api_key ) {
    curl_setopt( $ch, CURLOPT_HTTPHEADER, [ CUN_API_KEY_HEADER .  ': ' . $api_key ]);
  }
  curl_exec( $ch );
  curl_close( $ch );
}
