import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
	return (
		<p { ...useBlockProps() }>
			{__('This is where your about content will start with a short description to go alongside the image gallery', 'my-parks')}
		</p>
	);
}
