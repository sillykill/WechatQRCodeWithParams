// 系统配置js文件

//加载页面 
var loading = layer.load();
$(document).ready(function() {
	// alert("ready() 加载完成！！");
	layer.close(loading);
	$('#app').css('display', 'block')
})
// 设置 标签
function setTabs(e) {
	// vm.tabs=JSON.stringify(e)
	// console.log(typeof(vm.tabs))
	// console.log(typeof(e))
	vm.tabs = e
	// console.log(vm.tabs)
	// console.log(e)
	vm.$set(vm.tabs, 1, e)
}

var navs = setNavs()
// console.log(navs)

// index vue 实例
var vm = new Vue({
	el: '#app',
	data: {
		isCollapse:true,
		welcome: true,
		navs: setNavs(),
		showNav: true,
		tabs: [],
		id: '0',
		i: 0,
		isActive: 'tab-item-active',
		loadOk: false,
		item: '',
		activeIndex:'0',
		footerText:'精为科技'
	},
	methods: {
		isShowNav: function(e) { //隐藏显示左边导航栏
			if (this.showNav) {
				$(".left-side").animate({
					left: '-220px'
				}, "slow");
				$(".right-box").animate({
					left: '0'
				}, "slow");
				this.showNav = !this.showNav
			} else {
				$(".left-side").animate({
					left: '0px'
				}, "slow");
				$(".right-box").animate({
					left: '220px'
				}, "slow");
				this.showNav = !this.showNav
			}
		},
		welTab: function() { //控制台 欢迎页面 tab事件
			this.welcome = true
			this.id = '0'
			this.activeIndex='0'
			$('.tab-item-ul').css("left", 0)
		},
		openTabs: function(e) { //打开页面 加载显示tabs
			// var data=JSON.stringify(e)
			// console.log(data)
			this.welcome = false
			var tabs = this.tabs
			if (this.tabs.length == 0) {
				this.tabs.push({
					id: e.id,
					data: e,
				})
				this.id = e.id
				this.item = e
				calWidth()
				// calTabWid(e)
			} else {
				// console.log('id' + e.id)
				var back = checkTab(e.id)
				// console.log('返回', back)
				if (back == 1) { //可以插入
					this.tabs.push({
						id: e.id,
						data: e,
					})
					this.id = e.id
					this.item = e
					calWidth()
				} else { //已打开
					this.id = e.id;
					this.item = e
					calTabWid(e.id)
				}
			}
			// console.log('tabs' + JSON.stringify(this.tabs))
		},
		tabActive: function(e) { //点击tab显示页面 并改变颜色 调整距离
			this.welcome = false
			this.id = e.id;
			this.item = e.data
			this.activeIndex=e.id
			calTabWid(e.id)
			// console.log(e)
			console.log('------------------------------')
		},
		tabClose: function(e) { //tabs关闭事件
			closeTabThis(e.id)
		},
		tabsRight: function() { //tabs左移
			var left = $('.tab-item-ul').position().left;
			var tbox = $('.tab-item-box').width() //外边盒子距离长度
			var ul = $('.tab-item-ul').width()
			// console.log('左边', left)
			// console.log('差距', tbox - ul)
			// console.log("tabs box 宽度", tbox)
			// console.log('ul 宽度', ul)
			if (ul > tbox) {
				if (left < tbox - ul) {
					layer.tips('到最右边了', '.tab-right', {
						tips: 1
					});
				} else {
					$('.tab-item-ul').css("left", -(ul - tbox))
				}
			} else {
				layer.tips('到最右边了', '.tab-right', {
					tips: 1
				});
			}
		},
		tabsLeft: function() { //tabs右移
			var left = $('.tab-item-ul').position().left;
			// console.log('左边', left)
			if (left >= 0) {
				layer.tips('到最左边了', '.tab-left', {
					tips: 1
				});
			} else if (left < -100) {
				$('.tab-item-ul').css("left", left + 100)
			} else {
				$('.tab-item-ul').css("left", 0)
			}
		},
		notice: function() { //公告
			// layer.msg('公告')
			layer.open({
				type: 1,
				title: '系统公告',
				content: $('#notice'),
				area: ['300px', 'auto'],
				btn: '知道啦',
				btnAlign: 'c' //按钮居中
			});
		},
		// 关闭tab 
		tabsCloseItem: function(e) {
			// this.$message('click on item ' + e);
			if (e == 'a') {
				// layer.msg('关闭当前')
				closeTabThis(this.id)

			} else if (e == 'b') {
				// layer.msg('关闭其他')
				closeTabOther()
			} else {
				// layer.msg('关闭所有')
				closeTabAll()
			}
		}
	},
	watch: {
		getTabsBoxWidth: function() {
			// 判断边界
			var tbox = $('.tab-item-box')
			// console.log(tbox.width())
		}
	}
})

function checkTab(id) { //检查tabs是否已经打开
	var i = 0;
	var back = 0
	var tabs = vm.tabs
	// console.log('长度', tabs.length)
	for (i; i < tabs.length; i++) {
		// console.log(tabs[i].id)
		if (tabs[i].id == id) {
			back = 0
			break //找到id 中断循环
		} else {
			back = 1
		}
	}
	return back
	// console.log('i的值', i)
}

//计算 tab距离
function calTabWid(id) {
	// console.log(id)
	var tbox = $('.tab-item-box').width() //外边盒子距离长度
	var ul = $('.tab-item-ul').width() //tabs外边盒子长度
	var left = $('.tab-item-ul').position().left; //ul 左边偏移距离
	var titem = $('#' + id)
	// console.log(titem.length)
	if (titem.length > 0) {
		var iLeft = titem.position().left //tab距离父盒子左边距离
		var titemW = $('#' + id).width()
		if (ul > tbox && left <= 0) {
			var disAreaL = -left //可视区域左边
			var disAreaR = -left + tbox //可视区域右边
			var iRight = titemW + iLeft
			// console.log('//可视区域左边'+disAreaL)
			// console.log('//可视区域右边'+disAreaR)
			// console.log('//iRight 位置'+iRight)
			if (iLeft >= disAreaL && iRight <= disAreaR) {
				// console.log('不需要移动')
			} else {
				// console.log('需要移动')
				if (iLeft < disAreaL) {
					// console.log('往右移动')
					$('.tab-item-ul').css("left", left + (disAreaL - iLeft) + 50)
				} else if (iRight > disAreaR) {
					// console.log('往左移动')
					$('.tab-item-ul').css("left", left + (disAreaR - iRight) - 20)
				}
			}
		}
	}

	// console.log("tabs box 宽度", tbox)
	// console.log('差距', tbox - ul)
	// console.log('ul 宽度', ul)
	// console.log('left 偏移', left)
	// console.log('iLeft 的位置', iLeft)
	// console.log('tab自身长度', titemW)
	//当ul 大于tbox时 left不为正

}


// opentab 打开时计算左移距离
function calWidth() {
	var tbox = $('.tab-item-box').width() //外边盒子距离长度
	var titem = $('.tab-item')
	var len = vm.tabs.length + 2 //有几个tabs
	var countLen = titem.width() * len
	var ul = $('.tab-item-ul').width() + 100
	// console.log("tabs box 宽度", tbox)
	// console.log("tabs item 宽度", titem.width())
	// console.log('总 item 宽度', countLen)
	// console.log('差距', tbox - ul)
	// console.log('ul 宽度', ul)
	if (tbox - ul < 0) {
		var len = tbox - ul
		$('.tab-item-ul').css("left", len - 20)
	}
}

// 关闭当前tab标签  --> 下拉点击事件、tab X按键关闭事件
function closeTabThis(id) {
	var tabs = vm.tabs
	var i = 0;
	var len = vm.tabs.length - 2
	if(id==0){
		layer.msg('这个不能关闭的哦') 
	return}
	for (i; i < tabs.length; i++) { //找到id在tabs数组中的位置 下标
		// console.log(tabs[i].id)
		if (tabs[i].id == id) {
			break;
		}
	}
	// console.log(i)
	vm.tabs.splice(i, 1) //从tabs中移除

	if (tabs.length == 0) { //如果tabs没有数据，将控制台设置变色
		vm.welcome = true
		vm.id='0'
	} else {
		if (tabs[len].id != vm.id) { //判断tabs数组中最后一组数据的id是否为当前的id，若不是则设置
			vm.id = tabs[len].id
			vm.item=tabs[len].data
		}
	}
	//调整位置
	closeWidth()
}
//关闭其他标签页
function closeTabOther() { //删除tabs所有数组，重新push
	if (vm.tabs.length == 0) {
		return
	} else {
		if (vm.id == 0) {
			vm.tabs = []
		} else {
			var item = vm.item
			vm.tabs = []
			vm.tabs.push({
				id: item.id,
				data: item,
			})
			$('.tab-item-ul').css("left", 0)
		}
	}
	// console.log(item)

}
//关闭所有标签页
function closeTabAll() {
	vm.tabs = []
	vm.welcome = true
	vm.id = '0'
	$('.tab-item-ul').css("left", 0)
}
// 关闭tabs时重新调整位置
function closeWidth() {
	var tbox = $('.tab-item-box').width() //外边盒子距离长度
	var ul = $('.tab-item-ul').width() //tabs外边盒子长度
	var left = $('.tab-item-ul').position().left; //ul 左边偏移距离
	// var titem = $('#' + id)
	// console.log("tabs box 宽度", tbox)
	// console.log("ul宽度", ul)
	// console.log('left 长度', left)
	// console.log('差距', tbox - ul)
	if (ul > tbox) {
		$('.tab-item-ul').css("left", tbox - ul + 60)
	} else {
		$('.tab-item-ul').css("left", 0)
	}

}
//取消变色
function changeColor() {
	var tabs = vm.tabs
}

// 设置导航栏
function setNavs() {
	var url = 'lib/web/web.json'
	var web = getAjax(url);
	var navs = web.navs
	return navs
}


// ajax 获取数据
function getAjax(url) {
	var data = null;
	$.ajax({
		url: url, //json文件路径
		async: false,
		success: function(e) { //成功
			data = e
		},
		error: function(e) { //失败
			console.log('ajax加载失败')
		},
	});
	return data;
}
