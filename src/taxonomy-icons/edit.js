import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const { taxonomy, maxPerRow } = attributes;

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
					<SelectControl
						label={__('Max Icons Per Row', 'my-parks')}
						value={maxPerRow}
						options={[
							{ label: '4', value: 4 },
							{ label: '6', value: 6 },
							{ label: '8', value: 8 },
							{ label: '10', value: 10 },
						]}
						onChange={(value) => setAttributes({ maxPerRow: parseInt(value) })}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps()}>
				<div style={{ display: 'grid', gridTemplateColumns: `repeat(${maxPerRow}, 1fr)`, gap: '0.75rem', padding: '1rem', border: '1px dashed #ccc', maxWidth: `${maxPerRow * 40}px` }}>
					{[...Array(maxPerRow)].map((_, i) => (
						<div key={i} style={{ width: '32px', height: '32px', background: '#f0f0f0', borderRadius: '4px' }} />
					))}
				</div>
				<p style={{ marginTop: '0.5rem', fontSize: '0.9em', color: '#666', whiteSpace: 'nowrap' }}>
					{taxonomy === 'activity' ? 'Activities' : 'Facilities'} icons (max {maxPerRow} per row)
				</p>
			</div>
		</>
	);
}
