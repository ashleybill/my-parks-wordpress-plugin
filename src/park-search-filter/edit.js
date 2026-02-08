import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
	return (
		<div { ...useBlockProps() }>
			<input 
				type="search" 
				placeholder={__('Search parks...', 'my-parks')}
				disabled
				style={{ width: '100%', padding: '0.75rem', border: '1px solid #ddd', borderRadius: '4px' }}
			/>
		</div>
	);
}
