import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, PanelColorSettings } from '@wordpress/block-editor';
import './editor.scss';
import { PanelRow } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const summaryStyle = {
		...(attributes.summaryTextColor && { color: attributes.summaryTextColor }),
		...(attributes.summaryBackgroundColor && { backgroundColor: attributes.summaryBackgroundColor })
	};
	const contentStyle = {
		...(attributes.contentTextColor && { color: attributes.contentTextColor }),
		...(attributes.contentBackgroundColor && { backgroundColor: attributes.contentBackgroundColor })
	};

	return (
		<>
			<InspectorControls group="color">
				<PanelRow>
					<PanelColorSettings
						title={__('Accordian Colors', 'my-parks')}
						initialOpen={true}
						colorSettings={[
							{
								value: attributes.summaryTextColor,
								onChange: (color) => setAttributes({ summaryTextColor: color }),
								label: __('Text', 'my-parks')
							},
							{
								value: attributes.summaryBackgroundColor,
								onChange: (color) => setAttributes({ summaryBackgroundColor: color }),
								label: __('Background', 'my-parks')
							},
							{
								value: attributes.summaryHoverTextColor,
								onChange: (color) => setAttributes({ summaryHoverTextColor: color }),
								label: __('Hover Text', 'my-parks')
							},
							{
								value: attributes.summaryHoverBackgroundColor,
								onChange: (color) => setAttributes({ summaryHoverBackgroundColor: color }),
								label: __('Hover Background', 'my-parks')
							},
							{
								value: attributes.contentTextColor,
								onChange: (color) => setAttributes({ contentTextColor: color }),
								label: __('Text', 'my-parks')
							},
							{
								value: attributes.contentBackgroundColor,
								onChange: (color) => setAttributes({ contentBackgroundColor: color }),
								label: __('Background', 'my-parks')
							}
						]}
					/>
				</PanelRow>
			</InspectorControls>
			<div { ...useBlockProps() }>
				<details open>
					<summary style={summaryStyle}>
						<span className="facility-name">{__('Sample Facility', 'my-parks')}</span>
						<span className="date-range">{__('May 1 - September 30', 'my-parks')}</span>
					</summary>
					<div className="accordion-content" style={{...contentStyle, height: 'auto'}}>
						<p>{__('Sample operational details', 'my-parks')}</p>
					</div>
				</details>
			</div>
		</>
	);
}
