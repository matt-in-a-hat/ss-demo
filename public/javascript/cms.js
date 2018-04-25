jQuery(function ($) {

  if ($('#floating-info-window').length) {
    // We've already got one ("hehehe I told him we've already got one")
    return
  }

  var infoWindow = $('<div id="floating-info-window">')

  infoWindow.html(`
    <p>(This box is not part of SilverStripe)</p>
    <p>Typical sidebar with sections</p>
    <p>Page hierarchy determines URLs. Typical create & move pages.</p>
    <p>Each page has a "page type" (i.e. php Class) which allows us to have some with extra functionality.</p>
    <p>The base installation doesn't have many base types built in, but we usually use a CWP module that includes a "News page" among others.</p>
    <p>All pages have some base content, but can be extended to add whatever fields or components are needed.</p>
    <p>It's possible to force some structure by making some pages only allowed under a certain "holder" page (e.g. News).
    <br>
<br>- CMS (front end/back end), pages & types & templates (draft, history, extending), built in types? (restrictions e.g. holders), files & images & resampling
<br>- Users & roles, site config, QueuedJobs (e.g. importers)
  `)

  $('body').append(infoWindow)
  if (window.localStorage.getItem('infoWindowTop')) {
    infoWindow.css('top', window.localStorage.getItem('infoWindowTop'))
  }
  if (window.localStorage.getItem('infoWindowLeft')) {
    infoWindow.css('left', window.localStorage.getItem('infoWindowLeft'))
  }

  var trackingOffset = null
  function moveWindowToMouse (e) {
    infoWindow.css('top', e.pageY - trackingOffset.y)
    infoWindow.css('left', e.pageX - trackingOffset.x)
  }
  function stopMoveListener () {
    $('body').off('mousemove', moveWindowToMouse)
    $('body').off('click', stopMoveListener)
    trackingOffset = null
    window.localStorage.setItem('infoWindowTop', infoWindow.css('top'))
    window.localStorage.setItem('infoWindowLeft', infoWindow.css('left'))
  }

  infoWindow.on('click', function (e) {
    e.preventDefault()
    if (trackingOffset) {
      stopMoveListener()
    } else {
      trackingOffset = { x: e.offsetX + infoWindow.border().left, y: e.offsetY + infoWindow.border().top }
      $('body').on('mousemove', moveWindowToMouse)
      $('body').on('click', stopMoveListener)
    }
    return false
  })

  if (window.localStorage.getItem('infoWindowScrollPos')) {
    infoWindow.scrollTop(window.localStorage.getItem('infoWindowScrollPos'))
  }

  infoWindow.on('mouseleave', function (e) {
    window.localStorage.setItem('infoWindowScrollPos', infoWindow.scrollTop())
  })
});
