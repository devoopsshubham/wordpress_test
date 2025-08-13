/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, CheckboxControl, TextControl } from '@wordpress/components';
import { Component } from '@wordpress/element';

/**
 * The edit function describes the structure of your block in the context of the editor.
 * This represents what the editor will render when the block is used.
 */
export default class Edit extends Component {
    constructor() {
        super(...arguments);
        this.toggleBookmaker = this.toggleBookmaker.bind(this);
    }

    toggleBookmaker(isChecked, bookmaker) {
        const { attributes, setAttributes } = this.props;
        const { selectedBookmakers } = attributes;

        let newSelection;
        if (isChecked) {
            newSelection = [...selectedBookmakers, bookmaker];
        } else {
            newSelection = selectedBookmakers.filter((item) => item !== bookmaker);
        }
        setAttributes({ selectedBookmakers: newSelection });
    }

    render() {
        const { attributes, setAttributes } = this.props;
        const { selectedBookmakers, selectedMarket } = attributes;
        
        // Get bookmakers from the localized data passed from PHP
        const allBookmakers = window.oddsComparisonBlockData.bookmakers || [];

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__('Block Settings', 'odds-comparison')}>
                        <TextControl
                            label={__('Market Title', 'odds-comparison')}
                            value={selectedMarket}
                            onChange={(value) => setAttributes({ selectedMarket: value })}
                            help={__('e.g., "Match Winner", "Correct Score"', 'odds-comparison')}
                        />
                        <p><strong>{__('Select Bookmakers', 'odds-comparison')}</strong></p>
                        {allBookmakers.length > 0 ? (
                            allBookmakers.map((bookie) => (
                                <CheckboxControl
                                    key={bookie}
                                    label={bookie}
                                    checked={selectedBookmakers.includes(bookie)}
                                    onChange={(isChecked) => this.toggleBookmaker(isChecked, bookie)}
                                />
                            ))
                        ) : (
                            <p>{__('No bookmakers found. Please add them in the plugin settings.', 'odds-comparison')}</p>
                        )}
                    </PanelBody>
                </InspectorControls>

                <div className="odds-comparison-editor-preview">
                    <h4>{__('Odds Comparison Table', 'odds-comparison')}</h4>
                    <p><strong>{__('Market:', 'odds-comparison')}</strong> {selectedMarket}</p>
                    <p>
                        <strong>{__('Selected Bookmakers:', 'odds-comparison')}</strong>
                        {selectedBookmakers.length > 0 ? selectedBookmakers.join(', ') : __('None', 'odds-comparison')}
                    </p>
                    <p className="preview-note">
                        <em>{__('Live odds will be displayed on the front end. Configure options in the block sidebar.', 'odds-comparison')}</em>
                    </p>
                </div>
            </>
        );
    }
}
