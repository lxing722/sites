
var task_get_msg = window.setInterval("get_msg(0)", 5000);

window.onload = function(){
	if(document.getElementById("receiver").innerText == 0){
		document.getElementById("msg").value = "please choose someone to chat to.";
		document.getElementById("msg").disabled = true;
		document.getElementById("btn_send_msg").disabled = true;
	}
}

// 获取当前正在聊天的用户的id
function get_receiver() {
	var receiver = document.getElementById("receiver").innerText;
	return receiver;
}

// 发送消息
function send_msg() {
	if($("#msg").val() != "") {
		var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
		xhr.open("POST", "add_msg.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("receiver=" + get_receiver() + "&content=" + $("#msg").val());
		xhr.onreadystatechange = function() {
			if(xhr.readyState == 4 && xhr.status == 200) {
				var obj = eval("(" + xhr.responseText + ")");
				if(obj.status == 1) {
					alert("The server is busy now,please try again later.");
				} else {
					deal_msg(obj);
				}
				$("#msg").val("");
			}
		};
	}
}

// 获取消息，type为0时为获取所有未读消息，为1时为获取与某人的所有聊天消息，并将获取到的消息刷新到聊天界面
function get_msg(type) {
	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	xhr.open("POST", "get_msg.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var str = (type == 1 ? "receiver=" + get_receiver() : "");
	xhr.send(str);
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			var obj = eval("(" + xhr.responseText + ")");
			if(obj.status == 1) {
				alert("The server is busy now,please try again later.");
			} else {
				deal_msg(obj);
			}
		}
	}
	
}

// 将接收到的消息刷新到聊天界面，根据情况选择刷新气泡提示或是直接添加到对话框
function deal_msg(obj) {
	var chat_box = document.getElementById("chat_box");
	// 遍历消息数组
	for(var i = 0; i < obj.msgs.length; i++) {
		// 如果是当前对话人的消息，直接添加在对话框中
		if ( (obj.msgs[i].sender == get_receiver()) || (obj.msgs[i].receiver == get_receiver()) ) {
			// 检查是否需要添加时间标签
			check_time(obj.msgs[i].sendtime);
			// 创建并添加新消息的div
			var div = document.createElement("div");
			div.className = obj.msgs[i].receiver == get_receiver() ? "sender_words" : "receiver_words";
			var img = document.createElement("img");
			img.src = document.getElementById(obj.msgs[i].receiver == get_receiver() ? "sender_headimg" : "receiver_headimg").innerText;
			var div_content = document.createElement("div");
			div_content.innerText = obj.msgs[i].content;
			div.appendChild(img);
			div.appendChild(div_content);
			chat_box.appendChild(div);
			// 滚动聊天框至底部
			chat_box.scrollTop = chat_box.scrollHeight;
			// 刷新左侧联系人列表中联系人昵称下的消息
			refresh_item(obj.msgs[i].receiver == get_receiver() ? obj.msgs[i].receiver : obj.msgs[i].sender, obj.msgs[i].content,0);
		} else {
			// 否则刷新左侧联系人列表中联系人昵称下的消息，并增加气泡提示，将消息置顶
			refresh_item(obj.msgs[i].receiver == get_receiver() ? obj.msgs[i].receiver : obj.msgs[i].sender, obj.msgs[i].content,1);
		}

	}
}

// 添加一个时间标签
function append_time(timeString) {
	var div = document.createElement("div");
	div.className = "time";
	var span = document.createElement("span");
	span.innerText = timeString;
	div.appendChild(span);
	var chat_box = document.getElementById("chat_box");
	chat_box.appendChild(div);
}

// 检查时间，看是否需要在消息框中添加时间标签，如需要则添加
function check_time(time,type) {
	
	var sendtime = new Date(time);
	var lasttime = new Date(document.getElementById("last_time").innerText);
	// 此条消息时间与上次显示时间的间隔
	var btwn = (sendtime.getTime() - lasttime.getTime()) / 1000;
	btwn = Math.abs(btwn);
	// 5分钟之内，不显示
	if(btwn < 300) {}
	// 同一天，只显示时和分
	else if(btwn < 86400 && (sendtime.getDate() == lasttime.getDate())) {
		append_time(sendtime.toString().substr(16, 5));
		document.getElementById("last_time").innerText = new Date();
	}
	// 一周内，显示周几和时分
	else if(btwn < 518400) {
		append_time(sendtime.toString().substr(0, 4) + sendtime.toString().substr(16, 5));
		document.getElementById("last_time").innerText = new Date();
	}
	// 本月显示月日和时分
	else if((lasttime.getYear() == sendtime.getYear()) && (lasttime.getMonth() == sendtime.getMonth())) {
		append_time(sendtime.toString().substr(4, 4) + sendtime.toString().substr(16, 5));
		document.getElementById("last_time").innerText = new Date();
	}
	// 显示全部时间
	else {
		append_time(sendtime.toLocaleFormat().substr(0, 15));
		document.getElementById("last_time").innerText = new Date();
	}

}

function change_chatter(chatter) {
	// 将当前活跃的聊天人设置为点击的聊天人，
	var last_chatter = document.getElementById("alive_chatter");
	if(last_chatter != null) {
		last_chatter.id = "";
	}
	// 得到新的聊天人的id
	chatter.id = "alive_chatter";
	var c_id = chatter.getAttribute("chatterid");
	// 得到新的聊天人昵称，并设置聊天框顶部昵称
	var c_nickname = chatter.getElementsByTagName("h3");
	c_nickname = c_nickname[0].innerText;
	document.getElementById("receiver_nickname").innerHTML = "<span>" + c_nickname + "</span>";
	// 隐藏消息提示气泡
	var spans = chatter.getElementsByTagName("span");
	spans[0].innerHTML = 0;
	spans[0].className = "alert";
	// 更改隐藏元素的属性值，包括id信息和头像路径信息
	var imgs = chatter.getElementsByTagName("img");
	document.getElementById("receiver").innerText = c_id;
	document.getElementById("receiver_headimg").innerText = imgs[0].src;
	// 刷新聊天框
	document.getElementById("chat_box").innerHTML = "";
	get_msg(1);
	// 启用输入框和发送按钮（当进入聊天界面时未选择聊天人，则输入框和发送按钮是禁用状态）
	document.getElementById("msg").disabled = false;
	document.getElementById("btn_send_msg").disabled = false;
	// 清空输入框
	document.getElementById("msg").value = "";
}

// 将最新的消息刷新到联系人列表中的联系人昵称下
function refresh_item(cid, content, type) {
	var contacts = document.getElementById("contacts");
	var items = document.getElementsByClassName("item");
	var item_index;
	for(var i = 0; i < items.length; i++) {
		if(items[i].getAttribute("chatterid") == cid) {
			item_index = i;
			if(type == 1) {
				// 显示气泡
				var spans = items[i].getElementsByTagName("span");
				spans[0].innerText = parseInt(spans[0].innerHTML) + 1;
				spans[0].className = "alert_show";
			}
			var ps = items[i].getElementsByTagName("p");
			ps[0].innerText = content;
		}
	}
	
	// 将该item置顶(在最前面插入一个，并移除掉原来那个)
	if(type == 1){
		var item_html = items[item_index].outerHTML;
		contacts.removeChild(contacts.childNodes[item_index]);
		contacts.innerHTML = item_html + contacts.innerHTML;
		contacts.scrollTop = 0;
	}
}