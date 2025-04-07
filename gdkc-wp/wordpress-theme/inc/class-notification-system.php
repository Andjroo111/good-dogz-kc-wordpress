<?php
/**
 * Notification System
 *
 * Adds notification system for new assessments and client interactions
 *
 * @package Good_Dogz_KC
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class for handling notification system
 */
class GDKC_Notification_System {
    /**
     * Initialize the class
     */
    public function __construct() {
        // Register notification post type
        add_action('init', [$this, 'register_notification_post_type']);
        
        // Hook into assessment submission
        add_action('acf/save_post', [$this, 'assessment_notification'], 20);
        
        // Add notification count to admin bar
        add_action('admin_bar_menu', [$this, 'add_notification_count_to_admin_bar'], 999);
        
        // Add notification dashboard page
        add_action('admin_menu', [$this, 'add_notification_dashboard']);
        
        // Add AJAX handlers for notification actions
        add_action('wp_ajax_gdkc_mark_notification_read', [$this, 'mark_notification_read']);
        add_action('wp_ajax_gdkc_mark_all_notifications_read', [$this, 'mark_all_notifications_read']);
        
        // Send email notifications
        add_action('gdkc_new_notification', [$this, 'send_email_notification'], 10, 2);
        
        // Register notification scripts
        add_action('admin_enqueue_scripts', [$this, 'enqueue_notification_scripts']);
    }
    
    /**
     * Register notification post type
     */
    public function register_notification_post_type() {
        register_post_type('gdkc_notification', [
            'labels' => [
                'name' => __('Notifications', 'gooddogzkc'),
                'singular_name' => __('Notification', 'gooddogzkc'),
            ],
            'public' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'show_in_admin_bar' => false,
            'supports' => ['title', 'custom-fields'],
            'capabilities' => [
                'create_posts' => 'do_not_allow', // False prevents creation through UI
            ],
            'map_meta_cap' => true, // Maps to prevent creation
        ]);
    }
    
    /**
     * Create notification when assessment is submitted
     */
    public function assessment_notification($post_id) {
        // Only proceed if this is an assessment post type
        if (get_post_type($post_id) !== 'gdkc_assessment') {
            return;
        }
        
        // Check if this is a new post
        $post = get_post($post_id);
        if ($post->post_date !== $post->post_modified) {
            // Not a new post, check if status was updated
            $followup_status = get_post_meta($post_id, 'followup_status', true);
            $old_status = get_post_meta($post_id, 'previous_followup_status', true);
            
            if ($followup_status !== $old_status) {
                // Status was updated, create notification for status change
                $this->create_status_change_notification($post_id, $old_status, $followup_status);
                
                // Update previous status
                update_post_meta($post_id, 'previous_followup_status', $followup_status);
            }
            
            return;
        }
        
        // This is a new assessment, create notification
        $owner_name = get_post_meta($post_id, 'owner_name', true);
        $dog_name = get_post_meta($post_id, 'dog_name', true);
        $email = get_post_meta($post_id, 'email', true);
        
        // Create notification title
        $title = sprintf(
            __('New Assessment: %s for %s', 'gooddogzkc'),
            $owner_name,
            $dog_name
        );
        
        // Create notification content
        $content = sprintf(
            __('A new dog behavior assessment has been submitted by %s for their dog %s. Please review and follow up with the client.', 'gooddogzkc'),
            $owner_name,
            $dog_name
        );
        
        // Create the notification
        $notification_id = $this->create_notification([
            'title' => $title,
            'content' => $content,
            'type' => 'new_assessment',
            'reference_id' => $post_id,
            'priority' => 'high',
        ]);
        
        // Set initial followup status and store it
        update_post_meta($post_id, 'followup_status', 'pending');
        update_post_meta($post_id, 'previous_followup_status', 'pending');
        
        // Trigger email notification
        do_action('gdkc_new_notification', $notification_id, [
            'email_subject' => sprintf(__('New Assessment from %s', 'gooddogzkc'), $owner_name),
            'client_email' => $email,
            'client_name' => $owner_name,
            'dog_name' => $dog_name,
        ]);
    }
    
    /**
     * Create notification for status change
     */
    private function create_status_change_notification($post_id, $old_status, $new_status) {
        $owner_name = get_post_meta($post_id, 'owner_name', true);
        $dog_name = get_post_meta($post_id, 'dog_name', true);
        
        // Get status labels
        $status_labels = [
            'pending' => __('Pending', 'gooddogzkc'),
            'contacted' => __('Contacted', 'gooddogzkc'),
            'booked' => __('Booked', 'gooddogzkc'),
            'no_response' => __('No Response', 'gooddogzkc'),
            'not_interested' => __('Not Interested', 'gooddogzkc'),
        ];
        
        $old_status_label = isset($status_labels[$old_status]) ? $status_labels[$old_status] : $old_status;
        $new_status_label = isset($status_labels[$new_status]) ? $status_labels[$new_status] : $new_status;
        
        // Create notification title
        $title = sprintf(
            __('Assessment Status Changed: %s', 'gooddogzkc'),
            get_the_title($post_id)
        );
        
        // Create notification content
        $content = sprintf(
            __('The status for %s\'s assessment for %s has been updated from "%s" to "%s".', 'gooddogzkc'),
            $owner_name,
            $dog_name,
            $old_status_label,
            $new_status_label
        );
        
        // Set priority based on new status
        $priority = 'normal';
        if ($new_status === 'booked') {
            $priority = 'high';
        }
        
        // Create the notification
        $this->create_notification([
            'title' => $title,
            'content' => $content,
            'type' => 'status_change',
            'reference_id' => $post_id,
            'priority' => $priority,
        ]);
    }
    
    /**
     * Create a new notification
     */
    public function create_notification($args) {
        $defaults = [
            'title' => '',
            'content' => '',
            'type' => 'general',
            'reference_id' => 0,
            'priority' => 'normal',
            'status' => 'unread',
        ];
        
        $args = wp_parse_args($args, $defaults);
        
        // Create notification post
        $notification_id = wp_insert_post([
            'post_title' => $args['title'],
            'post_content' => $args['content'],
            'post_type' => 'gdkc_notification',
            'post_status' => 'publish',
        ]);
        
        if (!is_wp_error($notification_id)) {
            // Add notification meta
            update_post_meta($notification_id, 'notification_type', $args['type']);
            update_post_meta($notification_id, 'reference_id', $args['reference_id']);
            update_post_meta($notification_id, 'priority', $args['priority']);
            update_post_meta($notification_id, 'status', $args['status']);
            
            return $notification_id;
        }
        
        return false;
    }
    
    /**
     * Add notification count to admin bar
     */
    public function add_notification_count_to_admin_bar($admin_bar) {
        if (!current_user_can('edit_posts')) {
            return;
        }
        
        $unread_count = $this->get_unread_notification_count();
        
        if ($unread_count > 0) {
            $admin_bar->add_node([
                'id' => 'gdkc-notifications',
                'title' => sprintf(
                    '<span class="ab-icon dashicons dashicons-bell"></span><span class="ab-label count-%d">%d</span>',
                    $unread_count > 9 ? 'many' : $unread_count,
                    $unread_count
                ),
                'href' => admin_url('admin.php?page=gdkc-notifications'),
                'meta' => [
                    'class' => 'gdkc-notifications-menu',
                    'title' => __('Notifications', 'gooddogzkc'),
                ],
            ]);
            
            // Add dropdown notifications
            $recent_notifications = $this->get_recent_notifications(5);
            
            if (!empty($recent_notifications)) {
                foreach ($recent_notifications as $notification) {
                    $title = get_the_title($notification->ID);
                    $status = get_post_meta($notification->ID, 'status', true);
                    $priority = get_post_meta($notification->ID, 'priority', true);
                    $reference_id = get_post_meta($notification->ID, 'reference_id', true);
                    
                    $admin_bar->add_node([
                        'id' => 'gdkc-notification-' . $notification->ID,
                        'parent' => 'gdkc-notifications',
                        'title' => sprintf(
                            '<span class="notification-item %s %s">%s</span>',
                            $status,
                            $priority,
                            $title
                        ),
                        'href' => $reference_id ? get_edit_post_link($reference_id) : admin_url('admin.php?page=gdkc-notifications'),
                    ]);
                }
                
                // Add view all link
                $admin_bar->add_node([
                    'id' => 'gdkc-notifications-view-all',
                    'parent' => 'gdkc-notifications',
                    'title' => __('View All Notifications', 'gooddogzkc'),
                    'href' => admin_url('admin.php?page=gdkc-notifications'),
                    'meta' => [
                        'class' => 'gdkc-view-all-notifications',
                    ],
                ]);
                
                // Add mark all as read link
                $admin_bar->add_node([
                    'id' => 'gdkc-notifications-mark-read',
                    'parent' => 'gdkc-notifications',
                    'title' => __('Mark All as Read', 'gooddogzkc'),
                    'href' => '#',
                    'meta' => [
                        'class' => 'gdkc-mark-all-read',
                        'onclick' => 'gdkcMarkAllNotificationsRead(); return false;',
                    ],
                ]);
            } else {
                $admin_bar->add_node([
                    'id' => 'gdkc-notifications-none',
                    'parent' => 'gdkc-notifications',
                    'title' => __('No new notifications', 'gooddogzkc'),
                    'meta' => [
                        'class' => 'gdkc-no-notifications',
                    ],
                ]);
            }
        }
    }
    
    /**
     * Add notification dashboard page
     */
    public function add_notification_dashboard() {
        add_menu_page(
            __('Notifications', 'gooddogzkc'),
            __('Notifications', 'gooddogzkc'),
            'edit_posts',
            'gdkc-notifications',
            [$this, 'render_notification_dashboard'],
            'dashicons-bell',
            30
        );
    }
    
    /**
     * Render notification dashboard
     */
    public function render_notification_dashboard() {
        $notifications = $this->get_all_notifications();
        $unread_count = $this->get_unread_notification_count();
        ?>
        <div class="wrap gdkc-notifications-dashboard">
            <h1><?php _e('Notifications', 'gooddogzkc'); ?></h1>
            
            <div class="notification-stats">
                <div class="stat-card">
                    <h3><?php _e('Unread Notifications', 'gooddogzkc'); ?></h3>
                    <div class="stat-value"><?php echo esc_html($unread_count); ?></div>
                </div>
                
                <div class="stat-card">
                    <h3><?php _e('Total Notifications', 'gooddogzkc'); ?></h3>
                    <div class="stat-value"><?php echo count($notifications); ?></div>
                </div>
                
                <div class="stat-actions">
                    <button class="button button-primary" id="gdkc-mark-all-read"><?php _e('Mark All as Read', 'gooddogzkc'); ?></button>
                </div>
            </div>
            
            <div class="notification-filters">
                <select id="notification-filter-type">
                    <option value=""><?php _e('All Types', 'gooddogzkc'); ?></option>
                    <option value="new_assessment"><?php _e('New Assessment', 'gooddogzkc'); ?></option>
                    <option value="status_change"><?php _e('Status Change', 'gooddogzkc'); ?></option>
                    <option value="general"><?php _e('General', 'gooddogzkc'); ?></option>
                </select>
                
                <select id="notification-filter-status">
                    <option value=""><?php _e('All Statuses', 'gooddogzkc'); ?></option>
                    <option value="unread"><?php _e('Unread', 'gooddogzkc'); ?></option>
                    <option value="read"><?php _e('Read', 'gooddogzkc'); ?></option>
                </select>
                
                <select id="notification-filter-priority">
                    <option value=""><?php _e('All Priorities', 'gooddogzkc'); ?></option>
                    <option value="high"><?php _e('High', 'gooddogzkc'); ?></option>
                    <option value="normal"><?php _e('Normal', 'gooddogzkc'); ?></option>
                    <option value="low"><?php _e('Low', 'gooddogzkc'); ?></option>
                </select>
            </div>
            
            <div class="notification-list">
                <?php if (!empty($notifications)) : ?>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th class="column-status"><?php _e('Status', 'gooddogzkc'); ?></th>
                                <th class="column-title"><?php _e('Title', 'gooddogzkc'); ?></th>
                                <th class="column-type"><?php _e('Type', 'gooddogzkc'); ?></th>
                                <th class="column-date"><?php _e('Date', 'gooddogzkc'); ?></th>
                                <th class="column-actions"><?php _e('Actions', 'gooddogzkc'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($notifications as $notification) : 
                                $status = get_post_meta($notification->ID, 'status', true);
                                $type = get_post_meta($notification->ID, 'notification_type', true);
                                $priority = get_post_meta($notification->ID, 'priority', true);
                                $reference_id = get_post_meta($notification->ID, 'reference_id', true);
                                
                                $type_labels = [
                                    'new_assessment' => __('New Assessment', 'gooddogzkc'),
                                    'status_change' => __('Status Change', 'gooddogzkc'),
                                    'general' => __('General', 'gooddogzkc'),
                                ];
                                
                                $type_label = isset($type_labels[$type]) ? $type_labels[$type] : $type;
                            ?>
                                <tr class="notification-row <?php echo esc_attr($status); ?> priority-<?php echo esc_attr($priority); ?>" data-type="<?php echo esc_attr($type); ?>">
                                    <td class="column-status">
                                        <span class="status-indicator <?php echo esc_attr($status); ?>"></span>
                                    </td>
                                    <td class="column-title">
                                        <strong><?php echo esc_html(get_the_title($notification->ID)); ?></strong>
                                        <div class="notification-content">
                                            <?php echo wpautop(esc_html($notification->post_content)); ?>
                                        </div>
                                    </td>
                                    <td class="column-type">
                                        <span class="notification-type <?php echo esc_attr($type); ?>">
                                            <?php echo esc_html($type_label); ?>
                                        </span>
                                        <?php if ($priority === 'high') : ?>
                                            <span class="notification-priority high">
                                                <?php _e('High', 'gooddogzkc'); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="column-date">
                                        <?php echo get_the_date('M j, Y g:i a', $notification->ID); ?>
                                    </td>
                                    <td class="column-actions">
                                        <?php if ($status === 'unread') : ?>
                                            <button class="button button-small mark-read" data-id="<?php echo esc_attr($notification->ID); ?>">
                                                <?php _e('Mark as Read', 'gooddogzkc'); ?>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if ($reference_id) : ?>
                                            <a href="<?php echo get_edit_post_link($reference_id); ?>" class="button button-small">
                                                <?php _e('View Details', 'gooddogzkc'); ?>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="no-items">
                        <p><?php _e('No notifications found.', 'gooddogzkc'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * Mark notification as read via AJAX
     */
    public function mark_notification_read() {
        // Check nonce
        check_ajax_referer('gdkc_notification_actions', 'nonce');
        
        // Check permissions
        if (!current_user_can('edit_posts')) {
            wp_send_json_error(['message' => __('Permission denied.', 'gooddogzkc')]);
        }
        
        $notification_id = isset($_POST['notification_id']) ? intval($_POST['notification_id']) : 0;
        
        if ($notification_id) {
            update_post_meta($notification_id, 'status', 'read');
            wp_send_json_success(['message' => __('Notification marked as read.', 'gooddogzkc')]);
        }
        
        wp_send_json_error(['message' => __('Invalid notification ID.', 'gooddogzkc')]);
    }
    
    /**
     * Mark all notifications as read via AJAX
     */
    public function mark_all_notifications_read() {
        // Check nonce
        check_ajax_referer('gdkc_notification_actions', 'nonce');
        
        // Check permissions
        if (!current_user_can('edit_posts')) {
            wp_send_json_error(['message' => __('Permission denied.', 'gooddogzkc')]);
        }
        
        // Get all unread notifications
        $unread_notifications = get_posts([
            'post_type' => 'gdkc_notification',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => 'status',
                    'value' => 'unread',
                ],
            ],
        ]);
        
        // Mark all as read
        foreach ($unread_notifications as $notification) {
            update_post_meta($notification->ID, 'status', 'read');
        }
        
        wp_send_json_success([
            'message' => sprintf(
                __('%d notifications marked as read.', 'gooddogzkc'),
                count($unread_notifications)
            ),
        ]);
    }
    
    /**
     * Send email notification
     */
    public function send_email_notification($notification_id, $data) {
        // Get admin email
        $admin_email = get_option('admin_email');
        
        // Get company name
        $company_name = get_field('company_name', 'option') ?: get_bloginfo('name');
        
        // Set email subject
        $subject = isset($data['email_subject']) ? $data['email_subject'] : __('New Notification', 'gooddogzkc');
        
        // Get notification details
        $notification = get_post($notification_id);
        $notification_type = get_post_meta($notification_id, 'notification_type', true);
        $reference_id = get_post_meta($notification_id, 'reference_id', true);
        
        // Build email body
        $body = $notification->post_content . "\n\n";
        
        // Add link to view details
        if ($reference_id) {
            $body .= sprintf(
                __('View details: %s', 'gooddogzkc'),
                admin_url('post.php?post=' . $reference_id . '&action=edit')
            ) . "\n\n";
        }
        
        // Add footer
        $body .= sprintf(
            __('This notification was sent from %s.', 'gooddogzkc'),
            $company_name
        );
        
        // Send email
        wp_mail($admin_email, $subject, $body);
        
        // Send confirmation email to client for new assessments
        if ($notification_type === 'new_assessment' && isset($data['client_email']) && !empty($data['client_email'])) {
            $this->send_client_confirmation_email($data);
        }
    }
    
    /**
     * Send confirmation email to client
     */
    private function send_client_confirmation_email($data) {
        // Check for required fields
        if (!isset($data['client_email']) || empty($data['client_email'])) {
            return;
        }
        
        $client_email = $data['client_email'];
        $client_name = isset($data['client_name']) ? $data['client_name'] : '';
        $dog_name = isset($data['dog_name']) ? $data['dog_name'] : '';
        
        // Get company info
        $company_name = get_field('company_name', 'option') ?: get_bloginfo('name');
        $company_email = get_field('company_email', 'option') ?: get_option('admin_email');
        $company_phone = get_field('company_phone', 'option') ?: '';
        
        // Set email subject
        $subject = sprintf(
            __('Thank you for your assessment submission - %s', 'gooddogzkc'),
            $company_name
        );
        
        // Build email body
        $body = sprintf(
            __('Dear %s,', 'gooddogzkc'),
            $client_name
        ) . "\n\n";
        
        $body .= sprintf(
            __('Thank you for submitting a behavior assessment for %s. We have received your submission and will review it shortly.', 'gooddogzkc'),
            $dog_name
        ) . "\n\n";
        
        $body .= __('One of our trainers will contact you within 1-2 business days to discuss your assessment results and recommend a training program that best fits your needs.', 'gooddogzkc') . "\n\n";
        
        $body .= __('If you have any questions in the meantime, please feel free to contact us:', 'gooddogzkc') . "\n";
        
        if ($company_phone) {
            $body .= sprintf(
                __('Phone: %s', 'gooddogzkc'),
                $company_phone
            ) . "\n";
        }
        
        $body .= sprintf(
            __('Email: %s', 'gooddogzkc'),
            $company_email
        ) . "\n\n";
        
        $body .= sprintf(
            __('Thank you for choosing %s for your dog training needs.', 'gooddogzkc'),
            $company_name
        ) . "\n\n";
        
        $body .= __('Warm regards,', 'gooddogzkc') . "\n";
        $body .= $company_name;
        
        // Send email
        $headers = ['From: ' . $company_name . ' <' . $company_email . '>'];
        wp_mail($client_email, $subject, $body, $headers);
    }
    
    /**
     * Enqueue notification scripts
     */
    public function enqueue_notification_scripts($hook) {
        // Only enqueue on notification page or admin area
        if ($hook === 'toplevel_page_gdkc-notifications' || true) {
            wp_enqueue_style(
                'gdkc-notifications-style',
                get_stylesheet_directory_uri() . '/assets/css/admin-notifications.css',
                [],
                '1.0.0'
            );
            
            wp_enqueue_script(
                'gdkc-notifications-script',
                get_stylesheet_directory_uri() . '/assets/js/admin-notifications.js',
                ['jquery'],
                '1.0.0',
                true
            );
            
            wp_localize_script(
                'gdkc-notifications-script',
                'gdkcNotifications',
                [
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('gdkc_notification_actions'),
                    'markReadText' => __('Mark as Read', 'gooddogzkc'),
                    'markAllReadText' => __('Mark All as Read', 'gooddogzkc'),
                    'markingReadText' => __('Marking...', 'gooddogzkc'),
                ]
            );
        }
    }
    
    /**
     * Get unread notification count
     */
    public function get_unread_notification_count() {
        $count_query = new WP_Query([
            'post_type' => 'gdkc_notification',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_query' => [
                [
                    'key' => 'status',
                    'value' => 'unread',
                ],
            ],
        ]);
        
        return $count_query->found_posts;
    }
    
    /**
     * Get recent notifications
     */
    public function get_recent_notifications($count = 5) {
        return get_posts([
            'post_type' => 'gdkc_notification',
            'posts_per_page' => $count,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_query' => [
                [
                    'key' => 'status',
                    'value' => 'unread',
                ],
            ],
        ]);
    }
    
    /**
     * Get all notifications
     */
    public function get_all_notifications() {
        return get_posts([
            'post_type' => 'gdkc_notification',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);
    }
}

// Initialize the class
new GDKC_Notification_System();