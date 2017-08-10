function edit_user_info(){
	var inputs = document.getElementsByTagName("input");
	var img = document.getElementById("new_img");
	for (var i = 0; i < inputs.length; i++) {
		inputs[i].disabled = "";
		inputs[i].hidden = "";
	}
	img.hidden = "";
}
