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

    // Block 1: The Singular Service Box
    registerBlockType('gw/single-service', {
        title: 'Singular Service Box',
        icon: 'star-filled',
        category: 'gary-editorial-native',
        attributes: {
            bookly_id: {
                type: 'string',
                default: ''
            },
            card_layout: {
                type: 'string',
                default: 'vertical'
            }
        },
        edit: function(props) {
            // Dropdown options created by PHP
            const serviceOptions = window.garyBooklyServiceOptions || [];

            // The Inspector panel
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Service Details', initialOpen: true },
                    el(SelectControl, {
                        label: 'Select Bookly Service',
                        value: props.attributes.bookly_id,
                        options: serviceOptions,
                        onChange: function(newVal) {
                            props.setAttributes({ bookly_id: newVal });
                        }
                    }),
                    el(SelectControl, {
                        label: 'Card Presentation',
                        value: props.attributes.card_layout,
                        options: [
                            { label: 'Vertical Featured Card', value: 'vertical' },
                            { label: 'Horizontal Sub-Service', value: 'horizontal' }
                        ],
                        onChange: function(newVal) {
                            props.setAttributes({ card_layout: newVal });
                        }
                    })
                )
            );

            // ServerSideRender to show identical frontend view inside the editor
            const preview = el(ServerSideRender, {
                block: 'gw/single-service',
                attributes: props.attributes,
                EmptyResponsePlaceholder: function() {
                    return el('div', { style: { padding: '20px', border: '1px dashed #ccc', textAlign: 'center' } }, 'Select a service from the sidebar.');
                }
            });

            return el('div', { style: { minHeight: '100px' } }, inspector, preview);
        },
        save: function() {
            // Dynamic block, rendering happens in PHP
            return null;
        }
    });

    // Block 2: The Grid Container
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
            const outerClass = is2Col ? 'detailed-components-section' : '';
            const innerClass = is2Col ? 'components-grid' : 'services-grid';

            // Restrict what can go inside and give default templates
            return el('div', { className: outerClass },
                inspector,
                el('div', { className: innerClass, style: { padding: '10px' } },
                    el(InnerBlocks, {
                        allowedBlocks: ['gw/single-service'],
                        template: [
                            ['gw/single-service', {}],
                            ['gw/single-service', {}],
                            ['gw/single-service', {}]
                        ],
                        // Allow to duplicate, up to 5, delete to 1. Not locked.
                        templateLock: false
                    })
                )
            );
        },
        save: function(props) {
            return el(InnerBlocks.Content, null);
        }
    });

    // Block 3: Z-Pattern Layout
    registerBlockType('gw/z-pattern', {
        title: 'Z-Pattern Layout',
        icon: 'leftright',
        category: 'gary-editorial-native',
        attributes: {
            image_url: { type: 'string', default: '' },
            image_id: { type: 'number', default: 0 },
            image_pos: { type: 'string', default: 'left' }
        },
        edit: function(props) {
            const atts = props.attributes;
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Layout Properties', initialOpen: true },
                    el(SelectControl, {
                        label: 'Image Position', value: atts.image_pos,
                        options: [{ label: 'Left', value: 'left' }, { label: 'Right', value: 'right' }],
                        onChange: function(v) { props.setAttributes({ image_pos: v}); }
                    })
                )
            );

            const mediaUploader = el(MediaUpload, {
                onSelect: function(media) { props.setAttributes({ image_url: media.url, image_id: media.id }); },
                allowedTypes: ['image'], value: atts.image_id,
                render: function(obj) {
                    return el(Button, {
                        onClick: obj.open, style: { width: '100%', minHeight: '400px', display: 'flex', alignItems: 'center', justifyContent: 'center', background: '#f5f5f5', border: '2px dashed #ccc' }
                    }, atts.image_url ? el('img', { src: atts.image_url, style: { maxWidth: '100%', maxHeight: '400px', objectFit: 'cover' } }) : 'Upload Image');
                }
            });

            return el('div', { className: 'gw-z-pattern is-' + atts.image_pos, style: { display: 'flex', flexDirection: atts.image_pos === 'right' ? 'row-reverse' : 'row', gap: '20px', alignItems: 'center', marginBottom: '40px' } },
                inspector,
                el('div', { className: 'gw-z-image', style: { flex: '1' } }, mediaUploader),
                el('div', { className: 'gw-z-content', style: { flex: '1', padding: '20px', background: '#fff', border: '1px solid #eee' } },
                    el(InnerBlocks, {
                        template: [
                            ['core/heading', { level: 3, content: 'A Moment in Time' }],
                            ['core/paragraph', { content: 'Click here to write your story.' }]
                        ]
                    })
                )
            );
        },
        save: function(props) {
            const atts = props.attributes;
            return el('div', { className: 'gw-z-pattern is-' + atts.image_pos },
                el('div', { className: 'gw-z-image' }, atts.image_url ? el('img', { src: atts.image_url, alt: '' }) : null),
                el('div', { className: 'gw-z-content' }, el(InnerBlocks.Content, null))
            );
        }
    });

    // Block 4: Trio Gallery
    registerBlockType('gw/trio-gallery', {
        title: 'The Gallery Wall Trio',
        icon: 'images-alt2',
        category: 'gary-editorial-native',
        attributes: {
            img1_url: { type: 'string', default: '' }, img1_id: { type: 'number', default: 0 },
            img2_url: { type: 'string', default: '' }, img2_id: { type: 'number', default: 0 },
            img3_url: { type: 'string', default: '' }, img3_id: { type: 'number', default: 0 },
        },
        edit: function(props) {
            const atts = props.attributes;
            const createUploader = (targetPrefix, height) => el(MediaUpload, {
                onSelect: function(media) { props.setAttributes({ [`${targetPrefix}_url`]: media.url, [`${targetPrefix}_id`]: media.id }); },
                allowedTypes: ['image'], value: atts[`${targetPrefix}_id`],
                render: function(obj) {
                    return el(Button, {
                        onClick: obj.open, style: { width: '100%', height: height, display: 'flex', alignItems: 'center', justifyContent: 'center', background: '#f5f5f5', border: '2px dashed #ccc' }
                    }, atts[`${targetPrefix}_url`] ? el('img', { src: atts[`${targetPrefix}_url`], style: { width: '100%', height: '100%', objectFit: 'cover' } }) : 'Upload');
                }
            });

            return el('div', { className: 'gw-trio-gallery', style: { display: 'flex', gap: '30px', marginBottom: '40px' } },
                el('div', { className: 'gw-trio-main', style: { flex: '2' } }, createUploader('img1', '600px')),
                el('div', { className: 'gw-trio-side', style: { flex: '1', display: 'flex', flexDirection: 'column', gap: '30px' } }, 
                    createUploader('img2', '285px'), 
                    createUploader('img3', '285px')
                )
            );
        },
        save: function(props) {
            const atts = props.attributes;
            return el('div', { className: 'gw-trio-gallery' },
                el('div', { className: 'gw-trio-main' }, atts.img1_url ? el('img', { src: atts.img1_url }) : null),
                el('div', { className: 'gw-trio-side' }, 
                    atts.img2_url ? el('img', { src: atts.img2_url }) : null,
                    atts.img3_url ? el('img', { src: atts.img3_url }) : null
                )
            );
        }
    });

    // Block 5: Editorial Split
    registerBlockType('gw/editorial-split', {
        title: 'Editorial Split (50/50)',
        icon: 'columns',
        category: 'gary-editorial-native',
        attributes: {
            image_url: { type: 'string', default: '' },
            image_id: { type: 'number', default: 0 },
            image_pos: { type: 'string', default: 'right' }
        },
        edit: function(props) {
            const atts = props.attributes;
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Layout Settings' },
                    el(SelectControl, {
                        label: 'Media Position', value: atts.image_pos,
                        options: [{ label: 'Left', value: 'left' }, { label: 'Right', value: 'right' }],
                        onChange: function(v) { props.setAttributes({ image_pos: v}); }
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

            return el('div', { className: 'gw-editorial-split is-' + atts.image_pos, style: { display: 'flex', flexDirection: atts.image_pos === 'right' ? 'row-reverse' : 'row', gap: '0', alignItems: 'stretch' } },
                inspector,
                el('div', { className: 'gw-split-media', style: { flex: '1' } }, mediaUploader),
                el('div', { className: 'gw-split-content', style: { flex: '1', padding: '40px', background: '#f9f9f9' } },
                    el(InnerBlocks, {
                        template: [
                            ['core/heading', { level: 3, content: 'Magazine Layout' }],
                            ['core/paragraph', { content: 'Add your text here.' }]
                        ]
                    })
                )
            );
        },
        save: function(props) {
            const atts = props.attributes;
            return el('div', { className: 'gw-editorial-split is-' + atts.image_pos },
                el('div', { className: 'gw-split-media' }, atts.image_url ? el('img', { src: atts.image_url }) : null),
                el('div', { className: 'gw-split-content' }, el(InnerBlocks.Content, null))
            );
        }
    });

})(window.wp);
