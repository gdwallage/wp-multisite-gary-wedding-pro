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

    // 6. Chapter Break
    registerBlockType('gw/chapter-break', {
        title: 'Editorial Chapter Break', icon: 'separator', category: 'gary-editorial-native',
        attributes: { title: { type: 'string', default: 'Photographing Life' } },
        edit: function(props) {
            return el('div', { className: 'gw-block-edit-wrap' },
                el(RichText, {
                    tagName: 'h2',
                    value: props.attributes.title,
                    onChange: function(v) { props.setAttributes({ title: v }); },
                    style: { textAlign: 'center', letterSpacing: '8px', textTransform: 'uppercase', fontSize: '1rem', borderTop: '2px solid #C5A059', paddingTop: '40px', marginTop: '40px' }
                })
            );
        },
        save: function() { return null; }
    });

    // 7. CTA Plaque
    registerBlockType('gw/cta-plaque', {
        title: 'CTA Action Plaque', icon: 'megaphone', category: 'gary-editorial-native',
        attributes: {
            title: { type: 'string', default: 'Ready to Secure Your Date?' },
            content: { type: 'string', default: 'I take on a limited number of weddings each year.' },
            btn_text: { type: 'string', default: 'Inquire Now' },
            btn_url: { type: 'string', default: '/contact/' }
        },
        edit: function(props) {
            const atts = props.attributes;
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'CTA Settings' },
                    el(TextControl, { label: 'Button Text', value: atts.btn_text, onChange: function(v) { props.setAttributes({ btn_text: v }); } }),
                    el(TextControl, { label: 'Button URL', value: atts.btn_url, onChange: function(v) { props.setAttributes({ btn_url: v }); } })
                )
            );
            return el('div', null, inspector, el(ServerSideRender, { block: 'gw/cta-plaque', attributes: atts }));
        },
        save: function() { return null; }
    });

    // 8. Trust Bar
    registerBlockType('gw/trust-bar', {
        title: 'Confidence Trust Bar', icon: 'shield', category: 'gary-editorial-native',
        attributes: { signals: { type: 'string', default: '✓ 10+ Years Experience | ✓ Documentary Style | ✓ Limited Bookings' } },
        edit: function(props) {
            const atts = props.attributes;
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Bar Settings' },
                    el(TextControl, { label: 'Signals Text', value: atts.signals, onChange: function(v) { props.setAttributes({ signals: v }); } })
                )
            );
            return el('div', null, inspector, el(ServerSideRender, { block: 'gw/trust-bar', attributes: atts }));
        },
        save: function() { return null; }
    });

    // 9. USPs (3-Column)
    registerBlockType('gw/usps-3col', {
        title: 'Editorial USPs (3-Col)', icon: 'columns', category: 'gary-editorial-native',
        attributes: {
            main_title: { type: 'string', default: 'Our Core Values' },
            t1: { type: 'string', default: 'Documentary Storytelling' }, d1: { type: 'string', default: '...' },
            t2: { type: 'string', default: 'Technical Precision' },      d2: { type: 'string', default: '...' },
            t3: { type: 'string', default: 'A Calming Presence' },      d3: { type: 'string', default: '...' }
        },
        edit: function(props) {
            const atts = props.attributes;
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'USP Content' },
                    el(TextControl, { label: 'Main Block Title', value: atts.main_title, onChange: function(v) { props.setAttributes({ main_title: v }); } }),
                    [1,2,3].map(i => el('div', { key: i, style: { borderTop: '1px solid #eee', marginTop: '15px', paddingTop: '15px' } },
                        el(TextControl, { label: `USP ${i} Title`, value: atts[`t${i}`], onChange: function(v) { props.setAttributes({ [`t${i}`]: v }); } }),
                        el(TextControl, { label: `USP ${i} Description`, value: atts[`d${i}`], onChange: function(v) { props.setAttributes({ [`d${i}`]: v }); } })
                    ))
                )
            );
            return el('div', null, inspector, el(ServerSideRender, { block: 'gw/usps-3col', attributes: atts }));
        },
        save: function() { return null; }
    });

    // 10. Action Step Container (Parent)
    registerBlockType('gw/action-step-container', {
        title: 'The Journey (Action Steps)', icon: 'editor-ol', category: 'gary-editorial-native',
        keywords: ['journey', 'steps', 'process', 'check date', 'availability'],
        attributes: {
            main_title: { type: 'string', default: 'The Journey' }
        },
        edit: function(props) {
            const atts = props.attributes;
            return el('div', { className: 'gw-process-block container edit-mode' },
                el(RichText, {
                    tagName: 'h2',
                    className: 'gw-block-main-title',
                    value: atts.main_title,
                    onChange: function(v) { props.setAttributes({ main_title: v }); },
                    style: { textAlign: 'center', marginBottom: '40px' }
                }),
                el('div', { className: 'gw-process-row' },
                    el(InnerBlocks, {
                        allowedBlocks: ['gw/action-step'],
                        template: [
                            ['gw/action-step', { step_num: '01', title: 'Check Your Date', step_type: 'availability' }],
                            ['gw/action-step', { step_num: '02', title: 'Consultation', step_type: 'link' }],
                            ['gw/action-step', { step_num: '03', title: 'The Day', step_type: 'link' }],
                            ['gw/action-step', { step_num: '04', title: 'The Gallery', step_type: 'link' }]
                        ]
                    })
                )
            );
        },
        save: function() { return el(InnerBlocks.Content, null); }
    });

    // 11. Individual Action Step (Child)
    registerBlockType('gw/action-step', {
        title: 'Individual Action Step', icon: 'star-filled', category: 'gary-editorial-native',
        parent: ['gw/action-step-container'],
        keywords: ['check date', 'availability', 'booking', 'step', 'action'],
        attributes: {
            step_type: { type: 'string', default: 'link' },
            title: { type: 'string', default: 'Consultation' },
            description: { type: 'string', default: '' },
            target_page: { type: 'number', default: 0 },
            step_num: { type: 'string', default: '01' }
        },
        variations: [
            {
                name: 'check-date',
                title: 'Step: Check Your Date!',
                icon: 'calendar-alt',
                attributes: { step_type: 'availability', title: 'Check Your Date', step_num: '01' },
                isDefault: false,
            },
            {
                name: 'action-link',
                title: 'Step: Action Link',
                icon: 'admin-links',
                attributes: { step_type: 'link', title: 'Consultation', step_num: '02' },
                isDefault: true,
            }
        ],
        edit: function(props) {
            const atts = props.attributes;
            const pageOptions = window.garyPageOptions || [];
            
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Step Settings' },
                    el(TextControl, { label: 'Step Number', value: atts.step_num, onChange: function(v) { props.setAttributes({ step_num: v }); } }),
                    el(SelectControl, {
                        label: 'Step Action Type',
                        value: atts.step_type,
                        options: [
                            { label: 'Link to Page (CTA)', value: 'link' },
                            { label: 'Check Availability (Lookup)', value: 'availability' }
                        ],
                        onChange: function(v) { props.setAttributes({ step_type: v }); }
                    }),
                    atts.step_type === 'link' && el(SelectControl, {
                        label: 'Target Page',
                        value: atts.target_page,
                        options: pageOptions,
                        onChange: function(v) { props.setAttributes({ target_page: parseInt(v) }); }
                    })
                )
            );

            return el('div', { className: 'gw-process-col edit-box', style: { padding: '20px', border: '1px solid #eee', background: '#fff' } },
                inspector,
                el('span', { className: 'step-num' }, atts.step_num),
                el(RichText, {
                    tagName: 'h4',
                    value: atts.title,
                    placeholder: 'Enter Title...',
                    onChange: function(v) { props.setAttributes({ title: v }); }
                }),
                el(RichText, {
                    tagName: 'p',
                    value: atts.description,
                    placeholder: 'Enter description...',
                    onChange: function(v) { props.setAttributes({ description: v }); }
                }),
                el('div', { className: 'action-preview', style: { marginTop: '10px', fontSize: '0.7rem', opacity: 0.5, fontStyle: 'italic' } },
                    atts.step_type === 'availability' ? '[Availability Checker Active]' : '[Link to Page Active]'
                )
            );
        },
        save: function() { return null; }
    });

    // 11. Hero Bleed (Native Cover Extension)
    registerBlockType('gw/hero-bleed', {
        title: 'Cinematic Hero Bleed', icon: 'cover-image', category: 'gary-editorial-native',
        attributes: { image_url: { type: 'string', default: '' }, image_id: { type: 'number', default: 0 }, overlay_opacity: { type: 'number', default: 10 } },
        edit: function(props) {
            const atts = props.attributes;
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Overlay Settings' },
                    el(wp.components.RangeControl, {
                        label: 'Overlay Opacity', value: atts.overlay_opacity,
                        onChange: function(v) { props.setAttributes({ overlay_opacity: v }); }, min: 0, max: 100
                    })
                )
            );
            const mediaUploader = el(MediaUpload, {
                onSelect: function(m) { props.setAttributes({ image_url: m.url, image_id: m.id }); },
                allowedTypes: ['image'], value: atts.image_id,
                render: function(obj) {
                    return el(Button, { onClick: obj.open, style: { width: '100%', minHeight: '300px', display: 'flex', background: '#f5f5f5', border: '2px dashed #ccc' } },
                        atts.image_url ? el('img', { src: atts.image_url, style: { maxWidth: '100%' } }) : 'Upload Background Image'
                    );
                }
            });
            return el('div', { className: 'gw-hero-bleed-edit' },
                inspector,
                mediaUploader,
                el('div', { className: 'gw-hero-content-edit', style: { padding: '50px', border: '1px solid #eee', marginTop: '10px' } },
                    el(InnerBlocks, { template: [['core/heading', { textAlign: 'center', level: 2, content: 'Hero Title' }]] })
                )
            );
        },
        save: function() { return el(InnerBlocks.Content, null); }
    });

    // 12. Storyteller Grid (4 Pcs)
    registerBlockType('gw/storyteller-grid', {
        title: 'The Storyteller Grid (4 Pcs)', icon: 'grid-view', category: 'gary-editorial-native',
        attributes: { 
            img1_id: { type:'number' }, img1_url: { type:'string' },
            img2_id: { type:'number' }, img2_url: { type:'string' },
            img3_id: { type:'number' }, img3_url: { type:'string' },
            img4_id: { type:'number' }, img4_url: { type:'string' }
        },
        edit: function(props) {
            const atts = props.attributes;
            const up = (i, m) => props.setAttributes({ [`img${i}_id`]: m.id, [`img${i}_url`]: m.url });
            return el('div', { className: 'gw-story-grid-edit', style: { display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '10px' } },
                [1,2,3,4].map(i => el(MediaUpload, {
                    onSelect: m => up(i, m), allowedTypes:['image'], value: atts[`img${i}_id`],
                    render: obj => el(Button, { onClick: obj.open, style: { width: '100%', height: '150px', background: '#f5f5f5', border: '1px dashed #ccc' } },
                        atts[`img${i}_url`] ? el('img', { src: atts[`img${i}_url`], style: { width: '100%', height: '100%', objectFit: 'cover' } }) : `Image ${i}`)
                }))
            );
        },
        save: function() { return null; }
    });

    // 13. Testimonial Quote
    registerBlockType('gw/testimonial-quote', {
        title: 'Testimonial Transparency', icon: 'format-quote', category: 'gary-editorial-native',
        attributes: { image_url: { type:'string' }, image_id: { type:'number' } },
        edit: function(props) {
            const atts = props.attributes;
            const mediaUploader = el(MediaUpload, {
                onSelect: (m) => props.setAttributes({ image_url: m.url, image_id: m.id }),
                allowedTypes: ['image'], value: atts.image_id,
                render: obj => el(Button, { onClick: obj.open, style: { width: '100%', minHeight: '200px', background: '#f5f5f5', border: '2px dashed #ccc' } },
                    atts.image_url ? el('img', { src: atts.image_url, style: { maxWidth: '100%' } }) : 'Upload Testimonial Background')
            });
            return el('div', null,
                mediaUploader,
                el('div', { style: { padding: '40px', background: '#fff', border: '1px solid #eee', marginTop: '10px' } },
                    el(InnerBlocks, { template: [['core/quote', { textAlign: 'center', content: 'The purest moments captured flawlessly.' }]] })
                )
            );
        },
        save: function() { return el(InnerBlocks.Content, null); }
    });

    // 14. Polaroid Frame
    registerBlockType('gw/polaroid-frame', {
        title: 'Fine-Art Polaroid', icon: 'format-image', category: 'gary-editorial-native',
        edit: function() {
            return el('div', { className: 'gw-polaroid-frame-edit', style: { padding: '20px', background: '#fff', border: '1px solid #ccc', boxShadow: '0 10px 30px rgba(0,0,0,0.1)' } },
                el(InnerBlocks, { template: [['core/image', { align: 'center' }]] })
            );
        },
        save: function() { return el(InnerBlocks.Content, null); }
    });

    // 15. Full-Width CTA
    registerBlockType('gw/cta-fullwidth', {
        title: 'Full-Width Action Plate', icon: 'megaphone', category: 'gary-editorial-native',
        attributes: { image_url: { type:'string' }, image_id: { type:'number' } },
        edit: function(props) {
            const atts = props.attributes;
            const mediaUploader = el(MediaUpload, {
                onSelect: (m) => props.setAttributes({ image_url: m.url, image_id: m.id }),
                allowedTypes: ['image'], value: atts.image_id,
                render: obj => el(Button, { onClick: obj.open, style: { width: '100%', minHeight: '200px', background: '#f5f5f5', border: '2px dashed #ccc' } },
                    atts.image_url ? el('img', { src: atts.image_url, style: { maxWidth: '100%' } }) : 'Upload CTA Background')
            });
            return el('div', null,
                mediaUploader,
                el('div', { style: { padding: '40px', background: '#fff', border: '1px solid #eee', marginTop: '10px' } },
                    el(InnerBlocks, { template: [
                        ['core/heading', { textAlign: 'center', content: 'Ready to Tell Your Story?', level: 2 }],
                        ['core/paragraph', { textAlign: 'center', content: 'I take on a limited number of bookings each year.' }],
                        ['core/buttons', { layout: { type: 'flex', justifyContent: 'center' } }]
                    ] })
                )
            );
        },
        save: function() { return el(InnerBlocks.Content, null); }
    });

    // 16-18. List Boxes
    ['highlights', 'included', 'perfect-for'].forEach(type => {
        registerBlockType(`gw/list-${type}`, {
            title: `Box: ${type.charAt(0).toUpperCase() + type.slice(1).replace('-', ' ')}`,
            icon: 'editor-ul',
            category: 'gary-editorial-native',
            edit: function() {
                return el('div', { className: `gw-list-box-edit type-${type}` },
                    el(InnerBlocks, { 
                        template: [
                            ['core/heading', { level: 4, content: type === 'perfect-for' ? "WHO IT'S FOR" : "WHAT'S INCLUDED" }],
                            ['core/paragraph', { placeholder: 'Brief overview...' }],
                            ['core/list', { className: `is-style-gw-${type}` }]
                        ],
                        allowedBlocks: ['core/paragraph', 'core/list', 'core/heading']
                    })
                );
            },
            save: function() { return el(InnerBlocks.Content, null); }
        });
    });

    // 17. Dual Column Overview Container
    registerBlockType('gw/editorial-dual-column', {
        title: 'Editorial Dual Column',
        icon: 'columns',
        category: 'gary-editorial-native',
        description: 'Two columns with horizontal and vertical dividers for service overviews.',
        edit: function() {
            return el('div', { className: 'gw-dual-column-edit-wrap' },
                el(InnerBlocks, {
                    template: [
                        ['gw/list-perfect-for', {}],
                        ['gw/list-included', {}]
                    ],
                    templateLock: false,
                    allowedBlocks: ['gw/list-perfect-for', 'gw/list-included', 'gw/list-highlights', 'core/paragraph', 'core/list']
                })
            );
        },
        save: function() { return el(InnerBlocks.Content, null); }
    });

    // 12. Atomic Check Your Date Block
    registerBlockType('gw/check-date-atomic', {
        title: 'Check Your Date!', icon: 'calendar-alt', category: 'gary-editorial-native',
        keywords: ['check date', 'availability', 'booking', 'wedding', 'gary'],
        attributes: {
            title: { type: 'string', default: 'Check Your Date!' },
            description: { type: 'string', default: 'Select your wedding date to see if I am available for your celebration.' },
            duration: { type: 'string', default: 'Full Day' },
            target_page_id: { type: 'number', default: 0 }
        },
        edit: function(props) {
            const atts = props.attributes;
            const pageOptions = window.garyPageOptions || [];

            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Block Settings' },
                    el(SelectControl, {
                        label: 'Target Consultation Page',
                        value: atts.target_page_id,
                        options: pageOptions,
                        onChange: function(v) { props.setAttributes({ target_page_id: parseInt(v) }); }
                    })
                )
            );

            return el('div', { className: 'gw-process-block container edit-mode-atomic', style: { padding: '40px', background: '#fff', border: '1px solid #ddd' } },
                inspector,
                el('div', { className: 'gw-process-col is-atomic-check condensed-preview', style: { textAlign: 'center', maxWidth: '400px', margin: '0 auto' } },
                    el(RichText, {
                        tagName: 'h4',
                        value: atts.title,
                        placeholder: 'Service Type...',
                        onChange: function(v) { props.setAttributes({ title: v }); }
                    }),
                    el(RichText, {
                        tagName: 'p',
                        value: atts.description,
                        style: { fontSize: '0.8rem', opacity: 0.7 },
                        placeholder: 'Enter Description...',
                        onChange: function(v) { props.setAttributes({ description: v }); }
                    }),
                    el('div', { style: { borderTop: '1px solid #eee', margin: '15px 0' } }),
                    el(RichText, {
                        tagName: 'div',
                        value: atts.duration,
                        style: { textTransform: 'uppercase', letterSpacing: '1px', fontSize: '0.7rem', fontWeight: '700', marginBottom: '10px' },
                        placeholder: 'Duration (e.g. Full Day)',
                        onChange: function(v) { props.setAttributes({ duration: v }); }
                    }),
                    el('div', { style: { border: '1px solid #ddd', padding: '10px', background: '#f9f9f9', fontSize: '0.8rem' } },
                        '[ Calendar Box Preview ]'
                    )
                )
            );
        },
        save: function() { return null; }
    });

    // 13. Editorial Triplet Container (Parent)
    registerBlockType('gw/editorial-triplet-container', {
        title: 'Editorial Triplet Container', icon: 'columns', category: 'gary-editorial-native',
        edit: function() {
            return el('div', { className: 'gw-triplet-container-edit', style: { padding: '20px', border: '2px dashed #C5A059' } },
                el(InnerBlocks, {
                    allowedBlocks: ['gw/editorial-triplet-item'],
                    template: [
                        ['gw/editorial-triplet-item', { heading: 'Perfect For' }],
                        ['gw/editorial-triplet-item', { heading: 'What\'s Included' }],
                        ['gw/editorial-triplet-item', { heading: 'How It Works' }]
                    ],
                    templateLock: 'all'
                })
            );
        },
        save: function() { return el(InnerBlocks.Content, null); }
    });

    // 14. Editorial Triplet Item (Child)
    registerBlockType('gw/editorial-triplet-item', {
        title: 'Triplet Item', icon: 'media-text', category: 'gary-editorial-native',
        parent: ['gw/editorial-triplet-container'],
        attributes: {
            heading: { type: 'string', default: '' },
            text: { type: 'string', default: '' }
        },
        edit: function(props) {
            return el('div', { className: 'gw-triplet-item-edit', style: { padding: '20px', background: '#fff', border: '1px solid #eee' } },
                el(RichText, {
                    tagName: 'h3',
                    value: props.attributes.heading,
                    placeholder: 'Heading...',
                    onChange: function(v) { props.setAttributes({ heading: v }); }
                }),
                el('div', { style: { borderTop: '1px solid #C5A059', margin: '15px 0', opacity: 0.3 } }),
                el(RichText, {
                    tagName: 'p',
                    value: props.attributes.text,
                    placeholder: 'Intro paragraph...',
                    onChange: function(v) { props.setAttributes({ text: v }); }
                }),
                el('div', { style: { borderTop: '1px solid #C5A059', margin: '15px 0', opacity: 0.3 } }),
                el(InnerBlocks, {
                    template: [['core/list', { className: 'is-style-gw-included' }]],
                    allowedBlocks: ['core/list', 'core/paragraph', 'core/separator']
                })
            );
        },
        save: function() { return el(InnerBlocks.Content, null); }
    });

    console.info('GW Editorial: Blocks Successfully Registered.');

})(window.wp);
