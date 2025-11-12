// Small loader helpers used by calendar_admin_details_calendar_content.js
// Not included automatically; functions are duplicated here for clarity but can be imported later.

(function (global) {
  // Private state
  let _loaderShownAt = 0;
  let _loaderHideTimer = null;
  const MIN_SHOW_MS = 3000; // 3 seconds minimum

  function _setLoaderDisplay(display) {
    try {
      if (window.$) {
        window.$("#loader").css("display", display);
      } else {
        const el = document.getElementById("loader");
        if (el) el.style.display = display;
      }
    } catch (e) {
      // ignore
    }
  }

  function showGlobalLoader() {
    // Cancel any pending hide
    if (_loaderHideTimer) {
      clearTimeout(_loaderHideTimer);
      _loaderHideTimer = null;
    }
    _setLoaderDisplay("flex");
    _loaderShownAt = Date.now();
  }

  function hideGlobalLoader() {
    const elapsed = _loaderShownAt ? Date.now() - _loaderShownAt : MIN_SHOW_MS;
    function doHide() {
      _setLoaderDisplay("none");
      _loaderShownAt = 0;
      _loaderHideTimer = null;
    }
    if (elapsed >= MIN_SHOW_MS) {
      doHide();
    } else {
      _loaderHideTimer = setTimeout(doHide, MIN_SHOW_MS - elapsed);
    }
  }

  global.showGlobalLoader = showGlobalLoader;
  global.hideGlobalLoader = hideGlobalLoader;
})(window);
