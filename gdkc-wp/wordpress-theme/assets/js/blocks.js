/**
 * Custom Gutenberg Blocks for Good Dogz KC
 */

const { registerBlockType } = wp.blocks;
const { InspectorControls, useBlockProps } = wp.blockEditor;
const { PanelBody, ToggleControl, RangeControl, SelectControl, TextControl } = wp.components;
const { Fragment } = wp.element;
const { __ } = wp.i18n;

/**
 * Service Areas Block
 */
registerBlockType('gooddogzkc/service-areas', {
    title: __('Service Areas', 'gooddogzkc'),
    icon: 'location-alt',
    category: 'gooddogzkc',
    attributes: {
        title: {
            type: 'string',
            default: 'Our Service Areas',
        },
        showMap: {
            type: 'boolean',
            default: true,
        },
        numAreas: {
            type: 'number',
            default: 6,
        },
        regionFilter: {
            type: 'string',
            default: '',
        },
        alignment: {
            type: 'string',
            default: 'center',
        },
    },
    
    edit: function(props) {
        const { attributes, setAttributes } = props;
        const { title, showMap, numAreas, regionFilter, alignment } = attributes;
        
        const blockProps = useBlockProps({
            className: `gdkc-service-areas-block align-${alignment}`,
        });
        
        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody title={__('Service Areas Settings', 'gooddogzkc')}>
                        <TextControl
                            label={__('Block Title', 'gooddogzkc')}
                            value={title}
                            onChange={(value) => setAttributes({ title: value })}
                        />
                        
                        <ToggleControl
                            label={__('Show Map', 'gooddogzkc')}
                            checked={showMap}
                            onChange={() => setAttributes({ showMap: !showMap })}
                        />
                        
                        <RangeControl
                            label={__('Number of Areas to Display', 'gooddogzkc')}
                            value={numAreas}
                            onChange={(value) => setAttributes({ numAreas: value })}
                            min={1}
                            max={24}
                        />
                        
                        <TextControl
                            label={__('Region Filter (slug)', 'gooddogzkc')}
                            value={regionFilter}
                            onChange={(value) => setAttributes({ regionFilter: value })}
                            help={__('Enter a region category slug to filter areas', 'gooddogzkc')}
                        />
                        
                        <SelectControl
                            label={__('Alignment', 'gooddogzkc')}
                            value={alignment}
                            options={[
                                { label: __('Left', 'gooddogzkc'), value: 'left' },
                                { label: __('Center', 'gooddogzkc'), value: 'center' },
                                { label: __('Right', 'gooddogzkc'), value: 'right' },
                            ]}
                            onChange={(value) => setAttributes({ alignment: value })}
                        />
                    </PanelBody>
                </InspectorControls>
                
                <div {...blockProps}>
                    <div className="block-editor-preview">
                        <h2 className="gdkc-block-title">{title}</h2>
                        
                        {showMap && (
                            <div className="gdkc-areas-map">
                                <div className="service-map-placeholder">
                                    <span className="dashicons dashicons-location-alt"></span>
                                    <p>{__('Service Areas Map will display here', 'gooddogzkc')}</p>
                                </div>
                            </div>
                        )}
                        
                        <div className="gdkc-areas-grid-placeholder">
                            <div className="area-card-placeholder"></div>
                            <div className="area-card-placeholder"></div>
                            <div className="area-card-placeholder"></div>
                        </div>
                        
                        <p className="editor-note">{__(`Displaying ${numAreas} service areas`, 'gooddogzkc')}{regionFilter ? ` from region "${regionFilter}"` : ''}</p>
                    </div>
                </div>
            </Fragment>
        );
    },
    
    save: function() {
        // Dynamic block, render through PHP callback
        return null;
    },
});

/**
 * Testimonials Block
 */
registerBlockType('gooddogzkc/testimonials', {
    title: __('Testimonials', 'gooddogzkc'),
    icon: 'format-quote',
    category: 'gooddogzkc',
    attributes: {
        title: {
            type: 'string',
            default: 'What Our Clients Say',
        },
        layout: {
            type: 'string',
            default: 'slider',
        },
        numPosts: {
            type: 'number',
            default: 3,
        },
        showImage: {
            type: 'boolean',
            default: true,
        },
        showRating: {
            type: 'boolean',
            default: true,
        },
        breedFilter: {
            type: 'string',
            default: '',
        },
        issueFilter: {
            type: 'string',
            default: '',
        },
        alignment: {
            type: 'string',
            default: 'center',
        },
    },
    
    edit: function(props) {
        const { attributes, setAttributes } = props;
        const { title, layout, numPosts, showImage, showRating, breedFilter, issueFilter, alignment } = attributes;
        
        const blockProps = useBlockProps({
            className: `gdkc-testimonials-block layout-${layout} align-${alignment}`,
        });
        
        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody title={__('Testimonials Settings', 'gooddogzkc')}>
                        <TextControl
                            label={__('Block Title', 'gooddogzkc')}
                            value={title}
                            onChange={(value) => setAttributes({ title: value })}
                        />
                        
                        <SelectControl
                            label={__('Layout', 'gooddogzkc')}
                            value={layout}
                            options={[
                                { label: __('Slider', 'gooddogzkc'), value: 'slider' },
                                { label: __('Grid', 'gooddogzkc'), value: 'grid' },
                            ]}
                            onChange={(value) => setAttributes({ layout: value })}
                        />
                        
                        <RangeControl
                            label={__('Number of Testimonials', 'gooddogzkc')}
                            value={numPosts}
                            onChange={(value) => setAttributes({ numPosts: value })}
                            min={1}
                            max={10}
                        />
                        
                        <ToggleControl
                            label={__('Show Image', 'gooddogzkc')}
                            checked={showImage}
                            onChange={() => setAttributes({ showImage: !showImage })}
                        />
                        
                        <ToggleControl
                            label={__('Show Rating', 'gooddogzkc')}
                            checked={showRating}
                            onChange={() => setAttributes({ showRating: !showRating })}
                        />
                        
                        <TextControl
                            label={__('Filter by Dog Breed (slug)', 'gooddogzkc')}
                            value={breedFilter}
                            onChange={(value) => setAttributes({ breedFilter: value })}
                        />
                        
                        <TextControl
                            label={__('Filter by Issue Addressed (slug)', 'gooddogzkc')}
                            value={issueFilter}
                            onChange={(value) => setAttributes({ issueFilter: value })}
                        />
                        
                        <SelectControl
                            label={__('Alignment', 'gooddogzkc')}
                            value={alignment}
                            options={[
                                { label: __('Left', 'gooddogzkc'), value: 'left' },
                                { label: __('Center', 'gooddogzkc'), value: 'center' },
                                { label: __('Right', 'gooddogzkc'), value: 'right' },
                            ]}
                            onChange={(value) => setAttributes({ alignment: value })}
                        />
                    </PanelBody>
                </InspectorControls>
                
                <div {...blockProps}>
                    <div className="block-editor-preview">
                        <h2 className="gdkc-block-title">{title}</h2>
                        
                        <div className={`testimonials-container testimonials-${layout}`}>
                            <div className="testimonial-item-placeholder">
                                {showImage && (
                                    <div className="testimonial-image-placeholder"></div>
                                )}
                                
                                <div className="testimonial-content-placeholder">
                                    {showRating && (
                                        <div className="rating-placeholder">
                                            ★★★★★
                                        </div>
                                    )}
                                    
                                    <div className="testimonial-text-placeholder"></div>
                                    <div className="testimonial-author-placeholder"></div>
                                </div>
                            </div>
                        </div>
                        
                        <p className="editor-note">
                            {__(`Displaying ${numPosts} testimonials`, 'gooddogzkc')}
                            {breedFilter ? ` for breed "${breedFilter}"` : ''}
                            {issueFilter ? ` addressing "${issueFilter}"` : ''}
                        </p>
                    </div>
                </div>
            </Fragment>
        );
    },
    
    save: function() {
        // Dynamic block, render through PHP callback
        return null;
    },
});

/**
 * Service Packages Block
 */
registerBlockType('gooddogzkc/service-packages', {
    title: __('Service Packages', 'gooddogzkc'),
    icon: 'tag',
    category: 'gooddogzkc',
    attributes: {
        title: {
            type: 'string',
            default: 'Our Training Packages',
        },
        layout: {
            type: 'string',
            default: 'grid',
        },
        numPackages: {
            type: 'number',
            default: 3,
        },
        packageType: {
            type: 'string',
            default: '',
        },
        showPrice: {
            type: 'boolean',
            default: true,
        },
        showButton: {
            type: 'boolean',
            default: true,
        },
        buttonText: {
            type: 'string',
            default: 'Learn More',
        },
        alignment: {
            type: 'string',
            default: 'center',
        },
    },
    
    edit: function(props) {
        const { attributes, setAttributes } = props;
        const { title, layout, numPackages, packageType, showPrice, showButton, buttonText, alignment } = attributes;
        
        const blockProps = useBlockProps({
            className: `gdkc-service-packages-block layout-${layout} align-${alignment}`,
        });
        
        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody title={__('Service Packages Settings', 'gooddogzkc')}>
                        <TextControl
                            label={__('Block Title', 'gooddogzkc')}
                            value={title}
                            onChange={(value) => setAttributes({ title: value })}
                        />
                        
                        <SelectControl
                            label={__('Layout', 'gooddogzkc')}
                            value={layout}
                            options={[
                                { label: __('Grid', 'gooddogzkc'), value: 'grid' },
                                { label: __('List', 'gooddogzkc'), value: 'list' },
                            ]}
                            onChange={(value) => setAttributes({ layout: value })}
                        />
                        
                        <RangeControl
                            label={__('Number of Packages', 'gooddogzkc')}
                            value={numPackages}
                            onChange={(value) => setAttributes({ numPackages: value })}
                            min={1}
                            max={9}
                        />
                        
                        <TextControl
                            label={__('Package Type Filter (slug)', 'gooddogzkc')}
                            value={packageType}
                            onChange={(value) => setAttributes({ packageType: value })}
                        />
                        
                        <ToggleControl
                            label={__('Show Price', 'gooddogzkc')}
                            checked={showPrice}
                            onChange={() => setAttributes({ showPrice: !showPrice })}
                        />
                        
                        <ToggleControl
                            label={__('Show Button', 'gooddogzkc')}
                            checked={showButton}
                            onChange={() => setAttributes({ showButton: !showButton })}
                        />
                        
                        {showButton && (
                            <TextControl
                                label={__('Button Text', 'gooddogzkc')}
                                value={buttonText}
                                onChange={(value) => setAttributes({ buttonText: value })}
                            />
                        )}
                        
                        <SelectControl
                            label={__('Alignment', 'gooddogzkc')}
                            value={alignment}
                            options={[
                                { label: __('Left', 'gooddogzkc'), value: 'left' },
                                { label: __('Center', 'gooddogzkc'), value: 'center' },
                                { label: __('Right', 'gooddogzkc'), value: 'right' },
                            ]}
                            onChange={(value) => setAttributes({ alignment: value })}
                        />
                    </PanelBody>
                </InspectorControls>
                
                <div {...blockProps}>
                    <div className="block-editor-preview">
                        <h2 className="gdkc-block-title">{title}</h2>
                        
                        <div className={`packages-container packages-${layout}`}>
                            <div className="package-card-placeholder">
                                <div className="package-image-placeholder"></div>
                                <div className="package-content-placeholder">
                                    <div className="package-title-placeholder"></div>
                                    {showPrice && (
                                        <div className="package-price-placeholder"></div>
                                    )}
                                    <div className="package-description-placeholder"></div>
                                    {showButton && (
                                        <div className="package-button-placeholder">{buttonText}</div>
                                    )}
                                </div>
                            </div>
                        </div>
                        
                        <p className="editor-note">
                            {__(`Displaying ${numPackages} packages`, 'gooddogzkc')}
                            {packageType ? ` of type "${packageType}"` : ''}
                        </p>
                    </div>
                </div>
            </Fragment>
        );
    },
    
    save: function() {
        // Dynamic block, render through PHP callback
        return null;
    },
});

/**
 * Training Tips Block
 */
registerBlockType('gooddogzkc/training-tips', {
    title: __('Training Tips', 'gooddogzkc'),
    icon: 'book-alt',
    category: 'gooddogzkc',
    attributes: {
        title: {
            type: 'string',
            default: 'Training Tips',
        },
        numPosts: {
            type: 'number',
            default: 3,
        },
        category: {
            type: 'string',
            default: '',
        },
        showExcerpt: {
            type: 'boolean',
            default: true,
        },
        showImage: {
            type: 'boolean',
            default: true,
        },
        buttonText: {
            type: 'string',
            default: 'Read More',
        },
    },
    
    edit: function(props) {
        const { attributes, setAttributes } = props;
        const { title, numPosts, category, showExcerpt, showImage, buttonText } = attributes;
        
        const blockProps = useBlockProps({
            className: 'gdkc-training-tips-block',
        });
        
        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody title={__('Training Tips Settings', 'gooddogzkc')}>
                        <TextControl
                            label={__('Block Title', 'gooddogzkc')}
                            value={title}
                            onChange={(value) => setAttributes({ title: value })}
                        />
                        
                        <RangeControl
                            label={__('Number of Tips', 'gooddogzkc')}
                            value={numPosts}
                            onChange={(value) => setAttributes({ numPosts: value })}
                            min={1}
                            max={9}
                        />
                        
                        <TextControl
                            label={__('Category Filter (slug)', 'gooddogzkc')}
                            value={category}
                            onChange={(value) => setAttributes({ category: value })}
                        />
                        
                        <ToggleControl
                            label={__('Show Excerpt', 'gooddogzkc')}
                            checked={showExcerpt}
                            onChange={() => setAttributes({ showExcerpt: !showExcerpt })}
                        />
                        
                        <ToggleControl
                            label={__('Show Image', 'gooddogzkc')}
                            checked={showImage}
                            onChange={() => setAttributes({ showImage: !showImage })}
                        />
                        
                        <TextControl
                            label={__('Button Text', 'gooddogzkc')}
                            value={buttonText}
                            onChange={(value) => setAttributes({ buttonText: value })}
                        />
                    </PanelBody>
                </InspectorControls>
                
                <div {...blockProps}>
                    <div className="block-editor-preview">
                        <h2 className="gdkc-block-title">{title}</h2>
                        
                        <div className="tips-grid">
                            <div className="tip-card-placeholder">
                                {showImage && (
                                    <div className="tip-image-placeholder"></div>
                                )}
                                <div className="tip-content-placeholder">
                                    <div className="tip-title-placeholder"></div>
                                    <div className="tip-meta-placeholder"></div>
                                    {showExcerpt && (
                                        <div className="tip-excerpt-placeholder"></div>
                                    )}
                                    <div className="tip-button-placeholder">{buttonText}</div>
                                </div>
                            </div>
                        </div>
                        
                        <p className="editor-note">
                            {__(`Displaying ${numPosts} training tips`, 'gooddogzkc')}
                            {category ? ` from category "${category}"` : ''}
                        </p>
                    </div>
                </div>
            </Fragment>
        );
    },
    
    save: function() {
        // Dynamic block, render through PHP callback
        return null;
    },
});

/**
 * Assessment Form Block
 */
registerBlockType('gooddogzkc/assessment-form', {
    title: __('Assessment Form', 'gooddogzkc'),
    icon: 'clipboard',
    category: 'gooddogzkc',
    attributes: {
        title: {
            type: 'string',
            default: 'Dog Behavior Assessment',
        },
        description: {
            type: 'string',
            default: 'Complete our assessment form to receive personalized training recommendations.',
        },
        buttonText: {
            type: 'string',
            default: 'Start Assessment',
        },
        successMessage: {
            type: 'string',
            default: 'Thank you! Your assessment has been submitted successfully.',
        },
    },
    
    edit: function(props) {
        const { attributes, setAttributes } = props;
        const { title, description, buttonText, successMessage } = attributes;
        
        const blockProps = useBlockProps({
            className: 'gdkc-assessment-form-block',
        });
        
        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody title={__('Assessment Form Settings', 'gooddogzkc')}>
                        <TextControl
                            label={__('Form Title', 'gooddogzkc')}
                            value={title}
                            onChange={(value) => setAttributes({ title: value })}
                        />
                        
                        <TextControl
                            label={__('Description', 'gooddogzkc')}
                            value={description}
                            onChange={(value) => setAttributes({ description: value })}
                        />
                        
                        <TextControl
                            label={__('Button Text', 'gooddogzkc')}
                            value={buttonText}
                            onChange={(value) => setAttributes({ buttonText: value })}
                        />
                        
                        <TextControl
                            label={__('Success Message', 'gooddogzkc')}
                            value={successMessage}
                            onChange={(value) => setAttributes({ successMessage: value })}
                        />
                    </PanelBody>
                </InspectorControls>
                
                <div {...blockProps}>
                    <div className="block-editor-preview">
                        <div className="assessment-form-container">
                            <h2 className="form-title">{title}</h2>
                            
                            <div className="form-description">
                                <p>{description}</p>
                            </div>
                            
                            <div className="assessment-cta">
                                <div className="assessment-button-placeholder">{buttonText}</div>
                                <p className="cta-note">Takes about 5-10 minutes to complete</p>
                            </div>
                            
                            <div className="assessment-benefits">
                                <h3>What You'll Get:</h3>
                                <ul>
                                    <li>Personalized training program recommendations</li>
                                    <li>Insights into your dog's behavior patterns</li>
                                    <li>Professional advice on addressing specific issues</li>
                                    <li>Clear next steps for improving your dog's behavior</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </Fragment>
        );
    },
    
    save: function() {
        // Dynamic block, render through PHP callback
        return null;
    },
});