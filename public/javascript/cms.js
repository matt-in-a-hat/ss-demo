jQuery(function ($) {

  if ($('#floating-info-window').length) {
    // We've already got one ("hehehe I told him we've already got one")
    return
  }

  var infoWindow = $('<div id="floating-info-window">')

  infoWindow.html(`
    <p>(This box is not part of SilverStripe)</p>
    <p>Typical sidebar with sections</p>
    <p>Page hierarchy determines <strong>URLs</strong>. Typical create & move pages.</p>
    <p>Each page has a "<strong>page type</strong>" (i.e. php Class) which allows us to have some with extra functionality.</p>
    <p>The base installation doesn't have many base types built in, but we usually use a CWP module that includes a "News page" among others.</p>
    <p>All pages have some base content, but can be extended to <strong>add fields</strong> or components as needed.</p>
    <p>It's possible to <strong>force some structure</strong> by making some pages only allowed under a certain "holder" page (e.g. News).</p>
    <p>All pages are <strong>Versioned</strong>, meaning you can look back on all previous changes, and pages are never deleted.</p>
    <h3>Bots (page types)</h3>
    <p>There's kind of 2 concepts, the <strong>CMS interface</strong> and the <strong>public interface</strong>. CMS features are defined in code, such as the fields a class has. Front-end is mostly done using templates.</p>
    <p><strong>Image handling</strong> is built into SS (see Designer page).</p>
    <br>
    <p><strong>Users</strong>, pretty standard. Usually set up and send reset link.</p>
    <p>Has pretty good permission groups/roles facility.</p>
    <p><strong>Site config</strong> allows easily adding site-wide settings.</p>
    <p><strong>QueuedJobs</strongs> we use for periodical tasks like importing data. I haven't added any here but <a target="_blank" href="http://journeys.nzta.govt.nz/admin/queuedjobs">Journeys has more than enough</a>.</p>
    <br>
    <h3>DataObjects</h3>
    <p>Base class for items saved in database (Pages are DataObjects with extra fields, Versioning, and a rich CMS section).</p>
    <p>Good for data that's transient or volumous.</p>
    <p><strong>ModelAdmin</strong> is a built in CMS view for any type of DataObject e.g. teams.</p>
    <p>Usual model <strong>relations</srtong> are supported, and provides some nice components such as the GridField relation editor (e.g. for many to many).</p>
    <br>
    <p><a href="/other-notes/" target="_blank">Remaining remarks</a></p>
    <br>
    <br>
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
    if (e.target.tagName !== 'A') {
      e.preventDefault()
      if (trackingOffset) {
        stopMoveListener()
      } else {
        trackingOffset = { x: e.pageX - infoWindow.offset().left, y: e.pageY - infoWindow.offset().top }
        $('body').on('mousemove', moveWindowToMouse)
        $('body').on('click', stopMoveListener)
      }
      return false
    }
  })

  if (window.localStorage.getItem('infoWindowScrollPos')) {
    infoWindow.scrollTop(window.localStorage.getItem('infoWindowScrollPos'))
  }

  infoWindow.on('mouseleave', function (e) {
    window.localStorage.setItem('infoWindowScrollPos', infoWindow.scrollTop())
  })
});
