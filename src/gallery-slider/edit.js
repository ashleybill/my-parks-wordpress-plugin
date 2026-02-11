import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, MediaUpload, MediaPlaceholder } from '@wordpress/block-editor';
import { PanelBody, SelectControl, ToggleControl, RangeControl, Button } from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const { images, aspectRatio, autoplay, autoplaySpeed } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Gallery Images', 'my-parks')}>
					<MediaUpload
						onSelect={(media) => setAttributes({ images: media })}
						allowedTypes={['image']}
						multiple
						gallery
						value={images?.map(img => img.id)}
						render={({ open }) => (
							<Button onClick={open} variant="secondary">
								{images?.length ? __('Edit Gallery', 'my-parks') : __('Select Images', 'my-parks')}
							</Button>
						)}
					/>
					{images?.length > 0 && (
						<p style={{ marginTop: '8px' }}>{images.length} {__('images selected', 'my-parks')}</p>
					)}
				</PanelBody>
				<PanelBody title={__('Settings', 'my-parks')}>
					<SelectControl
						label={__('Aspect Ratio', 'my-parks')}
						value={aspectRatio}
						options={[
							{ label: 'Auto', value: 'auto' },
							{ label: '16:9', value: '16-9' },
							{ label: '4:3', value: '4-3' },
							{ label: '1:1', value: '1-1' },
							{ label: '21:9', value: '21-9' },
						]}
						onChange={(value) => setAttributes({ aspectRatio: value })}
					/>
					<ToggleControl
						label={__('Autoplay', 'my-parks')}
						checked={autoplay}
						onChange={(value) => setAttributes({ autoplay: value })}
					/>
					{autoplay && (
						<RangeControl
							label={__('Autoplay Speed (seconds)', 'my-parks')}
							value={autoplaySpeed}
							onChange={(value) => setAttributes({ autoplaySpeed: value })}
							min={2}
							max={10}
							step={0.5}
						/>
					)}
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
				<div className="glider-contain">
					<div className="glider-preview">
						<div className="slide-preview">
							<div style={{ background: '#f0f0f0', aspectRatio: '16/9', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
								{__('Gallery images will display here', 'my-parks')}
							</div>
						</div>
					</div>
					<button className="glider-prev">‹</button>
					<button className="glider-next">›</button>
					<div className="glider-dots">
						<button className="glider-dot active"></button>
						<button className="glider-dot"></button>
						<button className="glider-dot"></button>
					</div>
				</div>
			</div>
		</>
	);
}
