import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';
import './editor.scss';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, showHeading } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'my-parks' ) }>
					<ToggleControl
						label={ __( 'Show heading', 'my-parks' ) }
						checked={ showHeading }
						onChange={ ( value ) => setAttributes( { showHeading: value } ) }
					/>
					{ showHeading && (
						<TextControl
							label={ __( 'Heading text', 'my-parks' ) }
							value={ heading }
							onChange={ ( value ) => setAttributes( { heading: value } ) }
						/>
					) }
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
				<p className="park-maps-editor-placeholder">
					{ __( 'Park Maps — map files added in the "Maps" tab of Park Configuration will appear here.', 'my-parks' ) }
				</p>
			</div>
		</>
	);
}
