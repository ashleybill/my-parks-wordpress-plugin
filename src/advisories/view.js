document.querySelectorAll('.wp-block-my-parks-advisories details').forEach(d => {
	const content = d.querySelector('.accordion-content');
	const summary = d.querySelector('summary');
	
	d.addEventListener('toggle', e => {
		if (e.target.open) {
			// Close others smoothly
			document.querySelectorAll('.wp-block-my-parks-advisories details[open]').forEach(o => {
				if (o !== e.target) {
					const otherContent = o.querySelector('.accordion-content');
					otherContent.style.height = '0';
					setTimeout(() => o.removeAttribute('open'), 300);
				}
			});
			// Open current
			content.style.height = content.scrollHeight + 'px';
		}
	});
	
	summary.addEventListener('click', e => {
		if (d.open) {
			e.preventDefault();
			content.style.height = '0';
			setTimeout(() => d.removeAttribute('open'), 300);
		}
	});
});
