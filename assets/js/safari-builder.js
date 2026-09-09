/**
 * B.O-Safari-theme Custom Safari Builder Multi-Step JavaScript
 *
 * Multi-step custom safari builder workflow with step transitions and validation.
 */

document.addEventListener('DOMContentLoaded', () => {
	'use strict';

	const builderForm = document.querySelector('#custom-safari-builder-form');
	if (!builderForm) return;

	let currentStep = 1;
	const totalSteps = 10;

	const panels = builderForm.querySelectorAll('.builder-step-panel');
	const progressFill = document.querySelector('.builder-progress-fill');
	const dots = document.querySelectorAll('.builder-step-dot');
	const prevBtn = document.querySelector('#builder-prev-btn');
	const nextBtn = document.querySelector('#builder-next-btn');
	const submitBtn = document.querySelector('#builder-submit-btn');
	const stepTitleDisplay = document.querySelector('#builder-current-step-title');

	const stepTitles = [
		'Step 1: Select Your Destination',
		'Step 2: Travel Dates & Season',
		'Step 3: Number of Travellers',
		'Step 4: Preferred Travel Style',
		'Step 5: Accommodation Comfort Level',
		'Step 6: Signature Experiences',
		'Step 7: Wildlife Interests',
		'Step 8: Approximate Budget Range',
		'Step 9: Special Requests & Preferences',
		'Step 10: Your Contact Details'
	];

	// Update UI for step transition
	const updateStep = (step) => {
		currentStep = step;

		// Update panels
		panels.forEach((panel, index) => {
			if (index + 1 === currentStep) {
				panel.classList.add('is-active');
			} else {
				panel.classList.remove('is-active');
			}
		});

		// Update Progress Bar & Dots
		if (progressFill) {
			const percent = ((currentStep - 1) / (totalSteps - 1)) * 100;
			progressFill.style.width = `${percent}%`;
		}

		dots.forEach((dot, index) => {
			const stepNum = index + 1;
			dot.classList.remove('is-active', 'is-completed');
			if (stepNum === currentStep) {
				dot.classList.add('is-active');
			} else if (stepNum < currentStep) {
				dot.classList.add('is-completed');
			}
		});

		// Update Step Title
		if (stepTitleDisplay && stepTitles[currentStep - 1]) {
			stepTitleDisplay.textContent = stepTitles[currentStep - 1];
		}

		// Update Buttons
		if (prevBtn) {
			prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-flex';
		}
		if (nextBtn) {
			nextBtn.style.display = currentStep === totalSteps ? 'none' : 'inline-flex';
		}
		if (submitBtn) {
			submitBtn.style.display = currentStep === totalSteps ? 'inline-flex' : 'none';
		}

		// Scroll to top of builder
		builderForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
	};

	// Validation per step
	const validateCurrentStep = () => {
		const currentPanel = builderForm.querySelector(`.builder-step-panel[data-step="${currentStep}"]`);
		if (!currentPanel) return true;

		const requiredInputs = currentPanel.querySelectorAll('[required]');
		let isValid = true;

		requiredInputs.forEach(input => {
			if (input.type === 'radio' || input.type === 'checkbox') {
				const groupName = input.name;
				const checked = currentPanel.querySelector(`input[name="${groupName}"]:checked`);
				if (!checked) {
					isValid = false;
				}
			} else if (!input.value.trim()) {
				isValid = false;
				input.classList.add('border-red-500');
			} else {
				input.classList.remove('border-red-500');
			}
		});

		if (!isValid) {
			alert('Please complete all required fields on this step before proceeding.');
		}

		return isValid;
	};

	// Button Handlers
	if (nextBtn) {
		nextBtn.addEventListener('click', () => {
			if (validateCurrentStep() && currentStep < totalSteps) {
				updateStep(currentStep + 1);
			}
		});
	}

	if (prevBtn) {
		prevBtn.addEventListener('click', () => {
			if (currentStep > 1) {
				updateStep(currentStep - 1);
			}
		});
	}

	// Interactive Option Card Selectors
	const optionCards = builderForm.querySelectorAll('.option-card');
	optionCards.forEach(card => {
		card.addEventListener('click', () => {
			const input = card.querySelector('input');
			if (!input) return;

			if (input.type === 'radio') {
				const name = input.name;
				builderForm.querySelectorAll(`input[name="${name}"]`).forEach(r => {
					const parent = r.closest('.option-card');
					if (parent) parent.classList.remove('is-selected');
				});
				input.checked = true;
				card.classList.add('is-selected');
			} else if (input.type === 'checkbox') {
				input.checked = !input.checked;
				card.classList.toggle('is-selected', input.checked);
			}
		});
	});

	// Form Submission
	builderForm.addEventListener('submit', async (e) => {
		e.preventDefault();

		if (!validateCurrentStep()) return;

		const feedback = builderForm.querySelector('.builder-feedback');
		if (submitBtn) {
			submitBtn.disabled = true;
			submitBtn.textContent = 'Submitting Request...';
		}

		const formData = new FormData(builderForm);
		formData.append('action', 'bo_safari_submit_custom_builder');
		formData.append('nonce', window.boSafariData?.nonce || '');

		try {
			const response = await fetch(window.boSafariData?.ajaxUrl || '/wp-admin/admin-ajax.php', {
				method: 'POST',
				body: formData
			});

			const result = await response.json();

			if (result.success) {
				if (feedback) {
					feedback.className = 'builder-feedback p-6 rounded-lg bg-green-50 border border-green-200 text-green-900 text-center my-6';
					feedback.innerHTML = `<h3 class="text-2xl font-serif font-bold mb-2">Safari Request Received!</h3><p>${result.data?.message || 'Our travel specialists will tailor your itinerary and contact you within 24 hours.'}</p>`;
				}
				builderForm.reset();
				if (submitBtn) submitBtn.style.display = 'none';
				if (prevBtn) prevBtn.style.display = 'none';
				document.dispatchEvent(new CustomEvent('bo_safari_custom_builder_submitted', { detail: result.data }));
			} else {
				throw new Error(result.data?.message || 'Failed to submit safari request.');
			}
		} catch (err) {
			if (feedback) {
				feedback.className = 'builder-feedback p-6 rounded-lg bg-red-50 border border-red-200 text-red-900 text-center my-6';
				feedback.textContent = err.message || 'An error occurred. Please try again.';
			}
		} finally {
			if (submitBtn && submitBtn.style.display !== 'none') {
				submitBtn.disabled = false;
				submitBtn.textContent = 'Submit My Custom Safari';
			}
		}
	});

	// Initialize Step 1
	updateStep(1);
});
