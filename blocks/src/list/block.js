/**
 * BLOCK: psm-nav
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

import listIcon from './icon';
import WPAPI from 'wpapi';
import Inspector from "./inspector";

const { RawHTML } = wp.element; // Allows use of raw HTML.
const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

const { withSelect } = wp.data;

async function getSeriesListHTML( termID ) {
	const postPromise = fetch("http://gutenberg.test/wp-json/wp/v2/posts?post-series=3");


	const test = await postPromise.then( data => data.json() ).then( data => {
		let HTML = '';
		data.map( post => HTML = post.title.rendered + HTML );

		return HTML;
	} );

	console.log(test);
}

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType('psm/block-list', {

	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __('PSM - List'), // Block title.
	icon: listIcon,
	category: 'widgets', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [__('Post Series Manager'), __('Post Series')],
	attributes: {
		termID: {
			type: 'string'
		},
	},

	// Determines what is displayed in the editor.
	// https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/#edit
	edit: function (props) {
		const {
			className,
			attributes,
			setAttributes
		} = props;

		return [
			<Inspector { ...{ setAttributes, ...props } } />,
			<div class="post-series-manager-block">
				<RawHTML>{ getSeriesListHTML( props.attributes.termID ) }</RawHTML>
			</div>
		];
	},

	// Determines what is displayed on the front-end.
	// https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/#save
	//
	// For dynamic blocks, you can return null here and define a render callback function in PHP.
	// https://wordpress.org/gutenberg/handbook/blocks/creating-dynamic-blocks/
	save: function () {
		return null;
	}
});
