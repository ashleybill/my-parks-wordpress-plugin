import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
	return (
		<p { ...useBlockProps() }>
			{__('This is where your about content will continue after the initial short section. Add more detailed information about the park in here', 'my-parks')}
		</p>
	);
}
