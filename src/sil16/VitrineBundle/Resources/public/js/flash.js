	window.addEventListener("load", function() {
		debugger;
		// Suppression de la flash message.
		setTimeout(fade_out, 4000);
		function fade_out() {
		  $("#flash").fadeOut(400);
		}

		// Lors de la selection d'un élément dans un select, on soumet le formulaire.
		var selects = document.getElementsByClassName("select-bar");
		for(i=0; i < selects.length; i++){
			document.getElementsByClassName("select-bar")[i].addEventListener('change', function(){
				this.form.submit();
			});
		}
	});
