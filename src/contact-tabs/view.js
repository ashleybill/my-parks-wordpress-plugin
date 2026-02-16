document.addEventListener('DOMContentLoaded', function() {
	const tabContainers = document.querySelectorAll('.wp-block-my-parks-contact-tabs .contact-tabs');

	tabContainers.forEach(container => {
		const tabsNav = container.querySelector('.tabs-nav');
		const tabs = container.querySelectorAll('.tabs-content > .wp-block-my-parks-contact-tab');
		const activeIndex = parseInt(container.dataset.activeTab) || 0;

		tabs.forEach((tab, index) => {
			const button = document.createElement('button');
			button.className = 'tab-button';
			button.textContent = tab.dataset.title || `Tab ${index + 1}`;
			
			if (index === activeIndex) {
				button.classList.add('active');
				tab.classList.add('active');
			}

			button.addEventListener('click', () => {
				container.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
				tabs.forEach(t => t.classList.remove('active'));
				
				button.classList.add('active');
				tab.classList.add('active');
			});

			tabsNav.appendChild(button);
		});
	});
});
