/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import Edit from './edit';
import './style.scss';
import './editor.scss';

/**
 * Block registration
 */
registerBlockType('odds-comparison/odds-block', {
    title: __('Odds Comparison Table', 'odds-comparison'),
    icon: 'list-view',
    category: 'widgets',
    keywords: [
        __('odds', 'odds-comparison'),
        __('betting', 'odds-comparison'),
        __('comparison', 'odds-comparison'),
    ],
    attributes: {
        selectedBookmakers: {
            type: 'array',
            default: [],
        },
        selectedMarket: {
            type: 'string',
            default: 'Premier League Outrights', // Default market title
        },
    },
    /**
     * @see ./edit.js
     */
    edit: Edit,
    /**
     * The save function is null for dynamic blocks.
     * The content is rendered server-side via PHP.
     */
    save: () => null,
});
