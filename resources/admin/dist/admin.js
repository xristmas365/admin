$(document).on("change", ".grid-switch-control", function () {
  const data = $(this).data("s")
  $.post("/admin/default/switch", { data: data })
})
$(document).on("pjax:end", function () {
  feather.replace()
})
$(document).on('click', '.company-location-delete', function () {
  const url = $(this).data('url')
  krajeeDialog.confirm('Are You Sure You Want to Delete Authorized Store?', function (result) {
    if (result) { // ok button was pressed
      $.get(url).done(function () {
        $.pjax.reload({ container: '#company-locations' })
      })
    }
  })
})
$(document).on('click', '.company-location-save', function () {
  const url = $(this).data('url')
  const id = $(this).data('id')
  const value = $('#location-input-' + id).val()
  $.post(url, { text: value }).done(function () {
    krajeeDialog.alert('Authorized Store Saved')
  })
})
setTimeout(function(){
  $('.preloader').hide()
}, 500)



