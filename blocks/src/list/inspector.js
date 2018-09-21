/**
 * Internal block libraries
 */
const { __ } = wp.i18n;
const { Component } = wp.element;
const {
	InspectorControls
} = wp.editor;
const {
	PanelBody,
	TextControl
} = wp.components;

/**
 * Create an Inspector Controls wrapper Component
 */
export default class Inspector extends Component {
	constructor() {
		super( ...arguments );
	}

	render() {
		const { attributes: { termID }, setAttributes } = this.props;

		return (
			<InspectorControls>

				<PanelBody>
					<TextControl
						label={ __( 'Post Series ID' ) }
						help={ __( 'The ID number for the Post Series.' ) }
						value={ termID }
						onChange={ newTermID => setAttributes( { termID: newTermID } ) }
					/>
				</PanelBody>

			</InspectorControls>
		);
	}
}
