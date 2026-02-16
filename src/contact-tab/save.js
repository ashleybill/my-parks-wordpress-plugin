import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const { title } = attributes;

	return (
		<div {...useBlockProps.save({ 'data-title': title })}>
			<InnerBlocks.Content />
		</div>
	);
}
