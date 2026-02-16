import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, InnerBlocks } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const { title } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Tab Settings', 'my-parks')}>
					<TextControl
						label={__('Tab Title', 'my-parks')}
						value={title}
						onChange={(value) => setAttributes({ title: value })}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps()}>
				<InnerBlocks />
			</div>
		</>
	);
}
