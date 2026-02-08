import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, CheckboxControl, ToggleControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';

export default function Edit({ attributes, setAttributes }) {
	const { presetActivities, presetFacilities, presetLocations, hideFilter } = attributes;

	const { activities, facilities, locations } = useSelect((select) => {
		const { getEntityRecords } = select('core');
		return {
			activities: getEntityRecords('taxonomy', 'activity', { per_page: -1 }) || [],
			facilities: getEntityRecords('taxonomy', 'facility', { per_page: -1 }) || [],
			locations: getEntityRecords('taxonomy', 'location', { per_page: -1 }) || []
		};
	});

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Filter Settings', 'my-parks')}>
					<ToggleControl
						label={__('Hide Filter UI', 'my-parks')}
						checked={hideFilter}
						onChange={(value) => setAttributes({ hideFilter: value })}
					/>
				</PanelBody>
				<PanelBody title={__('Preset Activities', 'my-parks')} initialOpen={false}>
					{activities.map(term => (
						<CheckboxControl
							key={term.id}
							label={term.name}
							checked={presetActivities.includes(term.slug)}
							onChange={(checked) => {
								const newPresets = checked
									? [...presetActivities, term.slug]
									: presetActivities.filter(s => s !== term.slug);
								setAttributes({ presetActivities: newPresets });
							}}
						/>
					))}
				</PanelBody>
				<PanelBody title={__('Preset Facilities', 'my-parks')} initialOpen={false}>
					{facilities.map(term => (
						<CheckboxControl
							key={term.id}
							label={term.name}
							checked={presetFacilities.includes(term.slug)}
							onChange={(checked) => {
								const newPresets = checked
									? [...presetFacilities, term.slug]
									: presetFacilities.filter(s => s !== term.slug);
								setAttributes({ presetFacilities: newPresets });
							}}
						/>
					))}
				</PanelBody>
				<PanelBody title={__('Preset Locations', 'my-parks')} initialOpen={false}>
					{locations.map(term => (
						<CheckboxControl
							key={term.id}
							label={term.name}
							checked={presetLocations.includes(term.slug)}
							onChange={(checked) => {
								const newPresets = checked
									? [...presetLocations, term.slug]
									: presetLocations.filter(s => s !== term.slug);
								setAttributes({ presetLocations: newPresets });
							}}
						/>
					))}
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps()}>
				{hideFilter ? (
					<p style={{ padding: '1rem', background: '#f0f0f0', border: '1px dashed #ccc' }}>
						{__('Filter hidden (presets active)', 'my-parks')}
					</p>
				) : (
					<p style={{ padding: '1rem', background: '#f0f0f0', border: '1px dashed #ccc' }}>
						{__('Taxonomy filter controls', 'my-parks')}
					</p>
				)}
			</div>
		</>
	);
}
