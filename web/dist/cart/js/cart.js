$("#sidebar").mCustomScrollbar({
  theme: "minimal"
})

function openSidebar () {
  $('#sidebar').addClass('active')
  $('.overlay').addClass('active')
  $('.collapse.in').toggleClass('in')
  $('a[aria-expanded=true]').attr('aria-expanded', 'false')
}

function closeSidebar () {
  $('#sidebar').removeClass('active')
  $('.overlay').removeClass('active')
}

$(document).on('click', '#sidebarCollapse', function () {
  openSidebar()
})
$(document).on('click', '#dismiss, .overlay, .continue-shopping', function () {
  closeSidebar()
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
$(document).on('click', '.checkout-add', function () {
  const url = $(this).data('url')
  const id = $(this).data('id')
  $.post(url).done(function (res) {
    $.pjax.reload({ container: '#checkout-pjax' })
  })
})
$(document).on('click', '.checkout-remove', function () {
  const url = $(this).data('url')
  const id = $(this).data('id')
  $.post(url).done(function (res) {
    $.pjax.reload({ container: '#checkout-pjax' })
  })
})
$(document).on('click', '#checkout-coupon-apply', function () {
  const url = $(this).data('url')
  const coupon = $('#checkout-coupon-input')
  const couponVal = coupon.val()
  $.post(url, { coupon: couponVal }).done(function (res) {
    if (res) {
      krajeeDialog.alert("Coupon " + couponVal + " Applied")
    } else {
      krajeeDialog.alert("Coupon " + couponVal + " Not Found")
    }
    $.pjax.reload({ container: '#checkout-pjax' })
  })
})
$(document).on('click', '#checkout-coupon-delete', function () {
  const url = $(this).data('url')
  $.post(url).done(function (res) {
    $.pjax.reload({ container: '#checkout-pjax' })
  })
})


