
function change_frame(p){
	var iframe = document.getElementById("goods");
	iframe.src = "goods_list.html.php?type="+p.innerHTML;
}
