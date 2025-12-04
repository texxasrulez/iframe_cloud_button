if (window.rcmail) {
  rcmail.addEventListener('init', function() {
    rcmail.register_command('plugin.iframe_cloud_button', function() {
      var url = rcmail.env.iframe_cloud_button_url;
      if (!url) {
        return;
      }

      // Try to find the main content container
      var mainscreen = document.getElementById('mainscreen')
        || document.querySelector('#layout-content, #layout-content .contentframe, #layout-content .iframewrapper')
        || document.body;

      if (!mainscreen) {
        return;
      }

      // Clear previous iframe wrapper if any
      var oldWrapper = document.getElementById('iframe-cloud-wrapper');
      if (oldWrapper && oldWrapper.parentNode) {
        oldWrapper.parentNode.removeChild(oldWrapper);
      }

      // Optional: clear mainscreen content
      while (mainscreen.firstChild) {
        mainscreen.removeChild(mainscreen.firstChild);
      }

      var wrapper = document.createElement('div');
      wrapper.id = 'iframe-cloud-wrapper';
      wrapper.style.position = 'relative';
      wrapper.style.width = '100%';
      wrapper.style.height = '100%';

      var iframe = document.createElement('iframe');
      iframe.src = url;
      iframe.style.width = '100%';
      iframe.style.height = '100%';
      iframe.style.border = '0';
      iframe.setAttribute('frameborder', '0');
      iframe.setAttribute('allowfullscreen', 'allowfullscreen');

      wrapper.appendChild(iframe);
      mainscreen.appendChild(wrapper);
    }, true);
  });
}
