document.addEventListener('DOMContentLoaded', function() {
	const tabContainers = document.querySelectorAll('.wp-block-my-parks-contact-tabs .contact-tabs');

	tabContainers.forEach(container => {
		const tabsNav = container.querySelector('.tabs-nav');
		const tabs = container.querySelectorAll('.tabs-content > .wp-block-my-parks-contact-tab');
		let activeIndex = parseInt(container.dataset.activeTab) || 0;

		const activateTab = (index) => {
			container.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
			tabs.forEach(t => t.classList.remove('active'));
			
			const buttons = container.querySelectorAll('.tab-button');
			if (buttons[index]) {
				buttons[index].classList.add('active');
			}
			if (tabs[index]) {
				tabs[index].classList.add('active');
			}
		};

		// Check URL hash on load
		const checkHash = () => {
			const hash = window.location.hash.slice(1);
			if (!hash) return false;
			
			const tabIndex = Array.from(tabs).findIndex(tab => {
				const title = (tab.dataset.title || '').toLowerCase().replace(/\s+/g, '-');
				return title === hash;
			});
			
			if (tabIndex !== -1) {
				activeIndex = tabIndex;
				return true;
			}
			return false;
		};

		checkHash();

		tabs.forEach((tab, index) => {
			const button = document.createElement('button');
			button.className = 'tab-button';
			const title = tab.dataset.title || `Tab ${index + 1}`;
			button.textContent = title;
			
			if (index === activeIndex) {
				button.classList.add('active');
				tab.classList.add('active');
			}

			button.addEventListener('click', () => {
				activeIndex = index;
				activateTab(index);
				
				// Update URL hash
				const hash = title.toLowerCase().replace(/\s+/g, '-');
				history.pushState(null, null, `#${hash}`);
			});

			tabsNav.appendChild(button);
		});

		// Handle hash changes (back/forward navigation)
		window.addEventListener('hashchange', () => {
			if (checkHash()) {
				activateTab(activeIndex);
			}
		});
	});
});
