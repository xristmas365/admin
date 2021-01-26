$(document).on("change", ".grid-switch-control", function () {
  const data = $(this).data("s")
  $.post("/admin/default/switch", { data: data })
})
$(document).on("pjax:end", function () {
  feather.replace()
})
