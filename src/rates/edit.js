import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, PanelColorSettings } from '@wordpress/block-editor';
import { PanelRow } from '@wordpress/components';
import './editor.scss';

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
						title={__('Accordion Colors', 'my-parks')}
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
						{__('Sample Fee Type', 'my-parks')}
					</summary>
					<div className="accordion-content" style={{...contentStyle, height: 'auto'}}>
						<table className="rates-table">
							<tr>
								<td>{__('Adult', 'my-parks')}</td>
								<td>$10.00</td>
							</tr>
							<tr>
								<td>{__('Child', 'my-parks')}</td>
								<td>$5.00</td>
							</tr>
						</table>
					</div>
				</details>
			</div>
		</>
	);
}
