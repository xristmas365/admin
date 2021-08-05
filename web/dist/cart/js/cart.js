$("#sidebar").mCustomScrollbar({
  theme: "minimal"
})
$('#dismiss, .overlay').on('click', function () {
  // hide sidebar
  $('#sidebar').removeClass('active')
  // hide overlay
  $('.overlay').removeClass('active')
})

function openSidebar () {
  // open sidebar
  $('#sidebar').addClass('active')
  // fade in the overlay
  $('.overlay').addClass('active')
  $('.collapse.in').toggleClass('in')
  $('a[aria-expanded=true]').attr('aria-expanded', 'false')
}

$('#sidebarCollapse').on('click', function () {
  openSidebar()
})

$(document).on('click', '.cart-add', function () {
  const url = $(this).data('url')
  const qty = $('#cart-qty').val()
  $.post(url, { qty: qty }).done(function (res) {
    openSidebar()
    $.pjax.reload({ container: '#card-sidebar' })
  })
})
$(document).on('click', '.cart-delete', function () {
  const url = $(this).data('url')
  $.get(url).done(function (res) {
    if (res) {
      $.pjax.reload({ container: '#card-sidebar' })
    }
  })
})


