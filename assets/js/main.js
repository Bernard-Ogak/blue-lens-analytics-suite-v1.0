/**
 * B.O-Safari-theme Core JavaScript
 *
 * Handles sticky header, mobile drawer, accordions, tabs, lightboxes, enquiry modals, and analytics.
 */

document.addEventListener('DOMContentLoaded', () => {
	'use strict';

	/* ==========================================================================
	   1. STICKY HEADER
	   ========================================================================== */
	const header = document.querySelector('.site-header');
	if (header) {
		const handleScroll = () => {
			if (window.scrollY > 50) {
				header.classList.add('is-sticky');
			} else {
				header.classList.remove('is-sticky');
			}
		};
		window.addEventListener('scroll', handleScroll, { passive: true });
		handleScroll();
	}

	/* ==========================================================================
	   2. MOBILE MENU DRAWER
	   ========================================================================== */
	const menuToggle = document.querySelector('.mobile-menu-toggle');
	const mobileDrawer = document.querySelector('.mobile-drawer');
	const drawerOverlay = document.querySelector('.drawer-overlay');
	const drawerClose = document.querySelector('.mobile-drawer-close');

	const openDrawer = () => {
		if (mobileDrawer) mobileDrawer.classList.add('is-open');
		if (drawerOverlay) drawerOverlay.classList.add('is-active');
		document.body.style.overflow = 'hidden';
	};

	const closeDrawer = () => {
		if (mobileDrawer) mobileDrawer.classList.remove('is-open');
		if (drawerOverlay) drawerOverlay.classList.remove('is-active');
		document.body.style.overflow = '';
	};

	if (menuToggle) menuToggle.addEventListener('click', openDrawer);
	if (drawerClose) drawerClose.addEventListener('click', closeDrawer);
	if (drawerOverlay) drawerOverlay.addEventListener('click', closeDrawer);

	/* ==========================================================================
	   3. ACCORDION (ITINERARY & FAQ)
	   ========================================================================== */
	const accordions = document.querySelectorAll('.itinerary-header, .faq-header');
	accordions.forEach(header => {
		header.addEventListener('click', () => {
			const item = header.closest('.itinerary-item, .faq-item');
			if (!item) return;

			const isActive = item.classList.contains('is-active');

			// Close siblings if inside a single-expand group
			const parent = item.closest('.accordion-group');
			if (parent && parent.dataset.single === 'true') {
				parent.querySelectorAll('.itinerary-item, .faq-item').forEach(child => {
					child.classList.remove('is-active');
				});
			}

			if (!isActive) {
				item.classList.add('is-active');
			} else {
				item.classList.remove('is-active');
			}
		});
	});

	/* ==========================================================================
	   4. TABS SYSTEM
	   ========================================================================== */
	const tabButtons = document.querySelectorAll('[data-tab-target]');
	tabButtons.forEach(btn => {
		btn.addEventListener('click', () => {
			const targetId = btn.dataset.tabTarget;
			const tabGroup = btn.closest('.tabs-wrapper');
			if (!tabGroup) return;

			tabGroup.querySelectorAll('[data-tab-target]').forEach(b => b.classList.remove('is-active'));
			tabGroup.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('is-active'));

			btn.classList.add('is-active');
			const targetPanel = tabGroup.querySelector(`#${targetId}`);
			if (targetPanel) targetPanel.classList.add('is-active');
		});
	});

	/* ==========================================================================
	   5. ENQUIRY MODAL HANDLER
	   ========================================================================== */
	const modalTriggers = document.querySelectorAll('[data-open-enquiry-modal]');
	const enquiryModal = document.querySelector('#enquiry-modal');
	const modalCloseBtns = document.querySelectorAll('.modal-close-btn, .modal-backdrop');

	const openModal = (safariTitle = '') => {
		if (!enquiryModal) return;

		if (safariTitle) {
			const safariField = enquiryModal.querySelector('input[name="safari_title"]');
			if (safariField) safariField.value = safariTitle;

			const titleDisplay = enquiryModal.querySelector('.enquiry-safari-title-display');
			if (titleDisplay) titleDisplay.textContent = safariTitle;
		}

		enquiryModal.classList.add('is-open');
		document.body.style.overflow = 'hidden';
	};

	const closeModal = () => {
		if (!enquiryModal) return;
		enquiryModal.classList.remove('is-open');
		document.body.style.overflow = '';
	};

	modalTriggers.forEach(trigger => {
		trigger.addEventListener('click', (e) => {
			e.preventDefault();
			const safariTitle = trigger.dataset.safariTitle || '';
			openModal(safariTitle);
		});
	});

	modalCloseBtns.forEach(btn => btn.addEventListener('click', closeModal));

	/* ==========================================================================
	   6. ENQUIRY FORM AJAX SUBMISSION
	   ========================================================================== */
	const enquiryForms = document.querySelectorAll('.bo-safari-enquiry-form');
	enquiryForms.forEach(form => {
		form.addEventListener('submit', async (e) => {
			e.preventDefault();

			const submitBtn = form.querySelector('button[type="submit"]');
			const feedbackContainer = form.querySelector('.form-feedback');
			const originalText = submitBtn ? submitBtn.textContent : '';

			if (submitBtn) {
				submitBtn.disabled = true;
				submitBtn.textContent = window.boSafariData?.strings?.loading || 'Sending...';
			}

			const formData = new FormData(form);
			formData.append('action', 'bo_safari_submit_enquiry');
			formData.append('nonce', window.boSafariData?.nonce || '');

			try {
				const response = await fetch(window.boSafariData?.ajaxUrl || '/wp-admin/admin-ajax.php', {
					method: 'POST',
					body: formData
				});

				const result = await response.json();

				if (result.success) {
					if (feedbackContainer) {
						feedbackContainer.className = 'form-feedback p-4 rounded bg-green-50 text-green-800 text-sm mt-4';
						feedbackContainer.textContent = result.data?.message || window.boSafariData?.strings?.success;
					}
					form.reset();
					// Dispatch event for analytics hooks
					document.dispatchEvent(new CustomEvent('bo_safari_enquiry_submitted', { detail: result.data }));
				} else {
					throw new Error(result.data?.message || 'Error processing enquiry');
				}
			} catch (err) {
				if (feedbackContainer) {
					feedbackContainer.className = 'form-feedback p-4 rounded bg-red-50 text-red-800 text-sm mt-4';
					feedbackContainer.textContent = err.message || window.boSafariData?.strings?.error;
				}
			} finally {
				if (submitBtn) {
					submitBtn.disabled = false;
					submitBtn.textContent = originalText;
				}
			}
		});
	});

	/* ==========================================================================
	   7. WHATSAPP CLICK DISPATCH
	   ========================================================================== */
	const whatsappLinks = document.querySelectorAll('a[href*="wa.me"], a[href*="whatsapp.com"]');
	whatsappLinks.forEach(link => {
		link.addEventListener('click', () => {
			document.dispatchEvent(new CustomEvent('bo_safari_whatsapp_clicked', {
				detail: {
					url: link.href,
					source: link.dataset.source || 'body'
				}
			}));
		});
	});
});
