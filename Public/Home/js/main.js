var J_activeList = $('#activeList');
var totalheight = 0; //定义一个总的高度变量
var J_curPage = J_activeList.data('curpage'); //当面页数
var J_hasPage = J_activeList.data('haspage'); //判断是否存在分页
//请求数据
function autoData() {
	J_curPage=J_curPage+1
	$.ajax({
			url: '/Activity/api/p/'+J_curPage,
			type: 'get',
			dataType: 'json'
		})
		.done(function(data) {
			var J_html = [];
			for (var i in data.list) {
				J_html.push("<li><div class='act-listl'><div class='act-icon "+data.list[i].act_icon+" fl'></div><div class='act-tit'><em>");
				J_html.push(data.list[i].year+"<br>"+data.list[i].month); //时间
				J_html.push("</em></div></div><div class='act-listr fr'>");
				J_html.push("<img src="+data.list[i].cover_url+" />"); //标题
				J_html.push("<div class='act-listrtext'><h5>");
				J_html.push(data.list[i].title); //标题
				J_html.push("</h5><p class='act-listCon'>");
				J_html.push(data.list[i].description); //简介
				J_html.push("</p><a href=Activity/detail?id="+data.list[i].id+">阅读全文</a>");
				J_html.push("</div></div></li>");
			}
			if (!data.haspage) { //判断是否有下一页
				J_hasPage = false;
			};
			$('#activeList').append(J_html.join(''))
		})
		.fail(function() {
			console.log("error");
		})
		.always(function(data) { //ajax处理完成
			if (data.hasPage) {
				J_hasPage = true;
			}
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
			J_hasPage = !J_hasPage; //等待请求完再进入下一次请求
			setTimeout(autoData, 500)
		}
	}

});