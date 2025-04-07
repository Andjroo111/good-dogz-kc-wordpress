<?php
/**
 * Template Name: Component Test
 * Description: A template for testing components in different configurations
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" role="main">
    
    <?php if (is_page() && !post_password_required()) : ?>
        
        <section class="component-test-controls">
            <div class="container">
                <h1><?php the_title(); ?></h1>
                
                <?php if (current_user_can('edit_posts')) : ?>
                    <div class="component-test-panel">
                        <h2>Component Testing Controls</h2>
                        <p class="description">This panel is only visible to logged-in users with edit capabilities.</p>
                        
                        <form id="component-test-form" method="get">
                            <div class="form-group">
                                <label for="component">Select Component:</label>
                                <select id="component" name="component">
                                    <option value="">Select a component...</option>
                                    <?php
                                    $components = gdkc_get_home_components();
                                    foreach ($components as $key => $label) {
                                        $selected = isset($_GET['component']) && $_GET['component'] === $key ? 'selected' : '';
                                        echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($label) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="config">Configuration:</label>
                                <select id="config" name="config">
                                    <option value="default" <?php selected(isset($_GET['config']) ? $_GET['config'] : '', 'default'); ?>>Default</option>
                                    <option value="custom" <?php selected(isset($_GET['config']) ? $_GET['config'] : '', 'custom'); ?>>Custom</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="background">Background Color:</label>
                                <input type="text" id="background" name="background" 
                                       value="<?php echo isset($_GET['background']) ? esc_attr($_GET['background']) : ''; ?>" 
                                       placeholder="#ffffff">
                            </div>
                            
                            <div class="form-group">
                                <label>Layout Options:</label>
                                
                                <label class="checkbox">
                                    <input type="checkbox" name="full_width" value="1" 
                                           <?php checked(isset($_GET['full_width']) ? $_GET['full_width'] : '', '1'); ?>>
                                    Full Width
                                </label>
                                
                                <label class="checkbox">
                                    <input type="checkbox" name="no_padding" value="1" 
                                           <?php checked(isset($_GET['no_padding']) ? $_GET['no_padding'] : '', '1'); ?>>
                                    No Padding
                                </label>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="button button-primary">Update Preview</button>
                                <a href="<?php echo esc_url(remove_query_arg(['component', 'config', 'background', 'full_width', 'no_padding'])); ?>" class="button">Reset</a>
                            </div>
                        </form>
                    </div>
                    
                    <style>
                        .component-test-controls {
                            padding: 20px;
                            background: #f8f8f8;
                            margin-bottom: 30px;
                            border: 1px solid #ddd;
                        }
                        .component-test-panel {
                            background: #fff;
                            padding: 20px;
                            border: 1px solid #ddd;
                            border-radius: 3px;
                        }
                        .form-group {
                            margin-bottom: 15px;
                        }
                        .form-group label {
                            display: block;
                            margin-bottom: 5px;
                            font-weight: bold;
                        }
                        .form-group select,
                        .form-group input[type="text"] {
                            width: 100%;
                            padding: 8px;
                            border: 1px solid #ddd;
                            border-radius: 3px;
                        }
                        .checkbox {
                            display: block;
                            margin-bottom: 5px;
                            font-weight: normal;
                        }
                        .form-actions {
                            margin-top: 20px;
                        }
                        .component-preview {
                            margin-top: 30px;
                            border: 2px dashed #ddd;
                            position: relative;
                        }
                        .component-preview::before {
                            content: 'Component Preview';
                            position: absolute;
                            top: -12px;
                            left: 20px;
                            background: #fff;
                            padding: 0 10px;
                            font-size: 14px;
                            color: #666;
                        }
                    </style>
                <?php endif; ?>
                
                <?php if (isset($_GET['component']) && !empty($_GET['component'])) : ?>
                    <div class="component-preview">
                        <?php
                        $component = sanitize_text_field($_GET['component']);
                        $config = isset($_GET['config']) ? sanitize_text_field($_GET['config']) : 'default';
                        $background = isset($_GET['background']) ? sanitize_text_field($_GET['background']) : '';
                        $full_width = isset($_GET['full_width']) ? (bool) $_GET['full_width'] : false;
                        $no_padding = isset($_GET['no_padding']) ? (bool) $_GET['no_padding'] : false;
                        
                        // Set temporary post meta for the component if using custom config
                        if ($config === 'custom') {
                            // Create test settings array
                            $test_settings = [
                                'title' => 'Test Title for ' . ucfirst(str_replace('-', ' ', $component)),
                                'subtitle' => 'Test Subtitle for Component Configuration',
                                'content' => 'This is test content for the ' . ucfirst(str_replace('-', ' ', $component)) . ' component. It demonstrates how the component looks with custom settings applied through the component configuration system.',
                                'background' => $background
                            ];
                            
                            // Add component-specific test settings
                            switch ($component) {
                                case 'hero':
                                    $test_settings['button_text'] = 'Test CTA Button';
                                    $test_settings['button_url'] = '#test-cta';
                                    $test_settings['background_type'] = !empty($background) ? 'color' : 'default';
                                    break;
                                    
                                case 'testimonials':
                                    $test_settings['layout'] = 'grid';
                                    $test_settings['per_page'] = 3;
                                    $test_settings['show_rating'] = true;
                                    $test_settings['show_image'] = true;
                                    break;
                                    
                                case 'programs':
                                    $test_settings['layout'] = 'grid';
                                    $test_settings['per_page'] = 3;
                                    $test_settings['show_pricing'] = true;
                                    $test_settings['show_cta'] = true;
                                    break;
                                    
                                default:
                                    // Default test settings
                                    break;
                            }
                            
                            // Temporarily set the settings for this page
                            update_post_meta(get_the_ID(), '_gdkc_' . $component . '_settings', $test_settings);
                        }
                        
                        // Apply custom layout classes if needed
                        if ($full_width || $no_padding) {
                            add_action('gdkc_before_component', function($comp) use ($component, $full_width, $no_padding) {
                                if ($comp === $component) {
                                    $classes = [];
                                    if ($full_width) $classes[] = 'full-width';
                                    if ($no_padding) $classes[] = 'no-padding';
                                    echo '<div class="' . esc_attr(implode(' ', $classes)) . '">';
                                }
                            });
                            
                            add_action('gdkc_after_component', function($comp) use ($component) {
                                if ($comp === $component) {
                                    echo '</div>';
                                }
                            });
                        }
                        
                        // Fire action before component (for adding wrapper classes)
                        do_action('gdkc_before_component', $component);
                        
                        // Load the component
                        gdkc_load_home_component($component);
                        
                        // Fire action after component
                        do_action('gdkc_after_component', $component);
                        
                        // Clean up temporary meta if using custom config
                        if ($config === 'custom') {
                            delete_post_meta(get_the_ID(), '_gdkc_' . $component . '_settings');
                        }
                        ?>
                    </div>
                <?php else : ?>
                    <?php if (current_user_can('edit_posts')) : ?>
                        <div class="component-placeholder">
                            <p>Select a component to preview it here.</p>
                        </div>
                        
                        <style>
                            .component-placeholder {
                                padding: 50px;
                                text-align: center;
                                background: #f8f8f8;
                                border: 2px dashed #ddd;
                                margin-top: 30px;
                            }
                            .component-placeholder p {
                                color: #666;
                                font-size: 18px;
                                margin: 0;
                            }
                        </style>
                    <?php endif; ?>
                    
                    <?php the_content(); ?>
                <?php endif; ?>
            </div>
        </section>
        
    <?php else : ?>
        
        <section class="page-content">
            <div class="container">
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                
                <div class="page-content-inner">
                    <?php
                    if (post_password_required()) {
                        echo get_the_password_form();
                    } else {
                        the_content();
                    }
                    ?>
                </div>
            </div>
        </section>
        
    <?php endif; ?>
    
</main>

<?php
get_footer();
?>