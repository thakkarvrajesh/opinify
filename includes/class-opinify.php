<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * @since      1.0
 * @package    Opinify
 * @author     Vrajesh Thakkar
 */

if ( ! class_exists( 'Opinify' ) ) {

    class Opinify {

        /**
         * Define the core functionality of the plugin.
         *
         * Register all of the hooks related to the functionality.
         *
         * @since    1.0
         */
        public function __construct() {
            
            // Enqueue sctipts for front end area.
            add_action( 'wp_enqueue_scripts', array( $this, 'opinify_enqueue_scripts' ) );

            // 
            add_action( 'admin_menu', array( $this, 'add_settings_page' ) );

            // 
            add_action( 'admin_init', array( $this, 'register_settings' ) );

            // 
            add_action('admin_init', array( $this, 'prp_settings_fields' ) );

            // Enqueue sctipts for admin area.
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

            // Saved review data AJAX action.
            add_action( 'wp_ajax_submit_review', array( $this, 'submit_review_ajax' ) );
            add_action( 'wp_ajax_nopriv_submit_review', array( $this, 'submit_review_ajax' ) );

            // Review form shortcode function.
            add_shortcode( 'review_form', array( $this, 'review_form_shortcode' ) );

            // 
            add_shortcode( 'display_reviews', array( $this, 'display_reviews_shortcode' ) );

            // 
            add_filter( 'prp_review_form_additional_fields', array( $this, 'add_custom_field' ) );

        }

        /**
         * Enqueue scripts and styles.
         */
        public function opinify_enqueue_scripts() {
            
            // Main style.
            wp_register_style( 'opinify-style-css', OPINIFY_URL . 'assets/css/opinify-style.css', array(), filemtime( OPINIFY_PATH . 'assets/css/opinify-style.css' ), 'all' );
            wp_enqueue_style( 'opinify-style-css' );

        }

        /**
         * Enqueue admin scripts and styles.
         */
        public function enqueue_admin_scripts() {
            // Enqueue admin scripts and styles here.
            wp_enqueue_editor();

            // Plugin admin setting page style.
            wp_register_style( 'opinify-admin-style', OPINIFY_URL . 'assets/css/opinify-admin-style.css', array(), filemtime( OPINIFY_PATH . 'assets/css/opinify-admin-style.css' ), 'all' );
            wp_enqueue_style( 'opinify-admin-style' );

            // Plugin admin setting page script.
            wp_register_script( 'opinify-admin-script', OPINIFY_URL . 'assets/js/opinify-admin-script.js', array(), filemtime( OPINIFY_PATH . 'assets/js/opinify-admin-script.js' ), true );
            wp_enqueue_script( 'opinify-admin-script' );
        }

        /**
         * Add opinify settings page.
         */
        public function add_settings_page() {
            add_menu_page(
                'Opinify Settings',
                'Opinify',
                'manage_options',
                'opinify-settings',
                array( $this, 'render_settings_page' ),
                'dashicons-feedback',
                45
            );
        }

        /**
         * Opinify settings page render.
         */
        public function render_settings_page() {
            ?>
            <div class="wrap">
                <h2>Opinify Settings</h2>

                <!-- New Layout -->
                <h2>Review Form Settings</h2>
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="blogname">Form Fields</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text">
                                        <span>Date Format</span>
                                    </legend>
                                    <div class="item__wrapper">
                                        <label class="" for="name">Name</label>
                                        <label class="toggle-switch">
                                            <input type="checkbox" id="name" name="prp_enable_fields" value="1" />
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="item__wrapper">
                                        <label class="" for="email">Email</label>
                                        <label class="toggle-switch">
                                            <input type="checkbox" id="email" name="prp_enable_fields" value="1" />
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="item__wrapper">
                                        <label class="" for="rating">Rating</label>
                                        <label class="toggle-switch">
                                            <input type="checkbox" id="rating" name="prp_enable_fields" value="1" />
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="item__wrapper">
                                        <label class="" for="feedback">Feedback</label>
                                        <label class="toggle-switch">
                                            <input type="checkbox" id="feedback" name="prp_enable_fields" value="1" />
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="blogname">Google reCaptcha</label></th>
                            <td>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="is_captcha" name="prp_enable_fields" value="1" />
                                    <span class="slider"></span>
                                </label>
                            </td>
                        </tr>
                        <tr class="opinify_captcha_key_setting">
                            <th scope="row"><label for="blogname">Site Key</label></th>
                            <td>
                                <input type="text" name="opinify_sitekey_setting" class="regular-text" value="" />
                            </td>
                        </tr>
                        <tr class="opinify_captcha_key_setting">
                            <th scope="row"><label for="blogname">Secret Key</label></th>
                            <td>
                                <input type="text" name="opinify_sitekey_setting" class="regular-text" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Old Layout -->
                <?php settings_errors(); ?>
                <form method="post" action="options.php">
                    <?php
                    settings_fields('prp-settings');
                    do_settings_sections('prp-settings');

                    // Get saved content
                    $content = get_option('prp_email_template');
                    $is_email_template = get_option('prp_email_notification');

                    if ( $is_email_template ) {

                    }

                    wp_editor(
                        $content,
                        'opinify_email_template_editor',
                        array(
                            'textarea_name' => 'prp_email_template',
                            'editor_height' => '200px',
                            'teeny' => false,
                            'tinymce' => false,
                            'media_buttons' => false,
                        )
                    );

                    submit_button('Save Settings');
                    ?>
                </form>
            </div>
            <?php
        }

        /**
         * Register and define settings.
         */
        public function register_settings() {
            register_setting('prp-settings', 'prp_enable_fields');
            register_setting('prp-settings', 'prp_required_fields');
            register_setting('prp-settings', 'prp_email_notification');
            register_setting('prp-settings', 'prp_email_template');
            register_setting('prp-settings', 'opinify_is_captcha');
            register_setting('prp-settings', 'opinify_captcha_sitekey');
            register_setting('prp-settings', 'opinify_captcha_secretkey');
        }

        // Add settings fields
        function prp_settings_fields() {
            // Enable fields setting field
            add_settings_section('prp-settings-section', 'Review Form Settings', array( $this, 'prp_settings_section_callback' ), 'prp-settings');
            add_settings_field('prp-enable-fields', 'Enable Fields', array( $this, 'prp_enable_fields_field_callback' ), 'prp-settings', 'prp-settings-section');

            // Required fields setting field
            add_settings_field('prp-required-fields', 'Required Fields', array( $this, 'prp_required_fields_field_callback' ), 'prp-settings', 'prp-settings-section');

            // Google reCaptcha setting.
            add_settings_field( 'opinify-captcha-setting', 'Google reCaptcha', array( $this, 'opinify_google_recaptcha_setting_field_callback' ), 'prp-settings', 'prp-settings-section' );

            // Site key setting.
            add_settings_field( 'opinify-captcha-sitekey-setting', 'Site Key', array( $this, 'opinify_sitekey_setting_field_callback' ), 'prp-settings', 'prp-settings-section' );

            // Secret key setting.
            add_settings_field( 'opinify-captcha-secretkey-setting', 'Secret Key', array( $this, 'opinify_secretkey_setting_field_callback' ), 'prp-settings', 'prp-settings-section' );

            // Email notification setting field
            add_settings_field('prp-email-notification', 'Email Notification', array( $this, 'prp_email_notification_field_callback' ), 'prp-settings', 'prp-settings-section');

            // Email template setting field
            // add_settings_field('prp-email-template', 'Email Template', array( $this, 'prp_email_template_field_callback' ), 'prp-settings', 'prp-settings-section');
        }

        // Settings section callback
        function prp_settings_section_callback() {
            echo 'Configure review form settings.';
        }

        // Site key.
        public function opinify_sitekey_setting_field_callback() {
            // 6LfYCXcpAAAAAPI8b7SwPaX5Ivk9dB6OyLK4OuBV
            $options = get_option( 'opinify_sitekey_setting' );
            echo '<input type="text" name="opinify_sitekey_setting" class="regular-text" value="' . ( ! empty( $options ) ? $options : '' ) . '">';
        }

        // Secret Key.
        public function opinify_secretkey_setting_field_callback() {
            // 6LfYCXcpAAAAAFMY1LcsxrZpcxUi8SO-6rC4BKsz
            $options = get_option( 'opinify_secretkey_setting' );
            echo '<input type="text" name="opinify_secretkey_setting" class="regular-text" value="' . ( ! empty( $options ) ? $options : '' ) . '" />';
        }

        // Google reCaptcha setting field setting.
        public function opinify_google_recaptcha_setting_field_callback() {
            $options = get_option( 'opinify_google_recaptcha_setting' );
            echo '<label class="toggle-switch">
            <input type="checkbox" name="opinify_google_recaptcha_setting" value="1" ' . checked( 1, $options, false ) . ' />
            <span class="slider"></span>
            </label>';
        }

        // Enable fields setting field callback
        function prp_enable_fields_field_callback() {
            $options = get_option('prp_enable_fields');
            echo '<label class="toggle-switch">
            <input type="checkbox" name="prp_enable_fields" value="1" ' . checked(1, $options, false) . ' />
            <span class="slider"></span>
            </label>';
        }

        // Required fields setting field callback
        function prp_required_fields_field_callback() {
            $options = get_option('prp_required_fields');
            echo '<label class="toggle-switch">
            <input type="checkbox" name="prp_required_fields" value="1" ' . checked(1, $options, false) . ' />
            <span class="slider"></span>
            </label>';
        }

        // Email notification setting field callback
        function prp_email_notification_field_callback() {
            $options = get_option('prp_email_notification');
            echo '<label class="toggle-switch">
            <input type="checkbox" name="prp_email_notification" value="1" id="isEmailTemplate" ' . checked(1, $options, false) . ' />
            <span class="slider"></span>
            </label>';
        }

        // Email template setting field callback
        // function prp_email_template_field_callback() {
        //     $options = get_option('prp_email_template');
        //     echo '<textarea name="prp_email_template">' . esc_textarea($options) . '</textarea>';
        // }

        /**
         * Add custom field using filter hook.
         */
        public function add_custom_field( $fields ) {
            $fields['custom_field'] = array(
                'label' => 'Custom Field',
                'type' => 'text',
                'required' => false
            );

            $fields['aggrement'] = array(
                'label' => 'I aggre <a href="#">Privacy Policy</a>, and I understand your terms and conditions.',
                'type' => 'checkbox',
                'required' => false
            );

            return $fields;
        }

        /**
         * Shortcode for review submission form.
         */
        public function review_form_shortcode() {
            // Define default fields
            $fields = array(
                'full_name' => array(
                    'label' => 'Full Name',
                    'type' => 'text',
                    'required' => true
                ),
                'email' => array(
                    'label' => 'Email',
                    'type' => 'email',
                    'required' => true
                ),
                'rating' => array(
                    'label' => '',
                    'type' => 'radio',
                    'options' => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5'
                    ),
                    'required' => true
                ),
                'feedback' => array(
                    'label' => 'Feedback',
                    'type' => 'textarea',
                    'required' => true
                )
            );
        
            // Apply filter to add additional fields
            $additional_fields = apply_filters( 'prp_review_form_additional_fields', array() );
        
            // Merge default fields with additional fields
            if ( is_array( $additional_fields ) && ! empty( $additional_fields ) ) {
                $fields = array_merge( $fields, $additional_fields );
            }
        
            // Generate form HTML.
            $form_html = '<div class="opinify-form-wrapper">';
            $form_html .= '<form id="review_form">';
        
            foreach ( $fields as $field_name => $field ) {

                $form_html .= '<div class="opinify-form-field-group '. esc_attr( $field['type'] ) .'">';

                if ( ( isset( $field['label'] ) && ! empty( $field['label'] ) ) && "checkbox" !== $field['type'] ) {
                    $form_html .= '<label for="' . esc_attr( $field_name ) . '">' . wp_kses_post( $field['label'] );
                    if ( $field['required'] && ! empty( $field['label'] ) ) {
                        $form_html .= '<span class="required">*</span>';
                    }
                    $form_html .= '</label>';
                }
        
                if ( $field['type'] === 'text' || $field['type'] === 'email' ) {
                    $form_html .= '<input type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_name ) . '" class="opinify-form-field '. esc_attr( $field['type'] ) .'" required>';
                } elseif ( $field['type'] === 'textarea' ) {
                    $form_html .= '<textarea name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_name ) . '" class="opinify-form-field '. esc_attr( $field['type'] ) .'" required></textarea>';
                } elseif ( $field['type'] === 'radio' && ! empty( $field['options'] ) ) {
                    foreach ( $field['options'] as $option_value => $option_label ) {
                        $form_html .= '<input type="radio" name="' . esc_attr( $field_name ) . '" value="' . esc_attr( $option_value ) . '" class="opinify-form-field '. esc_attr( $field['type'] ) .'" required>';
                        $form_html .= '<label for="' . esc_attr( $field_name ) . '" class="star">&#9733;</label>';
                    }
                } elseif( $field['type'] === 'checkbox' ) {
                    $form_html .= '<input type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_name ) . '" class="opinify-form-field '. esc_attr( $field['type'] ) .'" required>';
                    if ( isset( $field['label'] ) && ! empty( $field['label'] ) ) {
                        $form_html .= '<label for="' . esc_attr( $field_name ) . '">' . wp_kses_post( $field['label'] ) . '</label>';
                    }
                }
        
                $form_html .= '</div>';
            }
        
            $form_html .= '<input type="hidden" name="nonce" value="' . wp_create_nonce( 'prp_submit_review_nonce' ) . '">';
            $form_html .= '<input type="hidden" name="action" value="opinify_form_action">';
            $form_html .= '<input type="submit" value="Submit Review">';
            $form_html .= '</form>';
            $form_html .= '</div>';
        
            return $form_html;
        }

        /**
         * AJAX handler for form submission.
         */
        public function submit_review_ajax() {
            /*
            // Verify nonce for security
            if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'prp_submit_review_nonce' ) ) {
                wp_send_json_error( 'Invalid nonce' );
            }

            // Check if data is submitted
            if ( empty( $_POST['formData'] ) ) {
                wp_send_json_error( 'No data submitted' );
            }

            // Parse form data
            parse_str( $_POST['formData'], $form_data );

            // Sanitize and validate form data
            $review_title = isset( $form_data['review_title'] ) ? sanitize_text_field( $form_data['review_title'] ) : '';
            $review_content = isset( $form_data['review_content'] ) ? sanitize_textarea_field( $form_data['review_content'] ) : '';
            $post_id = isset( $form_data['post_id'] ) ? absint( $form_data['post_id'] ) : 0;
            $user_ip = $_SERVER['REMOTE_ADDR'];

            if ( empty( $review_title ) || empty( $review_content ) || empty( $post_id ) ) {
                wp_send_json_error( 'Review title, content, and post ID are required' );
            }

            // Insert review as post
            $post_data = array(
                'post_title'   => $review_title,
                'post_content' => $review_content,
                'post_type'    => 'post_type_reviews',
                'post_status'  => 'publish',
            );

            $review_id = wp_insert_post( $post_data );

            if ( is_wp_error( $review_id ) ) {
                wp_send_json_error( 'Error occurred while saving review' );
            }

            // Check if email notification is enabled
            $email_notification = get_option( 'prp_email_notification' );
            if ( $email_notification ) {
                // Get admin email
                $admin_email = get_option( 'admin_email' );

                // Get email template
                $email_template = get_option( 'prp_email_template' );
                $email_subject = 'New Review Submitted';

                // Generate dynamic shortcodes for email template
                $dynamic_content = sprintf( 'Review Title: %s <br>', $review_title );
                $dynamic_content .= sprintf( 'Review Content: %s <br>', $review_content );
                $dynamic_content .= sprintf( 'Post ID: %d <br>', $post_id );
                $dynamic_content .= sprintf( 'User IP Address: %s <br>', $user_ip );
                $dynamic_content .= sprintf( 'Submission Date & Time: %s <br>', current_time( 'F j, Y g:i a' ) );

                // Replace dynamic shortcodes in email template
                $email_content = str_replace( '{review_details}', $dynamic_content, $email_template );

                // Send email notification
                wp_mail( $admin_email, $email_subject, $email_content );
            }

            wp_send_json_success( 'Review submitted successfully' );
            */
        }

        /**
         * Shortcode for display reviews.
         */
        public function display_reviews_shortcode( $atts ) {
            $atts = shortcode_atts( array(
                'layout' => 'list',
                'per_page' => -1,
                'order' => 'DESC'
            ), $atts );
    
            // Add shortcode HTML generation code here
        }

    }

}
