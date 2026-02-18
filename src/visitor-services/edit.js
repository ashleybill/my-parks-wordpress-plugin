import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextareaControl } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const { defaultText } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Settings', 'my-parks')}>
					<TextareaControl
						label={__('Default text (when visitor services field is empty)', 'my-parks')}
						value={defaultText}
						onChange={(value) => setAttributes({ defaultText: value })}
						help={__('This text will be displayed when the visitor services field is empty.', 'my-parks')}
					/>
				</PanelBody>
			</InspectorControls>
			<p { ...useBlockProps() }>
				{__('Visitor Services content will display here', 'my-parks')}
			</p>
		</>
	);
}
