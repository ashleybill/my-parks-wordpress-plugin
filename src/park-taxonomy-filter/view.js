document.addEventListener('DOMContentLoaded', () => {
	const filterBlock = document.querySelector('.park-taxonomy-filter');
	if (!filterBlock) return;

	const allCards = Array.from(document.querySelectorAll('.wp-block-my-parks-park-flip-card')).map(card => card.closest('li'));
	const checkboxes = filterBlock.querySelectorAll('input[type="checkbox"]');
	const toggleBtns = filterBlock.querySelectorAll('.filter-toggle');
	const clearBtn = filterBlock.querySelector('.clear-filters');
	const applyBtns = filterBlock.querySelectorAll('.apply-filter');
	
	const noResults = document.createElement('div');
	noResults.className = 'no-parks-found-filter';
	noResults.textContent = 'No matching parks found.';
	noResults.style.cssText = 'display: none; padding: 2rem; text-align: center; color: #666; font-size: 1.1rem;';
	allCards[0]?.parentElement.parentElement.appendChild(noResults);
	
	// Toggle dropdowns
	toggleBtns.forEach(btn => {
		btn.addEventListener('click', (e) => {
			e.stopPropagation();
			const filterType = btn.dataset.filter;
			const dropdown = filterBlock.querySelector(`.filter-dropdown[data-filter="${filterType}"]`);
			
			if (dropdown.style.display === 'flex') {
				// Closing - apply filters
				updateFilter();
				dropdown.style.display = 'none';
				document.body.style.overflow = '';
			} else {
				// Opening - close others
				filterBlock.querySelectorAll('.filter-dropdown').forEach(d => {
					if (d !== dropdown) d.style.display = 'none';
				});
				
				if (window.innerWidth <= 599) {
					document.body.style.overflow = 'hidden';
				}
				
				dropdown.style.display = 'flex';
			}
		});
	});
	
	// Close buttons
	filterBlock.querySelectorAll('.filter-close').forEach(btn => {
		btn.addEventListener('click', (e) => {
			e.stopPropagation();
			btn.closest('.filter-dropdown').style.display = 'none';
			document.body.style.overflow = '';
		});
	});
	
	// Apply buttons
	applyBtns.forEach(btn => {
		btn.addEventListener('click', (e) => {
			e.stopPropagation();
			updateFilter();
			btn.closest('.filter-dropdown').style.display = 'none';
			document.body.style.overflow = '';
		});
	});
	
	// Prevent dropdown close on checkbox click
	filterBlock.querySelectorAll('.filter-dropdown').forEach(dropdown => {
		dropdown.addEventListener('click', (e) => {
			e.stopPropagation();
		});
	});
	
	// Clear filters
	if (clearBtn) {
		clearBtn.addEventListener('click', () => {
			checkboxes.forEach(cb => cb.checked = false);
			updateFilter();
		});
	}
	
	// Close on outside click
	document.addEventListener('click', (e) => {
		if (!filterBlock.contains(e.target)) {
			filterBlock.querySelectorAll('.filter-dropdown').forEach(d => d.style.display = 'none');
			document.body.style.overflow = '';
		}
	});
	
	// Apply presets for hidden filters
	if (filterBlock.classList.contains('hidden-filter')) {
		const presetActivities = JSON.parse(filterBlock.dataset.presetActivities || '[]');
		const presetFacilities = JSON.parse(filterBlock.dataset.presetFacilities || '[]');
		const presetLocations = JSON.parse(filterBlock.dataset.presetLocations || '[]');
		filterCards(presetActivities, presetFacilities, presetLocations);
		return;
	}

	function filterCards(selectedActivities, selectedFacilities, selectedLocations) {
		let visibleCount = 0;
		allCards.forEach(li => {
			const classes = li.className.split(' ');
			
			const hasAllActivities = selectedActivities.length === 0 || selectedActivities.every(slug => 
				classes.includes('activity-' + slug)
			);
			const hasAllFacilities = selectedFacilities.length === 0 || selectedFacilities.every(slug => 
				classes.includes('facility-' + slug)
			);
			const hasAllLocations = selectedLocations.length === 0 || selectedLocations.every(slug => 
				classes.includes('location-' + slug)
			);
			
			const isVisible = hasAllActivities && hasAllFacilities && hasAllLocations;
			li.style.display = isVisible ? '' : 'none';
			if (isVisible) visibleCount++;
		});
		noResults.style.display = visibleCount === 0 ? 'block' : 'none';
	}

	function updateFilter() {
		const selectedActivities = Array.from(filterBlock.querySelectorAll('input[name="activity"]:checked'))
			.map(cb => cb.value);
		const selectedFacilities = Array.from(filterBlock.querySelectorAll('input[name="facility"]:checked'))
			.map(cb => cb.value);
		const selectedLocations = Array.from(filterBlock.querySelectorAll('input[name="location"]:checked'))
			.map(cb => cb.value);
		
		filterCards(selectedActivities, selectedFacilities, selectedLocations);
		
		// Notify search block about filter state
		if (selectedActivities.length > 0 || selectedFacilities.length > 0 || selectedLocations.length > 0) {
			window.dispatchEvent(new Event('park-filter-applied'));
		} else {
			window.dispatchEvent(new Event('park-filters-cleared'));
		}
		
		// Show/hide clear button
		if (clearBtn) {
			clearBtn.style.display = (selectedActivities.length > 0 || selectedFacilities.length > 0 || selectedLocations.length > 0) ? '' : 'none';
		}
	}

	updateFilter();
});
