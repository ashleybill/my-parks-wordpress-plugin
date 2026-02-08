import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import './editor.scss';

export default function Edit() {
	return (
		<div { ...useBlockProps() }>
			<div className="flip-card-inner">
				<div className="flip-card-front" style={{ background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' }}>
					<div className="flip-card-overlay">
						<h3>{__('Park Title', 'my-parks')}</h3>
					</div>
				</div>
				<div className="flip-card-back">
					<div className="flip-card-content">
						<h3>{__('Park Title', 'my-parks')}</h3>
						<p>{__('Park excerpt will appear here...', 'my-parks')}</p>
						<span className="flip-card-button">{__('Learn More', 'my-parks')}</span>
					</div>
				</div>
			</div>
		</div>
	);
}
