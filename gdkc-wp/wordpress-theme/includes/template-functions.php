<?php
/**
 * Custom template functions for the theme
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

/**
 * Load a modular homepage component
 *
 * @param string $component The name of the component to load
 * @return void
 */
function gdkc_load_home_component($component) {
    $valid_components = [
        'hero',
        'social-proof',
        'transformation',
        'lead-magnet',
        'problem-solution',
        'testimonials',
        'programs',
        'faq',
        'contact',
        'bento-box',
        'timeline',
        'stats-counter',
        'success-gallery',
        'service-map',
        'behavior-quiz',
        'dog-profile-creator',
        'cost-calculator',
        'training-progress',
        'live-calendar',
        'breed-advice'
    ];
    
    if (in_array($component, $valid_components)) {
        get_template_part('template-parts/home/' . $component);
    } elseif ($component === 'sticky-cta') {
        get_template_part('template-parts/global/sticky-cta');
    }
}

/**
 * Get list of available homepage components
 *
 * @return array List of component names and their display titles
 */
function gdkc_get_home_components() {
    return [
        'hero' => 'Hero Section',
        'social-proof' => 'Social Proof',
        'transformation' => 'Transformation Showcase',
        'lead-magnet' => 'Lead Magnet Form',
        'problem-solution' => 'Problem & Solutions',
        'testimonials' => 'Client Testimonials',
        'programs' => 'Training Programs',
        'faq' => 'FAQ Section',
        'contact' => 'Contact Form',
        'bento-box' => 'Bento Box Grid',
        'timeline' => 'Training Journey Timeline',
        'stats-counter' => 'Animated Statistics',
        'success-gallery' => 'Success Stories Gallery',
        'service-map' => 'Service Area Map',
        'behavior-quiz' => 'Behavior Assessment Quiz',
        'sticky-cta' => 'Sticky CTA Bar',
        
        /* Advanced Components */
        'dog-profile-creator' => 'Dog Profile Creator',
        'cost-calculator' => 'Training Cost Calculator',
        'training-progress' => 'Training Progress Tracker',
        'live-calendar' => 'Live Booking Calendar',
        'breed-advice' => 'Breed-Specific Advice Generator'
    ];
}

/**
 * Registers meta boxes and custom fields for page components selection
 */
function gdkc_add_page_components_meta_box() {
    add_meta_box(
        'gdkc_page_components',
        'Page Components',
        'gdkc_render_page_components_meta_box',
        'page',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'gdkc_add_page_components_meta_box');

/**
 * Renders the meta box for selecting page components
 *
 * @param WP_Post $post The post object
 */
function gdkc_render_page_components_meta_box($post) {
    // Add nonce for security
    wp_nonce_field('gdkc_page_components_nonce', 'gdkc_page_components_nonce');
    
    // Get the saved components if any
    $saved_components = get_post_meta($post->ID, '_gdkc_page_components', true);
    if (!is_array($saved_components)) {
        $saved_components = [];
    }
    
    // Get all available components
    $all_components = gdkc_get_home_components();
    
    // Separate saved and available components
    $available_components = array_diff_key($all_components, array_flip($saved_components));
    
    // Enqueue jQuery UI for sortable
    wp_enqueue_script('jquery-ui-sortable');
    
    // Add inline script for drag and drop functionality
    ?>
    <style>
        .gdkc-component-list { 
            margin: 10px 0; 
            padding: 0;
            max-height: 200px;
            overflow-y: auto;
        }
        .gdkc-component-item {
            background: #f8f8f8;
            border: 1px solid #ddd;
            padding: 8px 10px;
            margin-bottom: 5px;
            cursor: move;
            border-radius: 3px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .gdkc-component-item:hover {
            background: #f0f0f0;
        }
        .gdkc-component-handle {
            color: #999;
            margin-right: 8px;
        }
        .gdkc-components-selected {
            border-top: 1px solid #ddd;
            margin-top: 15px;
            padding-top: 10px;
        }
        .gdkc-components-available {
            margin-top: 15px;
        }
        .gdkc-component-remove {
            color: #a00;
            cursor: pointer;
            font-size: 16px;
        }
        .gdkc-component-add {
            color: #0073aa;
            cursor: pointer;
            font-size: 16px;
        }
        .gdkc-section-title {
            font-weight: bold;
            margin: 15px 0 5px;
        }
    </style>
    
    <div class="gdkc-components-container">
        <p>Drag and drop components to arrange them on your page:</p>
        
        <div class="gdkc-components-selected">
            <div class="gdkc-section-title">Selected Components</div>
            <p class="description">These components will appear on your page in this order.</p>
            
            <ul id="gdkc-selected-components" class="gdkc-component-list">
                <?php foreach ($saved_components as $key) : 
                    if (isset($all_components[$key])) : ?>
                    <li class="gdkc-component-item">
                        <div>
                            <span class="gdkc-component-handle dashicons dashicons-menu"></span>
                            <span><?php echo esc_html($all_components[$key]); ?></span>
                        </div>
                        <input type="hidden" name="gdkc_page_components[]" value="<?php echo esc_attr($key); ?>">
                        <span class="gdkc-component-remove dashicons dashicons-no-alt" title="Remove"></span>
                    </li>
                <?php 
                    endif;
                endforeach; ?>
            </ul>
        </div>
        
        <div class="gdkc-components-available">
            <div class="gdkc-section-title">Available Components</div>
            <p class="description">Click to add these components to your page.</p>
            
            <ul id="gdkc-available-components" class="gdkc-component-list">
                <?php foreach ($available_components as $key => $label) : ?>
                    <li class="gdkc-component-item" data-component="<?php echo esc_attr($key); ?>">
                        <span><?php echo esc_html($label); ?></span>
                        <span class="gdkc-component-add dashicons dashicons-plus" title="Add"></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Make selected components sortable
        $('#gdkc-selected-components').sortable({
            placeholder: 'gdkc-component-item ui-state-highlight',
            update: function(event, ui) {
                // Update will happen automatically since we use hidden inputs
            }
        });
        
        // Add component when clicking the plus icon
        $('.gdkc-component-add').on('click', function() {
            var $item = $(this).closest('.gdkc-component-item');
            var component = $item.data('component');
            var label = $item.find('span').first().text();
            
            // Create new selected component
            var $newItem = $('<li class="gdkc-component-item">' +
                '<div><span class="gdkc-component-handle dashicons dashicons-menu"></span>' +
                '<span>' + label + '</span></div>' +
                '<input type="hidden" name="gdkc_page_components[]" value="' + component + '">' +
                '<span class="gdkc-component-remove dashicons dashicons-no-alt" title="Remove"></span>' +
                '</li>');
            
            // Add to selected list
            $('#gdkc-selected-components').append($newItem);
            
            // Remove from available list
            $item.remove();
            
            // Attach remove handler to new item
            attachRemoveHandler($newItem);
        });
        
        // Remove component when clicking the remove icon
        function attachRemoveHandler($item) {
            $item.find('.gdkc-component-remove').on('click', function() {
                var component = $item.find('input').val();
                var label = $item.find('span').eq(1).text();
                
                // Add back to available list
                var $newAvailable = $('<li class="gdkc-component-item" data-component="' + component + '">' +
                    '<span>' + label + '</span>' +
                    '<span class="gdkc-component-add dashicons dashicons-plus" title="Add"></span>' +
                    '</li>');
                
                $('#gdkc-available-components').append($newAvailable);
                
                // Attach add handler to new available item
                $newAvailable.find('.gdkc-component-add').on('click', function() {
                    var $availItem = $(this).closest('.gdkc-component-item');
                    var availComponent = $availItem.data('component');
                    var availLabel = $availItem.find('span').first().text();
                    
                    var $newSelected = $('<li class="gdkc-component-item">' +
                        '<div><span class="gdkc-component-handle dashicons dashicons-menu"></span>' +
                        '<span>' + availLabel + '</span></div>' +
                        '<input type="hidden" name="gdkc_page_components[]" value="' + availComponent + '">' +
                        '<span class="gdkc-component-remove dashicons dashicons-no-alt" title="Remove"></span>' +
                        '</li>');
                    
                    $('#gdkc-selected-components').append($newSelected);
                    $availItem.remove();
                    attachRemoveHandler($newSelected);
                });
                
                // Remove from selected list
                $item.remove();
            });
        }
        
        // Attach handlers to existing items
        $('.gdkc-component-remove').each(function() {
            attachRemoveHandler($(this).closest('.gdkc-component-item'));
        });
    });
    </script>
    <?php
}

/**
 * Saves the selected page components when a page is saved
 *
 * @param int $post_id The ID of the post being saved
 */
function gdkc_save_page_components($post_id) {
    // Security checks
    if (!isset($_POST['gdkc_page_components_nonce']) || 
        !wp_verify_nonce($_POST['gdkc_page_components_nonce'], 'gdkc_page_components_nonce')) {
        return;
    }
    
    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check the user's permissions
    if (isset($_POST['post_type']) && 'page' === $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    }
    
    // OK, save the data
    if (isset($_POST['gdkc_page_components'])) {
        $components = array_map('sanitize_text_field', $_POST['gdkc_page_components']);
        update_post_meta($post_id, '_gdkc_page_components', $components);
    } else {
        // No components selected, clear the meta
        delete_post_meta($post_id, '_gdkc_page_components');
    }
}
add_action('save_post', 'gdkc_save_page_components');

/**
 * Function to load components selected for a page
 * 
 * @param int $post_id The post ID to load components for (defaults to current post)
 * @return void
 */
function gdkc_load_page_components($post_id = null) {
    if (null === $post_id) {
        $post_id = get_the_ID();
    }
    
    $components = get_post_meta($post_id, '_gdkc_page_components', true);
    
    if (!empty($components) && is_array($components)) {
        foreach ($components as $component) {
            gdkc_load_home_component($component);
        }
    }
}

/**
 * Add option to hide content on modular pages
 */
function gdkc_add_content_display_field() {
    add_meta_box(
        'gdkc_show_content',
        'Page Content Display',
        'gdkc_render_content_display_field',
        'page',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'gdkc_add_content_display_field');

/**
 * Render the content display option
 */
function gdkc_render_content_display_field($post) {
    // Add nonce for security
    wp_nonce_field('gdkc_content_display_nonce', 'gdkc_content_display_nonce');
    
    // Get current value
    $current_value = get_post_meta($post->ID, '_gdkc_show_page_content', true);
    
    echo '<p>';
    echo '<label>';
    echo '<input type="radio" name="gdkc_show_page_content" value="show" ' . checked($current_value, 'show', false) . checked($current_value, '', false) . '> ';
    echo 'Show page content (default)';
    echo '</label>';
    echo '</p>';
    
    echo '<p>';
    echo '<label>';
    echo '<input type="radio" name="gdkc_show_page_content" value="hide" ' . checked($current_value, 'hide', false) . '> ';
    echo 'Hide page content (components only)';
    echo '</label>';
    echo '</p>';
    
    echo '<p class="description">When using a modular page template, you can choose to show or hide the main page content.</p>';
}

/**
 * Save the content display setting
 */
function gdkc_save_content_display_field($post_id) {
    // Security checks
    if (!isset($_POST['gdkc_content_display_nonce']) || 
        !wp_verify_nonce($_POST['gdkc_content_display_nonce'], 'gdkc_content_display_nonce')) {
        return;
    }
    
    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (isset($_POST['post_type']) && 'page' === $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    }
    
    // Save the data
    if (isset($_POST['gdkc_show_page_content'])) {
        update_post_meta($post_id, '_gdkc_show_page_content', sanitize_text_field($_POST['gdkc_show_page_content']));
    }
}
add_action('save_post', 'gdkc_save_content_display_field');

/**
 * Register a metabox for component settings
 */
function gdkc_add_component_settings_meta_box() {
    add_meta_box(
        'gdkc_component_settings',
        'Component Settings',
        'gdkc_render_component_settings_meta_box',
        'page',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'gdkc_add_component_settings_meta_box');

/**
 * Renders the component settings meta box
 *
 * @param WP_Post $post The post object
 */
function gdkc_render_component_settings_meta_box($post) {
    wp_nonce_field('gdkc_component_settings_nonce', 'gdkc_component_settings_nonce');
    
    // Get the saved components
    $components = get_post_meta($post->ID, '_gdkc_page_components', true);
    if (!is_array($components) || empty($components)) {
        echo '<p>No components selected for this page. Please select components first.</p>';
        return;
    }
    
    // Get component display names
    $component_names = gdkc_get_home_components();
    
    // Enqueue necessary scripts
    wp_enqueue_script('jquery-ui-tabs');
    ?>
    <style>
        .gdkc-settings-tabs {
            margin-top: 15px;
        }
        .gdkc-settings-tab-nav {
            border-bottom: 1px solid #ddd;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
        }
        .gdkc-settings-tab-nav li {
            margin: 0 0 -1px 0;
            padding: 0;
            display: inline-block;
        }
        .gdkc-settings-tab-nav li a {
            padding: 10px 15px;
            display: block;
            text-decoration: none;
            color: #0073aa;
            background: #f8f8f8;
            border: 1px solid #ddd;
            border-bottom: none;
            border-radius: 3px 3px 0 0;
            margin-right: 5px;
            font-weight: 500;
        }
        .gdkc-settings-tab-nav li.ui-tabs-active a {
            background: #fff;
            border-bottom: 1px solid #fff;
            color: #23282d;
        }
        .gdkc-settings-tab-content {
            padding: 15px;
            background: #fff;
            border: 1px solid #ddd;
            border-top: none;
        }
        .gdkc-settings-field {
            margin-bottom: 15px;
        }
        .gdkc-settings-field label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .gdkc-settings-field input[type="text"],
        .gdkc-settings-field textarea,
        .gdkc-settings-field select {
            width: 100%;
            max-width: 600px;
        }
        .gdkc-settings-field textarea {
            min-height: 100px;
        }
        .gdkc-settings-section {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .gdkc-settings-section-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }
    </style>
    
    <div id="gdkc-component-settings" class="gdkc-settings-tabs">
        <ul class="gdkc-settings-tab-nav">
            <?php foreach ($components as $index => $component) : ?>
                <?php if (isset($component_names[$component])) : ?>
                <li>
                    <a href="#gdkc-settings-<?php echo esc_attr($component); ?>">
                        <?php echo esc_html($component_names[$component]); ?>
                    </a>
                </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
        
        <?php foreach ($components as $component) : ?>
            <?php if (isset($component_names[$component])) : ?>
            <div id="gdkc-settings-<?php echo esc_attr($component); ?>" class="gdkc-settings-tab-content">
                <h3><?php echo esc_html($component_names[$component]); ?> Settings</h3>
                
                <?php
                // Get any saved settings for this component
                $settings = get_post_meta($post->ID, '_gdkc_' . $component . '_settings', true);
                if (!is_array($settings)) {
                    $settings = [];
                }
                
                // Render component-specific settings
                switch ($component) {
                    case 'hero':
                        gdkc_render_hero_settings($settings);
                        break;
                    case 'programs':
                        gdkc_render_programs_settings($settings);
                        break;
                    case 'testimonials':
                        gdkc_render_testimonials_settings($settings);
                        break;
                    case 'contact':
                        gdkc_render_contact_settings($settings);
                        break;
                    case 'behavior-quiz':
                        gdkc_render_behavior_quiz_settings($settings);
                        break;
                    case 'service-map':
                        gdkc_render_service_map_settings($settings);
                        break;
                    // Add more cases for each component as needed
                    default:
                        // Default fields for any component type
                        ?>
                        <div class="gdkc-settings-field">
                            <label for="<?php echo esc_attr($component); ?>_title">Title</label>
                            <input type="text" id="<?php echo esc_attr($component); ?>_title" 
                                   name="gdkc_component_settings[<?php echo esc_attr($component); ?>][title]" 
                                   value="<?php echo esc_attr(isset($settings['title']) ? $settings['title'] : ''); ?>">
                        </div>
                        
                        <div class="gdkc-settings-field">
                            <label for="<?php echo esc_attr($component); ?>_subtitle">Subtitle</label>
                            <input type="text" id="<?php echo esc_attr($component); ?>_subtitle" 
                                   name="gdkc_component_settings[<?php echo esc_attr($component); ?>][subtitle]" 
                                   value="<?php echo esc_attr(isset($settings['subtitle']) ? $settings['subtitle'] : ''); ?>">
                        </div>
                        
                        <div class="gdkc-settings-field">
                            <label for="<?php echo esc_attr($component); ?>_content">Content</label>
                            <textarea id="<?php echo esc_attr($component); ?>_content" 
                                     name="gdkc_component_settings[<?php echo esc_attr($component); ?>][content]"><?php 
                                     echo esc_textarea(isset($settings['content']) ? $settings['content'] : ''); 
                            ?></textarea>
                        </div>
                        
                        <div class="gdkc-settings-field">
                            <label for="<?php echo esc_attr($component); ?>_background">Background Color</label>
                            <input type="text" id="<?php echo esc_attr($component); ?>_background" 
                                   name="gdkc_component_settings[<?php echo esc_attr($component); ?>][background]" 
                                   value="<?php echo esc_attr(isset($settings['background']) ? $settings['background'] : ''); ?>"
                                   placeholder="#ffffff">
                            <p class="description">Enter a hex color code or leave blank for default.</p>
                        </div>
                        <?php
                        break;
                }
                ?>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $("#gdkc-component-settings").tabs();
    });
    </script>
    <?php
}

/**
 * Render settings for the Hero component
 *
 * @param array $settings Existing settings
 */
function gdkc_render_hero_settings($settings) {
    ?>
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Hero Content</div>
        
        <div class="gdkc-settings-field">
            <label for="hero_title">Main Heading</label>
            <input type="text" id="hero_title" 
                   name="gdkc_component_settings[hero][title]" 
                   value="<?php echo esc_attr(isset($settings['title']) ? $settings['title'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="hero_subtitle">Subtitle</label>
            <input type="text" id="hero_subtitle" 
                   name="gdkc_component_settings[hero][subtitle]" 
                   value="<?php echo esc_attr(isset($settings['subtitle']) ? $settings['subtitle'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="hero_content">Description</label>
            <textarea id="hero_content" 
                     name="gdkc_component_settings[hero][content]"><?php 
                     echo esc_textarea(isset($settings['content']) ? $settings['content'] : ''); 
            ?></textarea>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Call to Action</div>
        
        <div class="gdkc-settings-field">
            <label for="hero_button_text">Button Text</label>
            <input type="text" id="hero_button_text" 
                   name="gdkc_component_settings[hero][button_text]" 
                   value="<?php echo esc_attr(isset($settings['button_text']) ? $settings['button_text'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="hero_button_url">Button URL</label>
            <input type="text" id="hero_button_url" 
                   name="gdkc_component_settings[hero][button_url]" 
                   value="<?php echo esc_attr(isset($settings['button_url']) ? $settings['button_url'] : ''); ?>">
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Lava Animation</div>
        
        <div class="gdkc-settings-field">
            <label>
                <input type="checkbox" 
                       name="gdkc_component_settings[hero][use_lava_animation]" 
                       value="1" <?php checked(isset($settings['use_lava_animation']) ? $settings['use_lava_animation'] : true, true); ?>>
                Enable lava lamp animation background
            </label>
            <p class="description">Adds a dynamic animated background to the hero section.</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="hero_lava_color_outer">Outer Color</label>
            <input type="text" id="hero_lava_color_outer" 
                   name="gdkc_component_settings[hero][lava_color_outer]" 
                   value="<?php echo esc_attr(isset($settings['lava_color_outer']) ? $settings['lava_color_outer'] : '#a08cff'); ?>"
                   placeholder="#a08cff">
            <p class="description">Outer gradient color for lava animation (light purple default).</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="hero_lava_color_mid">Middle Color</label>
            <input type="text" id="hero_lava_color_mid" 
                   name="gdkc_component_settings[hero][lava_color_mid]" 
                   value="<?php echo esc_attr(isset($settings['lava_color_mid']) ? $settings['lava_color_mid'] : '#6a3ad6'); ?>"
                   placeholder="#6a3ad6">
            <p class="description">Middle gradient color for lava animation (medium purple default).</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="hero_lava_color_inner">Inner Color</label>
            <input type="text" id="hero_lava_color_inner" 
                   name="gdkc_component_settings[hero][lava_color_inner]" 
                   value="<?php echo esc_attr(isset($settings['lava_color_inner']) ? $settings['lava_color_inner'] : '#4b0082'); ?>"
                   placeholder="#4b0082">
            <p class="description">Inner gradient color for lava animation (indigo default).</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="hero_lava_bg">Background Color</label>
            <input type="text" id="hero_lava_bg" 
                   name="gdkc_component_settings[hero][lava_bg]" 
                   value="<?php echo esc_attr(isset($settings['lava_bg']) ? $settings['lava_bg'] : '#0a0a2a'); ?>"
                   placeholder="#0a0a2a">
            <p class="description">Background color for lava animation (deep space blue default).</p>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Appearance</div>
        
        <div class="gdkc-settings-field">
            <label for="hero_background_type">Background Type</label>
            <select id="hero_background_type" 
                    name="gdkc_component_settings[hero][background_type]">
                <option value="color" <?php selected(isset($settings['background_type']) ? $settings['background_type'] : '', 'color'); ?>>Solid Color</option>
                <option value="image" <?php selected(isset($settings['background_type']) ? $settings['background_type'] : '', 'image'); ?>>Image</option>
                <option value="video" <?php selected(isset($settings['background_type']) ? $settings['background_type'] : '', 'video'); ?>>Video</option>
            </select>
            <p class="description">Note: If lava animation is enabled, this will be used as a fallback.</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="hero_background_color">Background Color</label>
            <input type="text" id="hero_background_color" 
                   name="gdkc_component_settings[hero][background_color]" 
                   value="<?php echo esc_attr(isset($settings['background_color']) ? $settings['background_color'] : ''); ?>"
                   placeholder="#ffffff">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="hero_background_image">Background Image ID</label>
            <input type="text" id="hero_background_image" 
                   name="gdkc_component_settings[hero][background_image]" 
                   value="<?php echo esc_attr(isset($settings['background_image']) ? $settings['background_image'] : ''); ?>">
            <p class="description">Enter a WordPress media ID, or leave blank for default.</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="hero_background_video">Background Video URL</label>
            <input type="text" id="hero_background_video" 
                   name="gdkc_component_settings[hero][background_video]" 
                   value="<?php echo esc_attr(isset($settings['background_video']) ? $settings['background_video'] : ''); ?>">
            <p class="description">Enter a URL to an MP4 video file, or leave blank for default.</p>
        </div>
    </div>
    <?php
}

/**
 * Render settings for the Programs component
 *
 * @param array $settings Existing settings
 */
function gdkc_render_programs_settings($settings) {
    ?>
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Section Content</div>
        
        <div class="gdkc-settings-field">
            <label for="programs_title">Section Title</label>
            <input type="text" id="programs_title" 
                   name="gdkc_component_settings[programs][title]" 
                   value="<?php echo esc_attr(isset($settings['title']) ? $settings['title'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="programs_subtitle">Section Subtitle</label>
            <input type="text" id="programs_subtitle" 
                   name="gdkc_component_settings[programs][subtitle]" 
                   value="<?php echo esc_attr(isset($settings['subtitle']) ? $settings['subtitle'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="programs_intro">Introduction Text</label>
            <textarea id="programs_intro" 
                     name="gdkc_component_settings[programs][intro]"><?php 
                     echo esc_textarea(isset($settings['intro']) ? $settings['intro'] : ''); 
            ?></textarea>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Display Options</div>
        
        <div class="gdkc-settings-field">
            <label for="programs_layout">Layout Style</label>
            <select id="programs_layout" 
                    name="gdkc_component_settings[programs][layout]">
                <option value="grid" <?php selected(isset($settings['layout']) ? $settings['layout'] : '', 'grid'); ?>>Grid</option>
                <option value="list" <?php selected(isset($settings['layout']) ? $settings['layout'] : '', 'list'); ?>>List</option>
                <option value="featured" <?php selected(isset($settings['layout']) ? $settings['layout'] : '', 'featured'); ?>>Featured</option>
            </select>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="programs_per_page">Programs to Display</label>
            <input type="number" id="programs_per_page" 
                   name="gdkc_component_settings[programs][per_page]" 
                   value="<?php echo esc_attr(isset($settings['per_page']) ? $settings['per_page'] : 3); ?>"
                   min="1" max="12">
            <p class="description">How many programs to show (max 12)</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label>
                <input type="checkbox" 
                       name="gdkc_component_settings[programs][show_pricing]" 
                       value="1" <?php checked(isset($settings['show_pricing']) ? $settings['show_pricing'] : '', '1'); ?>>
                Display pricing information
            </label>
        </div>
        
        <div class="gdkc-settings-field">
            <label>
                <input type="checkbox" 
                       name="gdkc_component_settings[programs][show_cta]" 
                       value="1" <?php checked(isset($settings['show_cta']) ? $settings['show_cta'] : '', '1'); ?>>
                Show call-to-action buttons
            </label>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Custom Program Selection</div>
        
        <div class="gdkc-settings-field">
            <label for="programs_ids">Specific Program IDs</label>
            <input type="text" id="programs_ids" 
                   name="gdkc_component_settings[programs][ids]" 
                   value="<?php echo esc_attr(isset($settings['ids']) ? $settings['ids'] : ''); ?>">
            <p class="description">Optional: Enter program IDs separated by commas to show specific programs</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="programs_category">Filter by Category</label>
            <input type="text" id="programs_category" 
                   name="gdkc_component_settings[programs][category]" 
                   value="<?php echo esc_attr(isset($settings['category']) ? $settings['category'] : ''); ?>">
            <p class="description">Optional: Enter a category slug to filter programs</p>
        </div>
    </div>
    <?php
}

/**
 * Render settings for the Testimonials component
 *
 * @param array $settings Existing settings
 */
function gdkc_render_testimonials_settings($settings) {
    ?>
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Section Content</div>
        
        <div class="gdkc-settings-field">
            <label for="testimonials_title">Section Title</label>
            <input type="text" id="testimonials_title" 
                   name="gdkc_component_settings[testimonials][title]" 
                   value="<?php echo esc_attr(isset($settings['title']) ? $settings['title'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="testimonials_subtitle">Section Subtitle</label>
            <input type="text" id="testimonials_subtitle" 
                   name="gdkc_component_settings[testimonials][subtitle]" 
                   value="<?php echo esc_attr(isset($settings['subtitle']) ? $settings['subtitle'] : ''); ?>">
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Display Options</div>
        
        <div class="gdkc-settings-field">
            <label for="testimonials_layout">Layout Style</label>
            <select id="testimonials_layout" 
                    name="gdkc_component_settings[testimonials][layout]">
                <option value="slider" <?php selected(isset($settings['layout']) ? $settings['layout'] : '', 'slider'); ?>>Slider</option>
                <option value="grid" <?php selected(isset($settings['layout']) ? $settings['layout'] : '', 'grid'); ?>>Grid</option>
                <option value="list" <?php selected(isset($settings['layout']) ? $settings['layout'] : '', 'list'); ?>>List</option>
            </select>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="testimonials_per_page">Testimonials to Display</label>
            <input type="number" id="testimonials_per_page" 
                   name="gdkc_component_settings[testimonials][per_page]" 
                   value="<?php echo esc_attr(isset($settings['per_page']) ? $settings['per_page'] : 3); ?>"
                   min="1" max="12">
            <p class="description">How many testimonials to show</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label>
                <input type="checkbox" 
                       name="gdkc_component_settings[testimonials][show_rating]" 
                       value="1" <?php checked(isset($settings['show_rating']) ? $settings['show_rating'] : '', '1'); ?>>
                Display star ratings
            </label>
        </div>
        
        <div class="gdkc-settings-field">
            <label>
                <input type="checkbox" 
                       name="gdkc_component_settings[testimonials][show_image]" 
                       value="1" <?php checked(isset($settings['show_image']) ? $settings['show_image'] : '', '1'); ?>>
                Show client images
            </label>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Custom Testimonial Selection</div>
        
        <div class="gdkc-settings-field">
            <label for="testimonials_ids">Specific Testimonial IDs</label>
            <input type="text" id="testimonials_ids" 
                   name="gdkc_component_settings[testimonials][ids]" 
                   value="<?php echo esc_attr(isset($settings['ids']) ? $settings['ids'] : ''); ?>">
            <p class="description">Optional: Enter testimonial IDs separated by commas to show specific testimonials</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="testimonials_category">Filter by Category</label>
            <input type="text" id="testimonials_category" 
                   name="gdkc_component_settings[testimonials][category]" 
                   value="<?php echo esc_attr(isset($settings['category']) ? $settings['category'] : ''); ?>">
            <p class="description">Optional: Enter a category slug to filter testimonials</p>
        </div>
    </div>
    <?php
}

/**
 * Render settings for the Contact component
 *
 * @param array $settings Existing settings
 */
function gdkc_render_contact_settings($settings) {
    ?>
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Section Content</div>
        
        <div class="gdkc-settings-field">
            <label for="contact_title">Section Title</label>
            <input type="text" id="contact_title" 
                   name="gdkc_component_settings[contact][title]" 
                   value="<?php echo esc_attr(isset($settings['title']) ? $settings['title'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="contact_subtitle">Section Subtitle</label>
            <input type="text" id="contact_subtitle" 
                   name="gdkc_component_settings[contact][subtitle]" 
                   value="<?php echo esc_attr(isset($settings['subtitle']) ? $settings['subtitle'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="contact_intro">Introduction Text</label>
            <textarea id="contact_intro" 
                     name="gdkc_component_settings[contact][intro]"><?php 
                     echo esc_textarea(isset($settings['intro']) ? $settings['intro'] : ''); 
            ?></textarea>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Contact Form Settings</div>
        
        <div class="gdkc-settings-field">
            <label for="contact_form_id">Contact Form ID</label>
            <input type="text" id="contact_form_id" 
                   name="gdkc_component_settings[contact][form_id]" 
                   value="<?php echo esc_attr(isset($settings['form_id']) ? $settings['form_id'] : ''); ?>">
            <p class="description">Contact Form 7 form ID or shortcode</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="contact_success_message">Success Message</label>
            <textarea id="contact_success_message" 
                     name="gdkc_component_settings[contact][success_message]"><?php 
                     echo esc_textarea(isset($settings['success_message']) ? $settings['success_message'] : ''); 
            ?></textarea>
            <p class="description">Custom success message after form submission</p>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Additional Contact Information</div>
        
        <div class="gdkc-settings-field">
            <label for="contact_phone">Phone Number</label>
            <input type="text" id="contact_phone" 
                   name="gdkc_component_settings[contact][phone]" 
                   value="<?php echo esc_attr(isset($settings['phone']) ? $settings['phone'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="contact_email">Email Address</label>
            <input type="text" id="contact_email" 
                   name="gdkc_component_settings[contact][email]" 
                   value="<?php echo esc_attr(isset($settings['email']) ? $settings['email'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="contact_address">Address</label>
            <textarea id="contact_address" 
                     name="gdkc_component_settings[contact][address]"><?php 
                     echo esc_textarea(isset($settings['address']) ? $settings['address'] : ''); 
            ?></textarea>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Display Options</div>
        
        <div class="gdkc-settings-field">
            <label for="contact_layout">Layout Style</label>
            <select id="contact_layout" 
                    name="gdkc_component_settings[contact][layout]">
                <option value="split" <?php selected(isset($settings['layout']) ? $settings['layout'] : '', 'split'); ?>>Split (Form and Info Side by Side)</option>
                <option value="stacked" <?php selected(isset($settings['layout']) ? $settings['layout'] : '', 'stacked'); ?>>Stacked (Form Above Info)</option>
            </select>
        </div>
        
        <div class="gdkc-settings-field">
            <label>
                <input type="checkbox" 
                       name="gdkc_component_settings[contact][show_map]" 
                       value="1" <?php checked(isset($settings['show_map']) ? $settings['show_map'] : '', '1'); ?>>
                Show Google Map
            </label>
        </div>
        
        <div class="gdkc-settings-field">
            <label>
                <input type="checkbox" 
                       name="gdkc_component_settings[contact][show_social]" 
                       value="1" <?php checked(isset($settings['show_social']) ? $settings['show_social'] : '', '1'); ?>>
                Show Social Media Links
            </label>
        </div>
    </div>
    <?php
}

/**
 * Render settings for the Behavior Quiz component
 *
 * @param array $settings Existing settings
 */
function gdkc_render_behavior_quiz_settings($settings) {
    ?>
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Section Content</div>
        
        <div class="gdkc-settings-field">
            <label for="behavior_quiz_title">Section Title</label>
            <input type="text" id="behavior_quiz_title" 
                   name="gdkc_component_settings[behavior-quiz][title]" 
                   value="<?php echo esc_attr(isset($settings['title']) ? $settings['title'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="behavior_quiz_subtitle">Section Subtitle</label>
            <input type="text" id="behavior_quiz_subtitle" 
                   name="gdkc_component_settings[behavior-quiz][subtitle]" 
                   value="<?php echo esc_attr(isset($settings['subtitle']) ? $settings['subtitle'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="behavior_quiz_intro">Introduction Text</label>
            <textarea id="behavior_quiz_intro" 
                     name="gdkc_component_settings[behavior-quiz][intro]"><?php 
                     echo esc_textarea(isset($settings['intro']) ? $settings['intro'] : ''); 
            ?></textarea>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Quiz Configuration</div>
        
        <div class="gdkc-settings-field">
            <label for="behavior_quiz_questions">Number of Questions</label>
            <input type="number" id="behavior_quiz_questions" 
                   name="gdkc_component_settings[behavior-quiz][questions]" 
                   value="<?php echo esc_attr(isset($settings['questions']) ? $settings['questions'] : 5); ?>"
                   min="3" max="10">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="behavior_quiz_results">Number of Result Categories</label>
            <input type="number" id="behavior_quiz_results" 
                   name="gdkc_component_settings[behavior-quiz][results]" 
                   value="<?php echo esc_attr(isset($settings['results']) ? $settings['results'] : 3); ?>"
                   min="2" max="5">
        </div>
        
        <div class="gdkc-settings-field">
            <label>
                <input type="checkbox" 
                       name="gdkc_component_settings[behavior-quiz][collect_email]" 
                       value="1" <?php checked(isset($settings['collect_email']) ? $settings['collect_email'] : '', '1'); ?>>
                Collect user email before showing results
            </label>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Call to Action</div>
        
        <div class="gdkc-settings-field">
            <label for="behavior_quiz_cta_text">CTA Button Text</label>
            <input type="text" id="behavior_quiz_cta_text" 
                   name="gdkc_component_settings[behavior-quiz][cta_text]" 
                   value="<?php echo esc_attr(isset($settings['cta_text']) ? $settings['cta_text'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="behavior_quiz_cta_url">CTA Button URL</label>
            <input type="text" id="behavior_quiz_cta_url" 
                   name="gdkc_component_settings[behavior-quiz][cta_url]" 
                   value="<?php echo esc_attr(isset($settings['cta_url']) ? $settings['cta_url'] : ''); ?>">
        </div>
    </div>
    <?php
}

/**
 * Render settings for the Service Map component
 *
 * @param array $settings Existing settings
 */
function gdkc_render_service_map_settings($settings) {
    ?>
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Section Content</div>
        
        <div class="gdkc-settings-field">
            <label for="service_map_title">Section Title</label>
            <input type="text" id="service_map_title" 
                   name="gdkc_component_settings[service-map][title]" 
                   value="<?php echo esc_attr(isset($settings['title']) ? $settings['title'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="service_map_subtitle">Section Subtitle</label>
            <input type="text" id="service_map_subtitle" 
                   name="gdkc_component_settings[service-map][subtitle]" 
                   value="<?php echo esc_attr(isset($settings['subtitle']) ? $settings['subtitle'] : ''); ?>">
        </div>
        
        <div class="gdkc-settings-field">
            <label for="service_map_intro">Introduction Text</label>
            <textarea id="service_map_intro" 
                     name="gdkc_component_settings[service-map][intro]"><?php 
                     echo esc_textarea(isset($settings['intro']) ? $settings['intro'] : ''); 
            ?></textarea>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Map Configuration</div>
        
        <div class="gdkc-settings-field">
            <label for="service_map_center">Map Center (Latitude, Longitude)</label>
            <input type="text" id="service_map_center" 
                   name="gdkc_component_settings[service-map][center]" 
                   value="<?php echo esc_attr(isset($settings['center']) ? $settings['center'] : ''); ?>"
                   placeholder="39.0997, -94.5786">
            <p class="description">Enter the latitude and longitude for the map center</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="service_map_zoom">Initial Zoom Level</label>
            <input type="number" id="service_map_zoom" 
                   name="gdkc_component_settings[service-map][zoom]" 
                   value="<?php echo esc_attr(isset($settings['zoom']) ? $settings['zoom'] : 10); ?>"
                   min="1" max="18">
            <p class="description">Zoom level (1-18, higher numbers zoom in more)</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="service_map_radius">Service Radius (in miles)</label>
            <input type="number" id="service_map_radius" 
                   name="gdkc_component_settings[service-map][radius]" 
                   value="<?php echo esc_attr(isset($settings['radius']) ? $settings['radius'] : 25); ?>"
                   min="1" max="100">
            <p class="description">Radius of service coverage to display on the map</p>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Location Markers</div>
        
        <div class="gdkc-settings-field">
            <label for="service_map_business_location">Business Location (Latitude, Longitude)</label>
            <input type="text" id="service_map_business_location" 
                   name="gdkc_component_settings[service-map][business_location]" 
                   value="<?php echo esc_attr(isset($settings['business_location']) ? $settings['business_location'] : ''); ?>"
                   placeholder="39.0997, -94.5786">
            <p class="description">Enter the latitude and longitude for your business location</p>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="service_map_additional_locations">Additional Locations</label>
            <textarea id="service_map_additional_locations" 
                     name="gdkc_component_settings[service-map][additional_locations]"><?php 
                     echo esc_textarea(isset($settings['additional_locations']) ? $settings['additional_locations'] : ''); 
            ?></textarea>
            <p class="description">Enter each location on a new line in format: "Name|Latitude,Longitude"</p>
        </div>
    </div>
    
    <div class="gdkc-settings-section">
        <div class="gdkc-settings-section-title">Display Options</div>
        
        <div class="gdkc-settings-field">
            <label>
                <input type="checkbox" 
                       name="gdkc_component_settings[service-map][show_radius]" 
                       value="1" <?php checked(isset($settings['show_radius']) ? $settings['show_radius'] : '', '1'); ?>>
                Show service radius circle
            </label>
        </div>
        
        <div class="gdkc-settings-field">
            <label>
                <input type="checkbox" 
                       name="gdkc_component_settings[service-map][show_zip_search]" 
                       value="1" <?php checked(isset($settings['show_zip_search']) ? $settings['show_zip_search'] : '', '1'); ?>>
                Show ZIP code search box
            </label>
        </div>
        
        <div class="gdkc-settings-field">
            <label for="service_map_api_key">Google Maps API Key</label>
            <input type="text" id="service_map_api_key" 
                   name="gdkc_component_settings[service-map][api_key]" 
                   value="<?php echo esc_attr(isset($settings['api_key']) ? $settings['api_key'] : ''); ?>">
            <p class="description">Leave blank to use the site-wide Google Maps API key</p>
        </div>
    </div>
    <?php
}

/**
 * Save component settings when a page is saved
 *
 * @param int $post_id The ID of the post being saved
 */
function gdkc_save_component_settings($post_id) {
    // Security checks
    if (!isset($_POST['gdkc_component_settings_nonce']) || 
        !wp_verify_nonce($_POST['gdkc_component_settings_nonce'], 'gdkc_component_settings_nonce')) {
        return;
    }
    
    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check the user's permissions
    if (isset($_POST['post_type']) && 'page' === $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    }
    
    // Save component settings
    if (isset($_POST['gdkc_component_settings']) && is_array($_POST['gdkc_component_settings'])) {
        foreach ($_POST['gdkc_component_settings'] as $component => $settings) {
            // Sanitize each setting
            $sanitized_settings = [];
            foreach ($settings as $key => $value) {
                if (is_array($value)) {
                    $sanitized_settings[$key] = array_map('sanitize_text_field', $value);
                } else {
                    // Determine appropriate sanitization based on field type
                    if (in_array($key, ['content', 'intro', 'success_message', 'address', 'additional_locations'])) {
                        $sanitized_settings[$key] = wp_kses_post($value);
                    } else {
                        $sanitized_settings[$key] = sanitize_text_field($value);
                    }
                }
            }
            
            // Save the settings
            update_post_meta($post_id, '_gdkc_' . sanitize_text_field($component) . '_settings', $sanitized_settings);
        }
    }
}
add_action('save_post', 'gdkc_save_component_settings');

/**
 * Add actions for component testing
 */
function gdkc_setup_component_test_actions() {
    add_action('wp_head', 'gdkc_add_component_test_styles');
}
add_action('init', 'gdkc_setup_component_test_actions');

/**
 * Add CSS for component testing
 */
function gdkc_add_component_test_styles() {
    if (is_page_template('page-templates/component-test.php')) {
        ?>
        <style>
            .full-width {
                width: 100%;
                left: 0;
                right: 0;
                margin-left: 0;
                margin-right: 0;
                max-width: 100%;
                position: relative;
            }
            
            .full-width .container {
                max-width: 100%;
                width: 100%;
                padding-left: 0;
                padding-right: 0;
            }
            
            .no-padding {
                padding: 0 !important;
            }
            
            .no-padding .container {
                padding: 0 !important;
            }
            
            /* Display settings in admin bar */
            .component-test-info {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.8);
                color: #fff;
                padding: 10px;
                font-size: 12px;
                z-index: 999999;
                display: flex;
                justify-content: space-between;
            }
            
            .component-test-info__details {
                flex: 1;
            }
            
            .component-test-info__component {
                font-weight: bold;
                margin-right: 15px;
            }
            
            .component-test-info__close {
                cursor: pointer;
                padding: 0 10px;
            }
        </style>
        
        <?php if (isset($_GET['component']) && current_user_can('edit_posts')) : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var body = document.body;
                var infoBar = document.createElement('div');
                infoBar.className = 'component-test-info';
                
                var details = document.createElement('div');
                details.className = 'component-test-info__details';
                
                var componentName = '<?php echo esc_js(isset($_GET['component']) ? $_GET['component'] : ''); ?>';
                var config = '<?php echo esc_js(isset($_GET['config']) ? $_GET['config'] : 'default'); ?>';
                var fullWidth = <?php echo isset($_GET['full_width']) && $_GET['full_width'] ? 'true' : 'false'; ?>;
                var noPadding = <?php echo isset($_GET['no_padding']) && $_GET['no_padding'] ? 'true' : 'false'; ?>;
                var background = '<?php echo esc_js(isset($_GET['background']) ? $_GET['background'] : ''); ?>';
                
                details.innerHTML = 
                    '<span class="component-test-info__component">' + componentName + '</span>' + 
                    '<span class="component-test-info__config">Config: ' + config + '</span>' +
                    (fullWidth ? ' | <span class="component-test-info__fullwidth">Full Width</span>' : '') +
                    (noPadding ? ' | <span class="component-test-info__nopadding">No Padding</span>' : '') +
                    (background ? ' | <span class="component-test-info__background">BG: ' + background + '</span>' : '');
                
                var closeBtn = document.createElement('div');
                closeBtn.className = 'component-test-info__close';
                closeBtn.innerHTML = '✕';
                closeBtn.addEventListener('click', function() {
                    infoBar.style.display = 'none';
                });
                
                infoBar.appendChild(details);
                infoBar.appendChild(closeBtn);
                body.appendChild(infoBar);
            });
        </script>
        <?php endif; ?>
        <?php
    }
}
