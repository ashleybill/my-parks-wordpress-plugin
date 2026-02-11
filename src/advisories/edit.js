import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, PanelColorSettings } from '@wordpress/block-editor';
import './editor.scss';
import { PanelBody, TextControl, SelectControl } from '@wordpress/components';
import { PanelRow } from '@wordpress/components';
import { useSelect } from '@wordpress/data';

export default function Edit({ attributes, setAttributes }) {
	const parks = useSelect((select) => {
		return select('core').getEntityRecords('postType', 'park', { per_page: -1 });
	}, []);

	const parkOptions = parks ? [
		{ label: __('Current Park (from page context)', 'my-parks'), value: 0 },
		...parks.map(park => ({ label: park.title.rendered, value: park.id }))
	] : [{ label: __('Loading...', 'my-parks'), value: 0 }];

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
			<InspectorControls>
				<PanelBody title={__('Settings', 'my-parks')}>
					<SelectControl
						label={__('Select Park', 'my-parks')}
						value={attributes.parkId || 0}
						options={parkOptions}
						onChange={(value) => setAttributes({ parkId: parseInt(value) })}
						help={__('Leave as default to use the current page context', 'my-parks')}
					/>
					<TextControl
						label={__('Empty Message', 'my-parks')}
						value={attributes.emptyMessage}
						onChange={(value) => setAttributes({ emptyMessage: value })}
						help={__('Message to display when there are no advisories', 'my-parks')}
					/>
				</PanelBody>
			</InspectorControls>
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
						{__('Sample Advisory Title', 'my-parks')}
					</summary>
					<div className="accordion-content" style={{...contentStyle, height: 'auto'}}>
						<p>{__('Sample advisory description', 'my-parks')}</p>
					</div>
				</details>
			</div>
		</>
	);
}
