document.addEventListener('DOMContentLoaded', () => {
	const searchInput = document.querySelector('.park-search-filter input[type="search"]');
	if (!searchInput) return;
	
	const allCards = Array.from(document.querySelectorAll('.wp-block-my-parks-park-flip-card')).map(card => card.closest('li'));
	const itemsPerPage = 6;
	let currentlyShowing = itemsPerPage;
	let filteredCards = allCards;
	let searchActive = false;
	let filtersActive = false;
	
	const noResults = document.createElement('div');
	noResults.className = 'no-parks-found-search';
	noResults.textContent = 'No matching parks found.';
	noResults.style.cssText = 'display: none; padding: 2rem; text-align: center; color: #666; font-size: 1.1rem;';
	allCards[0]?.parentElement.parentElement.appendChild(noResults);
	
	function updateDisplay() {
		const searchTerm = searchInput.value.toLowerCase();
		searchActive = !!searchTerm;
		
		// Clear filters when starting to search
		if (searchActive && filtersActive) {
			filtersActive = false;
			// Trigger filter clear event to reset taxonomy filter UI
			window.dispatchEvent(new CustomEvent('search-clearing-filters'));
		}
		
		if (!searchActive) {
			// Reset to initial state when search is cleared
			currentlyShowing = itemsPerPage;
			allCards.forEach(li => li.style.display = 'none');
			allCards.slice(0, itemsPerPage).forEach(li => li.style.display = '');
			noResults.style.display = 'none';
			return;
		}
		
		filteredCards = allCards.filter(li => {
			const card = li.querySelector('.wp-block-my-parks-park-flip-card');
			const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
			return title.includes(searchTerm);
		});
		
		currentlyShowing = filteredCards.length;
		
		allCards.forEach(li => li.style.display = 'none');
		filteredCards.forEach(li => li.style.display = '');
		noResults.style.display = filteredCards.length === 0 ? 'block' : 'none';
	}
	
	function loadMore() {
		if (searchActive || filtersActive) return;
		
		const scrollPosition = window.innerHeight + window.scrollY;
		const pageHeight = document.documentElement.scrollHeight;
		
		if (scrollPosition >= pageHeight - 500 && currentlyShowing < allCards.length) {
			currentlyShowing += itemsPerPage;
			allCards.slice(0, currentlyShowing).forEach(li => li.style.display = '');
		}
	}
	
	searchInput.addEventListener('input', updateDisplay);
	
	// Prevent form submission on Enter key
	searchInput.closest('form').addEventListener('submit', (e) => {
		e.preventDefault();
		return false;
	});
	
	window.addEventListener('scroll', loadMore);
	
	// Clear search when filters are applied
	window.addEventListener('park-filter-applied', () => {
		searchInput.value = '';
		searchActive = false;
		filtersActive = true;
		noResults.style.display = 'none';
	});
	
	// Re-enable infinite scroll when filters are cleared
	window.addEventListener('park-filters-cleared', () => {
		filtersActive = false;
		currentlyShowing = itemsPerPage;
		allCards.forEach(li => li.style.display = 'none');
		allCards.slice(0, itemsPerPage).forEach(li => li.style.display = '');
	});
	
	// Initial display - show first page
	if (!filtersActive) {
		allCards.forEach(li => li.style.display = 'none');
		allCards.slice(0, itemsPerPage).forEach(li => li.style.display = '');
	}
});
