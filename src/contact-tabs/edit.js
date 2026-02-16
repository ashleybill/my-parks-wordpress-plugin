import { __ } from '@wordpress/i18n';
import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { useEffect } from '@wordpress/element';

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

	useEffect(() => {
		let isUpdating = false;
		
		const updateTabs = () => {
			if (isUpdating) return;
			isUpdating = true;
			
			const tabBlocks = document.querySelectorAll(`[data-block="${clientId}"] .tabs-content > .wp-block-my-parks-contact-tab`);
			if (tabBlocks.length === 0) {
				isUpdating = false;
				return false;
			}
			
			tabBlocks.forEach((block, index) => {
				if (index === activeTab) {
					if (!block.classList.contains('is-active-tab')) {
						block.classList.add('is-active-tab');
					}
				} else {
					if (block.classList.contains('is-active-tab')) {
						block.classList.remove('is-active-tab');
					}
				}
			});
			
			isUpdating = false;
			return true;
		};

		if (updateTabs()) {
			const observer = new MutationObserver(updateTabs);
			const container = document.querySelector(`[data-block="${clientId}"] .tabs-content`);
			if (container) {
				observer.observe(container, { 
					childList: true, 
					subtree: true, 
					attributes: true,
					attributeFilter: ['class']
				});
				return () => observer.disconnect();
			}
		}

		const timers = [10, 50, 100, 200].map(delay => 
			setTimeout(updateTabs, delay)
		);

		return () => timers.forEach(clearTimeout);
	}, [activeTab, clientId, innerBlocks.length]);

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
