jQuery(document).ready(function($){ 

$('#hex_code_bg').ColorPicker({
	onChange: function (hsb, hex, rgb) {
		$('#hex_code_bg').attr('value', '#' + hex);
		$('h3.hndle').stop().animate({ backgroundColor: '#' + hex  }, 200);
	}

}).bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
});

$('#hex_code_tx').ColorPicker({
	onChange: function (hsb, hex, rgb) {
		$('#hex_code_tx').attr('value', '#' + hex);
		$('h3.hndle').stop().animate({ color: '#' + hex  }, 200);
	}

}).bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
});

$('#hex_code_sh').ColorPicker({
	onChange: function (hsb, hex, rgb) {
		$('#hex_code_sh').attr('value', '#' + hex);
		$('h3.hndle').stop().animate({ textShadow: '0 1px 0 #' + hex  }, 200);
	}

}).bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
});


});