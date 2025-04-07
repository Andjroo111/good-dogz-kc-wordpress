# Lava Lamp Animation for Good Dogz KC

This directory contains files related to the lava lamp animation effect used throughout the Good Dogz KC website.

## Files

- `lava-animation.html`: Original standalone HTML demo (for reference only)
- `lava-animation-example.html`: Example of how to use the standalone JavaScript file
- `../lava-lamp.js`: The extracted JavaScript file that can be used in WordPress

## WordPress Integration

To properly integrate the lava lamp effect into your WordPress theme, follow these steps:

### 1. Enqueue the JavaScript file

Add this to your child theme's `functions.php`:

```php
/**
 * Enqueue lava lamp animation script
 */
function gooddogzkc_enqueue_scripts() {
    // Enqueue lava lamp animation
    wp_enqueue_script(
        'gooddogzkc-lava-lamp', 
        get_stylesheet_directory_uri() . '/assets/js/lava-lamp.js', 
        array(), 
        filemtime(get_stylesheet_directory() . '/assets/js/lava-lamp.js'), 
        true
    );
}
add_action('wp_enqueue_scripts', 'gooddogzkc_enqueue_scripts');
```

### 2. Add the animation to elements in your templates

Simply add the `gdkc-lava-container` class to any container where you want the animation. For example, in your header:

```html
<div class="site-header gdkc-lava-container">
    <div class="site-branding">
        <!-- Your header content here -->
    </div>
</div>
```

### 3. Customize colors (optional)

You can customize the animation colors using data attributes:

```html
<div class="hero-section gdkc-lava-container" 
     data-gdkc-lava-color-outer="#a08cff" 
     data-gdkc-lava-color-mid="#6a3ad6" 
     data-gdkc-lava-color-inner="#4b0082"
     data-gdkc-lava-bg="#0a0a2a">
    <!-- Content here -->
</div>
```

Available attributes:
- `data-gdkc-lava-color-outer`: Outer gradient color (default: #a08cff)
- `data-gdkc-lava-color-mid`: Middle gradient color (default: #6a3ad6)
- `data-gdkc-lava-color-inner`: Inner gradient color (default: #4b0082)
- `data-gdkc-lava-bg`: Background color (default: #0a0a2a)

## Using in Page Templates

You can add the animation to any page template or section by:

1. Adding the `gdkc-lava-container` class to the container
2. Making sure the container has:
   - Position relative (or absolute/fixed)
   - A defined height
   - Overflow hidden

## Performance Notes

The animation uses modern CSS and JavaScript techniques for good performance, but consider the following:

- Don't use too many animated containers on a single page
- For very large layouts, consider using a reduced number of particles
- The animation automatically adjusts based on container width for responsive designs

## Browser Compatibility

The animation works in all modern browsers (Chrome, Firefox, Safari, Edge).