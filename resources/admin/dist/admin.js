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
setTimeout(function () {
  $('.preloader').hide()
}, 500)
let selectedRows = []

function getSelectedRows (grid) {
  return $('#' + grid).yiiGridView('getSelectedRows')
}

$(document).on('click', '.grid-delete-btn', function () {
  const grid = $(this).data('grid')
  const selected = getSelectedRows(grid)
  const url = $(this).data('url')
  krajeeDialog.confirm('Are You Sure You Want to Delete ' + selected.length + ' item(s)?', function (result) {
    if (result) {
      $.post(url, { 'ids': selected }).done(function (res) {
        $.pjax.reload({ container: '#' + grid + '-pjax' })
        krajeeDialog.alert(res + ' item(s) successfully deleted')
      })
    }
  })
})
$(document).on('change', '.kv-row-checkbox', function () {
  const grid = $(this).parents('.grid-view').prop('id')
  const selectedRows = getSelectedRows(grid)
  const deleteBtn = $('#' + grid + '-delete-btn')
  const counter = $('#' + grid + '-selected-counter')
  if (selectedRows.length > 0) {
    counter.html('<strong>' + selectedRows.length + '</strong> item(s)')
    deleteBtn.slideDown('fast')
  } else {
    deleteBtn.slideUp('fast')
  }
})



