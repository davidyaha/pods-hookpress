<?php
/*
Plugin Name: Pods-HookPress
Plugin URI:
Description: Pods allows you to add custom content and hooks allows you to add webhooks. Those plugins didn't play together until now :)
Version: 1.0
Author: davidyaha (David Yahalomi)
Author URI: http://github.com/davidyaha
*/

function add_pods_actions($hooks = array()) {
    $pods_actions = array(
        'pods_api_post_save_pod_item'=>array('PODS'),
        'pods_api_post_save_pod_item'=>array('PODS'),
        'pods_api_post_edit_pod_item'=>array('PODS'),
        'pods_api_post_delete_pod_item'=>array('PODS'),
    );

    return array_merge($hooks, $pods_actions);
}
add_filter('hookpress_actions', 'add_pods_actions', 10, 1);

function add_pod_fields($fields = array(), $type) {
    global $wpdb;

    $pod_fields = array();
    if ($type == 'PODS') {
        $post_fields = $wpdb->get_col("show columns from $wpdb->posts");
        $fields = array_merge($fields, $post_fields);

        // TODO get possible fields from pods
        $meta_keys = $wpdb->get_col("select distinct(meta_key) from $wpdb->postmeta");
        $fields = array_merge($fields, $meta_keys);
    }

    return array_merge($fields, $pod_fields);
}
add_filter('hookpress_get_fields', 'add_pod_fields', 10, 2);

function load_pod_data($obj = array(), $webhook_type, $pieces) {
    global $wpdb;

    $pod_data = array();
    if ($webhook_type == 'PODS') {

        $fields = array();

        foreach($pieces['fields'] as $field_name => $field_data) {
            $fields[$field_name] = $field_data['value'];
        }

        $pod = pods($pieces['params']->pod, $pieces['params']->id);
        $post_fileds = array_keys($pieces['object_fields']);

        foreach($post_fileds as $i => $field_name) {
            $pod_data[$field_name] = $pod->display($field_name);
        }

        $pod_data = array_merge($fields, $pod_data);
    }

    return array_merge($obj, $pod_data);
}
add_filter('hookpress_get_data', 'load_pod_data', 10, 3);

/* TODO: Add pre* pods hooks
        'pods_pods_pre_save_pod_item',
        'pods_pods_pre_create_pod_item',
        'pods_pods_pre_edit_pod_item',
        'pods_pods_pre_delete_pod_item',
*/