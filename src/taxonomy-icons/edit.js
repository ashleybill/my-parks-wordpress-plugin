import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, RangeControl } from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const { taxonomy, iconSize } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Settings', 'my-parks')}>
					<SelectControl
						label={__('Taxonomy', 'my-parks')}
						value={taxonomy}
						options={[
							{ label: 'Activities', value: 'activity' },
							{ label: 'Facilities', value: 'facility' },
						]}
						onChange={(value) => setAttributes({ taxonomy: value })}
					/>
					<RangeControl
						label={__('Icon Size (px)', 'my-parks')}
						value={iconSize}
						min={16}
						max={64}
						onChange={(value) => setAttributes({ iconSize: value })}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps()}>
				<div style={{ 
					display: 'grid', 
					gridTemplateColumns: `repeat(auto-fit, minmax(${iconSize}px, 1fr))`, 
					gap: '0.75rem', 
					padding: '1rem', 
					border: '1px dashed #ccc',
					maxWidth: '100%'
				}}>
					{[...Array(6)].map((_, i) => (
						<div key={i} style={{ 
							width: `${iconSize}px`, 
							height: `${iconSize}px`, 
							background: '#f0f0f0', 
							borderRadius: '4px' 
						}} />
					))}
				</div>
				<p style={{ marginTop: '0.5rem', fontSize: '0.9em', color: '#666' }}>
					{taxonomy === 'activity' ? 'Activities' : 'Facilities'} icons ({iconSize}px each)
				</p>
			</div>
		</>
	);
}
