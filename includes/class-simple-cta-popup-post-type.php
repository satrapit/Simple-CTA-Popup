<?php

/**
 * Register custom post type
 *
 * @link       https://arsamnet.com
 * @since      1.0.0
 *
 * @package    Simple_CTA_Popup
 * @subpackage Simple_CTA_Popup/includes
 */

 /**
 * The post type class.
 *
 * This is used to define post types
 *
 * @since      1.0.0
 * @package    Simple_CTA_Popup
 * @subpackage Simple_CTA_Popup/includes
 * @author     Majid Barkhordari <info@arsamnet.com>
 */

 class Simple_CTA_Popup_Post_Types {

    public function register_simple_cta_popups_post_type() {

        $labels = array(
			'name'                  => _x( 'پاپ‌آپ‌ها', 'Post Type General Name', 'simple-cta-popup' ),
			'singular_name'         => _x( 'Simple CTA Popup', 'Post Type Singular Name', 'simple-cta-popup' ),
			'menu_name'             => __( 'پاپ‌آپ‌ها', 'simple-cta-popup' ),
			'all_items'             => __( 'همه پاپ‌آپ‌ها', 'simple-cta-popup' ),
			'add_new_item'          => __( 'پاپ‌آپ جدید', 'simple-cta-popup' ),
			'add_new'               => __( 'افزودن جدید', 'simple-cta-popup' ),
			'new_item'              => __( 'پاپ‌آپ جدید', 'simple-cta-popup' ),
			'edit_item'             => __( 'ویرایش', 'simple-cta-popup' ),
			'update_item'           => __( 'بروزرسانی', 'simple-cta-popup' ),
			'view_item'             => __( 'نمایش', 'simple-cta-popup' ),
			'view_items'            => __( 'نمایش همه', 'simple-cta-popup' ),
			'search_items'          => __( 'جستجو', 'simple-cta-popup' ),
			'not_found'             => __( 'هیچ پاپ‌آپی وجود ندارد', 'simple-cta-popup' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'simple-cta-popup' ),
			'featured_image'        => __( 'تصویر پاپ‌آپ', 'simple-cta-popup' ),
			'set_featured_image'    => __( 'انتخاب تصویر', 'simple-cta-popup' ),
			'remove_featured_image' => __( 'پاک کردن تصویر', 'simple-cta-popup' ),
			'use_featured_image'    => __( 'Use as featured image', 'simple-cta-popup' ),
			'insert_into_item'      => __( 'Insert into Popup', 'simple-cta-popup' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Popup', 'simple-cta-popup' ),
			'items_list'            => __( 'Popups list', 'simple-cta-popup' ),
			'items_list_navigation' => __( 'Popups list navigation', 'simple-cta-popup' ),
			'filter_items_list'     => __( 'Filter popups list', 'simple-cta-popup' ),
        );
        
        $args = array(
			'label'                 => __( 'Simple CTA Popup', 'simple-cta-popup' ),
			'description'           => __( 'Simple CTA Popup', 'simple-cta-popup' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'thumbnail' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-text-page',
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => false,
			'can_export'            => false,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => false,
			'capability_type'       => 'post',
        );
        
		register_post_type( 'simple_cta_popup', $args );

    }
    
    public function setting_meta_box() {

        add_meta_box(
            'setting_meta_box',
            __( 'تنظیمات پاپ‌آپ', 'simple-cta-popup' ),
            array($this, 'setting_meta_box_callback'),
            'simple_cta_popup',
            'normal',
            'high'
        );

    }

    public function setting_meta_box_callback( $post ) {

        wp_nonce_field( 'url_meta_box', 'url_meta_box_nonce' );
        
        $popup_url = get_post_meta( $post->ID, '_simple_cta_popup_url', true );
        $notification_text = get_post_meta( $post->ID, '_simple_cta_popup_notification_text', true );
        $notification_button = get_post_meta( $post->ID, '_simple_cta_popup_notification_button', true );
        
        echo '
            <div class="setting_box">
                <style scoped>
                    .setting_box {
                        display: grid;
                        grid-template-columns: max-content 1fr;
                        grid-row-gap: 10px;
                        grid-column-gap: 20px;
                    }
                    .setting_field {
                        display: contents;
                    }
                    .setting_field input {
                        width: 30em;
                    }
                    .setting_field label {
                        text-align: left;
                        line-height: 2.2em;
                    }
                </style>
                <p class="meta-options setting_field">
                    <label for="simple_cta_popup_url">' . __( "لینک پاپ‌آپ", "simple-cta-popup" ) . ':</label>
                    <input type="text" id="simple_cta_popup_url" name="simple_cta_popup_url" value="' . esc_url( $popup_url ) . '" size="30" />
                </p>
                <p class="meta-options setting_field">
                    <label for="simple_cta_popup_notification_text">' . __( "متن نوتیفیکشن", "simple-cta-popup" ) . ':</label>
                    <input type="text" id="simple_cta_popup_notification_text" name="simple_cta_popup_notification_text" value="' . $notification_text . '" size="30" />
                </p>
                <p class="meta-options setting_field">
                    <label for="simple_cta_popup_notification_button">' . __( "متن دکمه", "simple-cta-popup" ) . ':</label>
                    <input type="text" id="simple_cta_popup_notification_button" name="simple_cta_popup_notification_button" value="' . $notification_button . '" size="30" />
                </p>
            </div>
        ';

    }
    
    public function setting_meta_box_save( $post_id ) {
        
        // Check if our nonce is set.
        if ( ! isset( $_POST['url_meta_box_nonce'] ) ) {
            return;
        }
        
        $nonce = $_POST['url_meta_box_nonce'];
        
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'url_meta_box' ) ) {
            return;
        }
        
        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        
        // Check the user's permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        
        // Check for and sanitize user input.
        if ( ! isset( $_POST['simple_cta_popup_url'] ) ) {
            return;
        }
    
        $popup_url = esc_url_raw( $_POST['simple_cta_popup_url'] );
        $notification_text = $_POST['simple_cta_popup_notification_text'];
        $notification_button = $_POST['simple_cta_popup_notification_button'];
        
        // Update the meta fields in the database, or clean up after ourselves.
        if ( empty( $popup_url ) ) {
            delete_post_meta( $post_id, '_simple_cta_popup_url' );
        } else {
            update_post_meta( $post_id, '_simple_cta_popup_url', $popup_url );
        }

        if ( empty( $notification_text ) ) {
            delete_post_meta( $post_id, '_simple_cta_popup_notification_text' );
        } else {
            update_post_meta( $post_id, '_simple_cta_popup_notification_text', $notification_text );
        }

        if ( empty( $notification_button ) ) {
            delete_post_meta( $post_id, '_simple_cta_popup_notification_button' );
        } else {
            update_post_meta( $post_id, '_simple_cta_popup_notification_button', $notification_button );
        }
    }

}