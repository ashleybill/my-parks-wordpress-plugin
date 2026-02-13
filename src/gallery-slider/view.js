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
		
		// Add lightbox functionality
		slides.forEach((slide, index) => {
			slide.addEventListener('click', () => {
				openLightbox(slides, index);
			});
			slide.style.cursor = 'pointer';
		});
		
		updateControls();
		startAutoplay();
	});
}

// Lightbox functionality
function openLightbox(images, startIndex = 0) {
	const lightbox = document.createElement('div');
	lightbox.className = 'gallery-lightbox';
	lightbox.innerHTML = `
		<div class="lightbox-overlay">
			<div class="lightbox-container">
				<button class="lightbox-close" aria-label="Close">×</button>
				<div class="lightbox-slider">
					${images.map(img => `<img src="${img.src}" alt="${img.alt}" />`).join('')}
				</div>
				${images.length > 1 ? `
					<button class="lightbox-prev" aria-label="Previous">‹</button>
					<button class="lightbox-next" aria-label="Next">›</button>
					<div class="lightbox-dots"></div>
				` : ''}
			</div>
		</div>
	`;
	
	document.body.appendChild(lightbox);
	document.body.style.overflow = 'hidden';
	
	const slider = lightbox.querySelector('.lightbox-slider');
	const closeBtn = lightbox.querySelector('.lightbox-close');
	const prevBtn = lightbox.querySelector('.lightbox-prev');
	const nextBtn = lightbox.querySelector('.lightbox-next');
	const dotsContainer = lightbox.querySelector('.lightbox-dots');
	const slides = Array.from(slider.children);
	let currentIndex = startIndex;
	
	// Initialize dots if multiple images
	if (images.length > 1) {
		slides.forEach((_, i) => {
			const dot = document.createElement('button');
			dot.className = 'lightbox-dot' + (i === startIndex ? ' active' : '');
			dot.addEventListener('click', () => goToSlide(i));
			dotsContainer.appendChild(dot);
		});
	}
	
	const dots = Array.from(dotsContainer?.children || []);
	
	function goToSlide(index) {
		if (index < 0) index = slides.length - 1;
		else if (index >= slides.length) index = 0;
		
		currentIndex = index;
		slider.scrollTo({
			left: currentIndex * slider.clientWidth,
			behavior: 'smooth'
		});
		updateDots();
	}
	
	function updateDots() {
		dots.forEach((dot, i) => {
			dot.classList.toggle('active', i === currentIndex);
		});
	}
	
	function closeLightbox() {
		document.body.removeChild(lightbox);
		document.body.style.overflow = '';
	}
	
	// Event listeners
	closeBtn.addEventListener('click', closeLightbox);
	lightbox.querySelector('.lightbox-overlay').addEventListener('click', (e) => {
		if (e.target === e.currentTarget) closeLightbox();
	});
	
	if (prevBtn) {
		prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));
		nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));
	}
	
	// Keyboard navigation
	document.addEventListener('keydown', function handleKeydown(e) {
		if (e.key === 'Escape') {
			closeLightbox();
			document.removeEventListener('keydown', handleKeydown);
		} else if (e.key === 'ArrowLeft' && prevBtn) {
			goToSlide(currentIndex - 1);
		} else if (e.key === 'ArrowRight' && nextBtn) {
			goToSlide(currentIndex + 1);
		}
	});
	
	// Handle orientation changes
	window.addEventListener('orientationchange', () => {
		setTimeout(() => goToSlide(currentIndex), 100);
	});
	
	// Touch/swipe support
	let startX = 0;
	slider.addEventListener('touchstart', (e) => {
		startX = e.touches[0].clientX;
	});
	
	slider.addEventListener('touchend', (e) => {
		const endX = e.changedTouches[0].clientX;
		const diff = startX - endX;
		
		if (Math.abs(diff) > 50) {
			if (diff > 0 && nextBtn) goToSlide(currentIndex + 1);
			else if (diff < 0 && prevBtn) goToSlide(currentIndex - 1);
		}
	});
	
	// Initialize position
	setTimeout(() => goToSlide(startIndex), 50);
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', initSliders);
} else {
	initSliders();
}

if (window.wp && window.wp.data) {
	setTimeout(initSliders, 100);
}
