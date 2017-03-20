//FUNGSI UNTUK HAPUS
 $(document).ready(function() {
	$('#confirmDelete').on('show.bs.modal', function (e) {
	$message = $(e.relatedTarget).attr('data-message');
	$(this).find('.modal-body p').text($message);
	$title = $(e.relatedTarget).attr('data-title');
	$(this).find('.modal-title').text($title);

	// Pass form reference to modal for submission on yes/ok
	var form = $(e.relatedTarget).closest('form');
	$(this).find('.modal-footer #confirm').data('form', form);
	});

	<!-- Form confirm (yes/ok) handler, submits form -->
	$('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
		$(this).data('form').submit();
	});
});
//SLIMSCROLL FOR CHAT WIDGET
  $('#info-kampus').slimScroll({
    height: '200px'
  });
//Date Picker
$('#barang_edit').datepicker({
    format: 'dd/mm/yyyy',
	language: "id",
	autoclose: true
});
$('#barang_tmbh').datepicker({
    format: 'dd/mm/yyyy',
	language: "id",
	autoclose: true
});
$('#tanggalan').datepicker({
    format: 'dd/mm/yyyy',
	language: "id",
	autoclose: true
});