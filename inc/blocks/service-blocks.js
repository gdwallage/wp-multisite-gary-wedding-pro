(function(wp) {
    const el = wp.element.createElement;
    const registerBlockType = wp.blocks.registerBlockType;
    const InnerBlocks = wp.blockEditor.InnerBlocks;
    const InspectorControls = wp.blockEditor.InspectorControls;
    const SelectControl = wp.components.SelectControl;
    const PanelBody = wp.components.PanelBody;
    const ServerSideRender = wp.serverSideRender;
    const MediaUpload = wp.blockEditor.MediaUpload;
    const Button = wp.components.Button;
    const RichText = wp.blockEditor.RichText;
    const TextControl = wp.components.TextControl;

    console.info('GW Editorial: Initializing Native Blocks v1.3.0...');

    // 1. Singular Service Box
    registerBlockType('gw/single-service', {
        title: 'Singular Service Box',
        icon: 'star-filled',
        category: 'gary-editorial-native',
        attributes: {
            bookly_id: { type: 'string', default: '' },
            card_layout: { type: 'string', default: 'vertical' }
        },
        edit: function(props) {
            const serviceOptions = window.garyBooklyServiceOptions || [];
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Service Details', initialOpen: true },
                    el(SelectControl, {
                        label: 'Select Bookly Service',
                        value: props.attributes.bookly_id,
                        options: serviceOptions,
                        onChange: function(newVal) { props.setAttributes({ bookly_id: newVal }); }
                    }),
                    el(SelectControl, {
                        label: 'Card Presentation',
                        value: props.attributes.card_layout,
                        options: [
                            { label: 'Vertical Featured Card', value: 'vertical' },
                            { label: 'Horizontal Sub-Service', value: 'horizontal' }
                        ],
                        onChange: function(newVal) { props.setAttributes({ card_layout: newVal }); }
                    })
                )
            );

            const preview = el(ServerSideRender, {
                block: 'gw/single-service',
                attributes: props.attributes,
                EmptyResponsePlaceholder: function() {
                    return el('div', { style: { padding: '20px', border: '1px dashed #ccc', textAlign: 'center' } }, 'Select a service from the sidebar.');
                }
            });

            return el('div', { className: 'gw-block-wrapper' }, inspector, preview);
        },
        save: function() { return null; }
    });

    // 2. Featured Services Grid
    registerBlockType('gw/service-grid', {
        title: 'Featured Services Grid',
        icon: 'grid-view',
        category: 'gary-editorial-native',
        attributes: {
            grid_layout: { type: 'string', default: '3-cols' }
        },
        edit: function(props) {
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Grid Settings', initialOpen: true },
                    el(SelectControl, {
                        label: 'Grid Layout',
                        value: props.attributes.grid_layout,
                        options: [
                            { label: '3-Column (Vertical Cards)', value: '3-cols' },
                            { label: '2-Column (Horizontal Cards)', value: '2-cols' }
                        ],
                        onChange: function(newVal) { props.setAttributes({ grid_layout: newVal }); }
                    })
                )
            );

            const is2Col = props.attributes.grid_layout === '2-cols';
            const innerClass = is2Col ? 'components-grid' : 'services-grid';

            return el('div', { className: 'gw-grid-container ' + (is2Col ? 'detailed-components-section' : '') },
                inspector,
                el('div', { className: innerClass },
                    el(InnerBlocks, {
                        allowedBlocks: ['gw/single-service', 'core/heading', 'core/paragraph'],
                        template: [
                            ['gw/single-service', {}],
                            ['gw/single-service', {}],
                            ['gw/single-service', {}]
                        ],
                        templateLock: false
                    })
                )
            );
        },
        save: function() { return el(InnerBlocks.Content, null); }
    });

    // 3. Z-Pattern Layout
    registerBlockType('gw/z-pattern', {
        title: 'Z-Pattern Layout',
        icon: 'leftright',
        category: 'gary-editorial-native',
        attributes: {
            image_url: { type: 'string', default: '' },
            image_id: { type: 'number', default: 0 },
            image_pos: { type: 'string', default: 'left' },
            image_size: { type: 'string', default: 'large' }
        },
        edit: function(props) {
            const atts = props.attributes;
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Media Settings', initialOpen: true },
                    el(SelectControl, {
                        label: 'Image Position', value: atts.image_pos,
                        options: [{ label: 'Left', value: 'left' }, { label: 'Right', value: 'right' }],
                        onChange: function(v) { props.setAttributes({ image_pos: v}); }
                    }),
                    el(SelectControl, {
                        label: 'Image Resolution', value: atts.image_size,
                        options: [
                            { label: 'Thumbnail', value: 'thumbnail' },
                            { label: 'Medium', value: 'medium' },
                            { label: 'Large', value: 'large' },
                            { label: 'Full Size', value: 'full' }
                        ],
                        onChange: function(v) { props.setAttributes({ image_size: v}); }
                    })
                )
            );

            const mediaUploader = el(MediaUpload, {
                onSelect: function(media) { props.setAttributes({ image_url: media.url, image_id: media.id }); },
                allowedTypes: ['image'], value: atts.image_id,
                render: function(obj) {
                    return el(Button, {
                        onClick: obj.open,
                        className: 'button button-large',
                        style: { width: '100%', minHeight: '300px', display: 'flex', alignItems: 'center', justifyContent: 'center', background: '#f5f5f5', border: '2px dashed #ccc' }
                    }, atts.image_url ? el('img', { src: atts.image_url, style: { maxWidth: '100%', maxHeight: '100%', objectFit: 'cover' } }) : 'Upload Image');
                }
            });

            return el('div', { className: 'gw-z-pattern is-' + atts.image_pos },
                inspector,
                el('div', { className: 'gw-z-image' }, mediaUploader),
                el('div', { className: 'gw-z-content' },
                    el(InnerBlocks, {
                        template: [
                            ['core/heading', { level: 3, content: 'A Moment in Time' }],
                            ['core/paragraph', { content: 'Click here to write your story.' }]
                        ]
                    })
                )
            );
        },
        save: function() { return el(InnerBlocks.Content, null); }
    });

    // 4. Trio Gallery
    registerBlockType('gw/trio-gallery', {
        title: 'The Gallery Wall Trio',
        icon: 'images-alt2',
        category: 'gary-editorial-native',
        attributes: {
            img1_url: { type: 'string', default: '' }, img1_id: { type: 'number', default: 0 }, img1_size: { type: 'string', default: 'large' },
            img2_url: { type: 'string', default: '' }, img2_id: { type: 'number', default: 0 }, img2_size: { type: 'string', default: 'medium' },
            img3_url: { type: 'string', default: '' }, img3_id: { type: 'number', default: 0 }, img3_size: { type: 'string', default: 'medium' },
            trio_title: { type: 'string', default: '' },
        },
        edit: function(props) {
            const atts = props.attributes;
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Media Settings', initialOpen: true },
                    [1,2,3].map(i => el(SelectControl, {
                        label: `Image ${i} Resolution`, value: atts[`img${i}_size`],
                        options: [
                            { label: 'Thumbnail', value: 'thumbnail' },
                            { label: 'Medium', value: 'medium' },
                            { label: 'Large', value: 'large' },
                            { label: 'Full Size', value: 'full' }
                        ],
                        onChange: function(v) { props.setAttributes({ [`img${i}_size`]: v }); }
                    }))
                )
            );

            const createUploader = (targetPrefix, height) => el(MediaUpload, {
                onSelect: function(media) { props.setAttributes({ [`${targetPrefix}_url`]: media.url, [`${targetPrefix}_id`]: media.id }); },
                allowedTypes: ['image'], value: atts[`${targetPrefix}_id`],
                render: function(obj) {
                    return el(Button, {
                        onClick: obj.open, style: { width: '100%', height: height, display: 'flex', alignItems: 'center', justifyContent: 'center', background: '#f5f5f5', border: '2px dashed #ccc', overflow:'hidden' }
                    }, atts[`${targetPrefix}_url`] ? el('img', { src: atts[`${targetPrefix}_url`], style: { width: '100%', height: '100%', objectFit: 'cover' } }) : 'Upload');
                }
            });

            return el('div', { className: 'gw-trio-gallery-wrapper' },
                inspector,
                el(RichText, {
                    tagName: 'h2',
                    className: 'trio-gallery-heading',
                    placeholder: 'Enter Gallery Heading...',
                    value: atts.trio_title,
                    onChange: function(v) { props.setAttributes({ trio_title: v }); },
                    style: { textAlign: 'center', fontFamily: 'Blacksword, cursive', fontSize: '2.5rem', fontWeight: 'normal', color: '#B08D55', marginBottom: '20px' }
                }),
                el('div', { className: 'gw-trio-gallery' },
                    el('div', { className: 'gw-trio-main' }, createUploader('img1', '620px')),
                    el('div', { className: 'gw-trio-side' }, 
                        createUploader('img2', '295px'), 
                        createUploader('img3', '295px')
                    )
                )
            );
        },
        save: function() { return null; }
    });

    // 5. Editorial Split
    registerBlockType('gw/editorial-split', {
        title: 'Editorial Split (50/50)',
        icon: 'columns',
        category: 'gary-editorial-native',
        attributes: {
            image_url: { type: 'string', default: '' },
            image_id: { type: 'number', default: 0 },
            image_pos: { type: 'string', default: 'right' },
            image_size: { type: 'string', default: 'large' }
        },
        edit: function(props) {
            const atts = props.attributes;
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Media Settings', initialOpen: true },
                    el(SelectControl, {
                        label: 'Media Position', value: atts.image_pos,
                        options: [{ label: 'Left', value: 'left' }, { label: 'Right', value: 'right' }],
                        onChange: function(v) { props.setAttributes({ image_pos: v}); }
                    }),
                    el(SelectControl, {
                        label: 'Image Resolution', value: atts.image_size,
                        options: [
                            { label: 'Thumbnail', value: 'thumbnail' },
                            { label: 'Medium', value: 'medium' },
                            { label: 'Large', value: 'large' },
                            { label: 'Full Size', value: 'full' }
                        ],
                        onChange: function(v) { props.setAttributes({ image_size: v}); }
                    })
                )
            );

            const mediaUploader = el(MediaUpload, {
                onSelect: function(media) { props.setAttributes({ image_url: media.url, image_id: media.id }); },
                allowedTypes: ['image'], value: atts.image_id,
                render: function(obj) {
                    return el(Button, { onClick: obj.open, style: { width: '100%', minHeight: '400px', display: 'flex', background: '#f5f5f5', border: '2px dashed #ccc' } },
                        atts.image_url ? el('img', { src: atts.image_url, style: { width: '100%', height:'100%', objectFit: 'cover' } }) : 'Upload'
                    );
                }
            });

            return el('div', { className: 'gw-editorial-split is-' + atts.image_pos },
                inspector,
                el('div', { className: 'gw-split-media' }, mediaUploader),
                el('div', { className: 'gw-split-content' },
                    el(InnerBlocks, {
                        template: [
                            ['core/heading', { level: 3, content: 'Magazine Layout' }],
                            ['core/paragraph', { content: 'Add your text here.' }]
                        ]
                    })
                )
            );
        },
        save: function() { return el(InnerBlocks.Content, null); }
    });

    console.info('GW Editorial: Blocks Successfully Registered.');

})(window.wp);
