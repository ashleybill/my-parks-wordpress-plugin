import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const { activeTab } = attributes;

	return (
		<div {...useBlockProps.save()}>
			<div className="contact-tabs" data-active-tab={activeTab}>
				<div className="tabs-nav"></div>
				<div className="tabs-content">
					<InnerBlocks.Content />
				</div>
			</div>
		</div>
	);
}
