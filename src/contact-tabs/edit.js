import { __ } from '@wordpress/i18n';
import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';

export default function Edit({ attributes, setAttributes, clientId }) {
	const { activeTab } = attributes;

	const innerBlocks = useSelect(
		(select) => select('core/block-editor').getBlock(clientId)?.innerBlocks || [],
		[clientId]
	);

	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'tabs-content' },
		{
			allowedBlocks: ['my-parks/contact-tab'],
			template: [
				['my-parks/contact-tab', { title: 'Tab 1' }]
			],
			renderAppender: false
		}
	);

	return (
		<div {...useBlockProps()}>
			<div className="contact-tabs">
				<div className="tabs-nav">
					{innerBlocks.map((block, index) => (
						<button
							key={block.clientId}
							className={`tab-button ${activeTab === index ? 'active' : ''}`}
							onClick={() => setAttributes({ activeTab: index })}
						>
							{block.attributes.title}
						</button>
					))}
				</div>
				<div {...innerBlocksProps} />
			</div>
		</div>
	);
}
