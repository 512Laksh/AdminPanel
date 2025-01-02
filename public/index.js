function confirmdelete(){
    return confirm("Are you sure you want to delete");
}
$(document).ready(function() {

  $('.filter-select').select2({
    dropdownParent: $('#filterModal')
    })
    
})