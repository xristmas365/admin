$(document).on("change", ".grid-switch-control", function () {
  const data = $(this).data("s")
  $.post("/admin/default/switch", { data: data })
})
$(document).on("pjax:end", function () {
  feather.replace()
})
let selectedRows = []

function getSelectedRows (grid) {
  return $('#' + grid).yiiGridView('getSelectedRows')
}

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
$(document).on('click', 'a.grid-delete-btn', function (e) {
  e.preventDefault()
  const url = $(this).prop('href')
  const container = $($(this).parents('[data-pjax-container]')[0]).prop('id')
  krajeeDialog.confirm('Are You Sure You Want to Delete item?', function (result) {
    if (result) {
      $.get(url).done(function () {
        $.pjax.reload({ container: "#" + container })
      })
    }
  })
})
$('.grid-file-input').on('fileuploaded', function (event, previewId, index, fileId) {
  $(this).fileinput('clear')
  const id = previewId.response
  const modal = $(this).data('modal')
  $('#' + modal).load('/file/default/show?id=' + id)
})
$(document).on('click', '#preview-form-import-btn', function (e) {
  const data = $('#preview-form-import-form').serialize()
  $.post('/file/default/import', data).done(function (response) {
    console.log(response)
  })
})



