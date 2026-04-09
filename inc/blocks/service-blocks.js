(function(wp) {
    const el = wp.element.createElement;
    const registerBlockType = wp.blocks.registerBlockType;
    const InnerBlocks = wp.blockEditor.InnerBlocks;
    const InspectorControls = wp.blockEditor.InspectorControls;
    const SelectControl = wp.components.SelectControl;
    const PanelBody = wp.components.PanelBody;
    const ServerSideRender = wp.serverSideRender;

    // Block 1: The Singular Service Box
    registerBlockType('gw/single-service', {
        title: 'Singular Service Box',
        icon: 'star-filled',
        category: 'gary-editorial-native',
        parent: ['gw/service-grid'],
        attributes: {
            bookly_id: {
                type: 'string',
                default: ''
            }
        },
        edit: function(props) {
            // Dropdown options created by PHP
            const serviceOptions = window.garyBooklyServiceOptions || [];

            // The Inspector panel
            const inspector = el(InspectorControls, null,
                el(PanelBody, { title: 'Service Selection', initialOpen: true },
                    el(SelectControl, {
                        label: 'Select Bookly Service',
                        value: props.attributes.bookly_id,
                        options: serviceOptions,
                        onChange: function(newVal) {
                            props.setAttributes({ bookly_id: newVal });
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
        edit: function(props) {
            // Restrict what can go inside and give default templates
            return el('div', { className: 'detailed-components-section' },
                el('div', { className: 'component-grid', style: { border: '1px dashed #ccc', padding: '10px' } },
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

})(window.wp);
