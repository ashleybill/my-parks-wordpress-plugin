// Simple custom slider
function initSliders() {
	document.querySelectorAll('.wp-block-my-parks-gallery-slider').forEach(function(block) {
		if (block.dataset.initialized) return;
		block.dataset.initialized = 'true';
		
		const slider = block.querySelector('.glider');
		const prevBtn = block.querySelector('.glider-prev');
		const nextBtn = block.querySelector('.glider-next');
		const dotsContainer = block.querySelector('.glider-dots');
		const slides = Array.from(slider.children);
		const autoplay = block.dataset.autoplay === 'true';
		const autoplaySpeed = parseFloat(block.dataset.autoplaySpeed || 5) * 1000;
		
		if (slides.length === 0) return;
		if (slides.length === 1) return; // Don't initialize slider for single image
		
		let currentIndex = 0;
		let autoplayInterval;
		
		// Create dots
		dotsContainer.innerHTML = '';
		slides.forEach((_, i) => {
			const dot = document.createElement('button');
			dot.className = 'glider-dot' + (i === 0 ? ' active' : '');
			dot.addEventListener('click', () => {
				goToSlide(i);
				resetAutoplay();
			});
			dotsContainer.appendChild(dot);
		});
		
		const dots = Array.from(dotsContainer.children);
		
		function goToSlide(index) {
			// Wrap around for infinite loop
			if (index < 0) {
				index = slides.length - 1;
			} else if (index >= slides.length) {
				index = 0;
			}
			
			currentIndex = index;
			slider.scrollTo({
				left: currentIndex * slider.clientWidth,
				behavior: 'smooth'
			});
			updateControls();
		}
		
		function updateControls() {
			prevBtn.disabled = false;
			nextBtn.disabled = false;
			dots.forEach((dot, i) => {
				dot.classList.toggle('active', i === currentIndex);
			});
		}
		
		function startAutoplay() {
			if (!autoplay) return;
			autoplayInterval = setInterval(() => {
				goToSlide(currentIndex + 1);
			}, autoplaySpeed);
		}
		
		function stopAutoplay() {
			if (autoplayInterval) {
				clearInterval(autoplayInterval);
			}
		}
		
		function resetAutoplay() {
			stopAutoplay();
			startAutoplay();
		}
		
		prevBtn.addEventListener('click', () => {
			goToSlide(currentIndex - 1);
			resetAutoplay();
		});
		
		nextBtn.addEventListener('click', () => {
			goToSlide(currentIndex + 1);
			resetAutoplay();
		});
		
		// Track manual scrolling/swiping
		let scrollTimeout;
		let pauseTimeout;
		slider.addEventListener('scroll', () => {
			clearTimeout(scrollTimeout);
			scrollTimeout = setTimeout(() => {
				const newIndex = Math.round(slider.scrollLeft / slider.clientWidth);
				if (newIndex !== currentIndex && newIndex >= 0 && newIndex < slides.length) {
					currentIndex = newIndex;
					updateControls();
					// Pause autoplay for 3 seconds after manual scroll
					stopAutoplay();
					clearTimeout(pauseTimeout);
					pauseTimeout = setTimeout(() => {
						startAutoplay();
					}, 3000);
				}
			}, 100);
		});
		
		// Pause autoplay on hover
		block.addEventListener('mouseenter', stopAutoplay);
		block.addEventListener('mouseleave', startAutoplay);
		
		updateControls();
		startAutoplay();
	});
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', initSliders);
} else {
	initSliders();
}

if (window.wp && window.wp.data) {
	setTimeout(initSliders, 100);
}
