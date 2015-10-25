var J_activeList = $('#activeList');
var totalheight = 0; //定义一个总的高度变量
var J_curPage = J_activeList.data('curpage'); //当面页数
var J_hasPage = J_activeList.data('haspage'); //判断是否存在分页
//请求数据
function autoData() {
	$.ajax({
		url: '/ajax.php',
		type: 'post',
		dataType: 'json',
		data: {
			page: J_curPage+1//下一页
		}
	})
	.done(function(data) {
		var J_html = [];
		J_html.push("<li><div class='act-listl'><div class='act-icon act-icon4 fl'></div><div class='act-tit'><em>");
		J_html.push("2014年<br>12月6日"); //时间
		J_html.push("</em></div></div><div class='act-listr fr'>");
		J_html.push("<img src='images/img1.jpg'>"); //标题
		J_html.push("<div class='act-listrtext'><h5>");
		J_html.push(data.dataList); //标题
		J_html.push("</h5><p class='act-listCon'>");
		J_html.push("活动地址：深圳D³in 铟立方·未来实验室 深圳市福田区福田保税区花样年福年广场 B4 栋 629，限额人数：50人。未来实验室 深圳市福田区福田保税区花样年福年广场 B4 栋 629。"); //简介
		J_html.push("</p><a href='detial.php'>阅读全文</a>");
		J_html.push("</div></div></li>");
		if (!data.hasPage) { //判断是否有下一页
			J_hasPage = false;
		};
		console.log('suc');
		$('#activeList').append(J_html.join(''))
	})
	.fail(function() {
		console.log("error");
	})
	.always(function(data) {//ajax处理完成
		if(data.hasPage){
			J_hasPage=true;
		}
		console.log("complete");
	});
};
$(window).scroll(function() {
	J_docHeight = $(document).height();
	J_scrollTop = $(document).scrollTop();
	J_winHeight = $(window).height();
	/*console.log("滚动条到顶部的垂直高度: "+$(document).scrollTop()); 
	console.log("页面的文档高度 ："+$(document).height());
	console.log('浏览器的高度：'+$(window).height());*/
	if (J_docHeight < (J_scrollTop + J_winHeight + 340)) {
		//判断是否存在分页
		if (J_hasPage) {
			J_hasPage=!J_hasPage;//等待请求完再进入下一次请求
			setTimeout(autoData,500)
		}

	}

});