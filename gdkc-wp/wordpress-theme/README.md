# Good Dogz KC - WordPress Child Theme

A custom WordPress child theme for Good Dogz KC based on the Twenty Twenty-Four theme.

## Overview

This WordPress child theme provides a complete branding and functionality implementation for the Good Dogz KC website, including:

- Custom post types for dog training programs, service packages, success stories, and resources
- Dog Assessment Tool for matching clients with appropriate training programs
- Rescue Matching Tool for pairing adoptable dogs with potential owners
- Comprehensive UI components following brand guidelines
- Custom page templates for different sections of the site

## Theme Structure

```
/wordpress-theme/
├── assets/                  # Theme assets
│   ├── css/                 # Stylesheets
│   │   ├── components/      # Component styles
│   │   └── sections/        # Section-specific styles
│   ├── js/                  # JavaScript files
│   │   └── components/      # Component scripts
│   ├── fonts/               # Typography
│   ├── images/              # Images
│   ├── videos/              # Video content
│   └── branding/            # Core branding assets
├── content/                 # Content files
├── inc/                     # PHP includes
│   ├── tools/               # Custom tools (Assessment, Matching)
│   └── blocks/              # Block implementations
├── includes/                # Template functions
├── page-templates/          # Page templates
├── template-parts/          # Template components
│   ├── global/              # Global components
│   └── home/                # Homepage sections
├── style.css                # Theme stylesheet
├── functions.php            # Theme functions
├── header.php               # Header template
└── footer.php               # Footer template
```

## Development

### Local Development
- Local WordPress environment: http://good-dogz-kc.local
- Theme location: `/Users/andrjoo/Local Sites/good-dogz-kc/app/public/wp-content/themes/gooddogzkc-theme`

### GitHub Repository
- Repository: [Andjroo111/good-dogz-kc-wordpress](https://github.com/Andjroo111/good-dogz-kc-wordpress)
- Branch structure:
  - `main`: Primary branch with all project files
  - Future planned branches:
    - `develop`: Development and testing
    - `feature/*`: Feature branches

## Custom Post Types

- **Training Programs** (`gdkc_training`): Dog training programs and services
- **Service Packages** (`gdkc_package`): Service packages with pricing
- **Success Stories** (`gdkc_success`): Client testimonials and success stories
- **Training Resources** (`gdkc_resource`): Educational resources and guides
- **Service Areas** (`gdkc_service_area`): Geographic service areas

## Custom Tools

- **Dog Assessment Tool**: Client questionnaire for matching with appropriate training programs
- **Rescue Matching Tool**: System for matching adoptable dogs with potential owners

## Required Plugins

- Advanced Custom Fields (ACF) Pro
- Rank Math SEO
- WP Rocket (recommended for performance)
