
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
	$(document).ready(function(){
		@yield('summernoteScript')
		 $('#summernote').summernote({
			 height: summernoteHeight,
			 placeholder: summernotePlaceHolder,
			 toolbar: [
				 ['style', ['bold', 'italic', 'underline', 'clear']],
				 ['fontsize', ['fontsize']],
				 ['para', ['ul', 'ol', 'paragraph']],
				  ['height', ['height']],
				 
			 ]
		 });
	});
</script>
