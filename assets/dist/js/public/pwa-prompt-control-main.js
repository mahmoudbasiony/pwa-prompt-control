"use strict";

/* jshint esversion: 6 */

/**
 * Front-end scripts.
 *
 * Scripts to run on the frontend.
 */

window.addEventListener('load', () => {
  const banner = document.getElementById('pwaforwp-add-to-home-click');
  const customAddToHome = Boolean(pwapc_prompt_control_params.custom_add_to_home_banner);
  const enableForDesktop = Boolean(pwapc_prompt_control_params.enable_banner_for_desktop);
  const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
  const enabled = String(pwapc_prompt_control_params.enable);
  const frequency = parseInt(pwapc_prompt_control_params.frequency, 10);
  const capping = parseInt(pwapc_prompt_control_params.capping, 10) * 60 * 1000;
  const interval = capping / frequency;
  const nowInitial = Date.now();
  let appInstalled = false;
  let checkInterval;

  /**
   * Show banner.
   */
  function showBanner() {
    banner.style.setProperty('display', 'block');
    setTimeout(() => {
      banner.style.setProperty('display', 'none');
    }, 10000); // Show banner for 10 seconds.
  }

  /**
   * Check banner conditions.
   */
  function checkBannerConditions() {
    let showCount = parseInt(localStorage.getItem('pwapcShowCount')) || 0;
    let nextShowTimeValue = localStorage.getItem('pwapcNextShowTime');
    let nextShowTime = nextShowTimeValue ? parseInt(nextShowTimeValue) : parseInt(nowInitial + interval);
    let now = Date.now();
    if (showCount === 0 || now >= nextShowTime) {
      console.log('Show banner');

      // Show banner.
      showBanner();

      // Update show count.
      showCount++;
      localStorage.setItem('pwapcShowCount', showCount);
      localStorage.setItem('pwapcNextShowTime', parseInt(now + interval));
      localStorage.setItem('pwapcLastShowTime', now);
    }
  }

  // Service Worker registration
  if ("serviceWorker" in navigator) {
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', function (e) {
      e.preventDefault();
      deferredPrompt = e;
      if (deferredPrompt != null || deferredPrompt != undefined) {
        if (enabled && !appInstalled && customAddToHome) {
          if (!enableForDesktop && !isMobile) {
            return;
          }
          banner.style.setProperty('display', 'none');

          // // Call the function immediately
          checkBannerConditions();

          // Check banner conditions every second.
          checkInterval = setInterval(checkBannerConditions, 1000);
        }
      }
    });
    window.addEventListener('appinstalled', function (evt) {
      appInstalled = true;
      console.log(appInstalled);
      banner.style.setProperty('display', 'none');
      clearInterval(checkInterval);
    });
  }
});