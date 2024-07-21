/* jshint esversion: 6 */

/**
 * Front-end scripts.
 *
 * Scripts to run on the frontend.
 */

document.addEventListener('DOMContentLoaded', () => {
	localStorage.removeItem('showCount');
	localStorage.removeItem('lastShowTime');
	localStorage.removeItem('nextShowTime');

	const banner = document.getElementById('pwaforwp-add-to-home-click');
	const customAddToHome = Boolean(pwapc_prompt_control_params.custom_add_to_home_banner);
	const enableForDesktop = Boolean(pwapc_prompt_control_params.enable_banner_for_desktop);
	const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
	const enabled = String(pwapc_prompt_control_params.enable);
	const frequency = parseInt(pwapc_prompt_control_params.frequency, 10);
	const capping = parseInt(pwapc_prompt_control_params.capping, 10) * 60 * 1000;
	const interval = capping / frequency;

	let appInstalled = false;
	let checkInterval;
	let showCount = parseInt(localStorage.getItem('showCount')) || 0;
	let lastShowTime = parseInt(localStorage.getItem('lastShowTime')) || Date.now();
	let nextShowTime = parseInt(localStorage.getItem('nextShowTime')) || Date.now();

	/**
	 * Show banner.
	 */
	function showBanner() {
		banner.style.display = 'block';
		setTimeout(() => {
			banner.style.display = 'none';
		}, 10000); // Show banner for 10 seconds.

		showCount++;
		localStorage.setItem('showCount', showCount);
		nextShowTime += interval; // Schedule the next show time.
		localStorage.setItem('nextShowTime', nextShowTime);
	}

	/**
	 * Check banner conditions.
	 */
	function checkBannerConditions() {
		const now = Date.now();

		if (now - lastShowTime > capping) {
			showCount = 0;
			lastShowTime = now;
			nextShowTime = now; // Reset next show time to the current time
			localStorage.setItem('showCount', showCount);
			localStorage.setItem('lastShowTime', lastShowTime);
			localStorage.setItem('nextShowTime', nextShowTime);
		}

		console.log(appInstalled);
		if (showCount < frequency && now >= nextShowTime) {
			showBanner();
		}
	}

	// Service Worker registration
	if ("serviceWorker" in navigator) {

		let deferredPrompt;
		window.addEventListener('beforeinstallprompt', function(e) {
			e.preventDefault();
			deferredPrompt = e;

			if (enabled && !appInstalled && customAddToHome) {
				if (!enableForDesktop && !isMobile) {
					return;
				}

				checkInterval = setInterval(checkBannerConditions, 1000);
			}
		});

		window.addEventListener('appinstalled', function(evt) {
			appInstalled = true;
			console.log(appInstalled);
			banner.style.display = 'none';
			clearInterval(checkInterval);

		});
	}
});
