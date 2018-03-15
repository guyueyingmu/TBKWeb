
var quan_upload = {
		time:5,
		goods_list:[],
		cfg:{
				sum : 0,
				count :  0,
				curent :  0,
		},
		start:false,
		key:'',
		init:function(){
			var _this = this;

			$('.upload_file_btn').change(function(){
				$(this).prop('readonly', true);
				if(_this.start) return false;
				_this.upload(this);
			})
			$('.submit_btn').click(function(){
				if(_this.goods_list.length==0){
					_log('待发布的商品不能为空,您需要先选择一个txt文件');
					return false;
				}
				if(_this.start) return false;
				_this.next(_this);
				_this.start = true;
				return false;
			})
			this.key = $('.table_main').data('key');

		window.onbeforeunload=function (){ 
			if(!quan_upload.start ) return true;
			return confirm('当前页面正在进行任务,您确定要刷新页面吗?');
		} 

		},
		upload:function (input) {
				if (!window.FileReader) {
					showDialog('您的浏览器不支持上传,请使用chrome或是360极速浏览器')
					return ;
				}
				var _this = this;
				let file = input.files[0];
				if(!file) return ;

				_this.goods_list =[];
				_this.cfg.sum = 0;
				_this.cfg.count =  0;
				_this.cfg.curent =  0;

				let filename = file.name.split(".")[0];
				let reader = new FileReader();
				let size =  (file.size / 1024 /1024).toFixed(1);
				_this._log('获取到文件大小为'+size+'Mb');
				//if(size>2) $('.table_main .update_submit').remove();
				
				
				reader.onload = function() {
					if(this.result.indexOf('商品id') == -1 ) {
						showDialog('上传文件不正确');
						return ;
					}
					let text = this.result.split('\r\n');
					text.shift();
					
					_this._log('获取到文件总行数为'+text.length+'条,点击开始发布,即将自动发布',1);
					_this.goods_list = _this.chunk(text,50);
					_this.cfg.sum =  text.length;
					_this.cfg.count =  _this.goods_list.length;
					_this.cfg.curent =  0;
					_this.set_text();
				}
				reader.readAsText(file);
		}
		,chunk:function   (array, size) {
	        var result = [];
	        for (var x = 0; x < Math.ceil(array.length / size); x++) {
	            var start = x * size;
	            var end = start + size;
	            result.push(array.slice(start, end));
	        }
	        return result;
	    },
	    login_index :0,
	    _log:function (str,red){
	    	this.login_index++;
	    	var el = $('<p>'+this.login_index+','+str+'</p>');
	    	if(red)el.addClass('red');
	    	//$('.log_box').prepend();
	    	el.prependTo('.log_box');
	    }
	    ,
	    set_text:function (){
	    	$('.post_count span').eq(0).text(this.cfg.sum);
	    	$('.post_count span').eq(1).text(this.cfg.curent);
	    	$('.post_count span').eq(2).text(this.cfg.count);
	    	
	    },next:function(_this){

	    	let item = _this.goods_list.shift();
			if(!item || !item[0]) {
				_this.start = false;
				_log('所有数据发布完成',1);
				return ;
			}
			_this.cfg.curent = _this.cfg.count - _this.goods_list.length;
			_this.set_text();
			var rs = [];
			item.forEach(function(data){
				if(data){
					let tmp = data.split('	');
					let tmp2 = _this.parse(tmp);
					if(tmp)	rs.push(tmp2);
				}
			});

			_this.post_goods(rs,function(es){
				_this._log(es.msg + ','+_this.time+'秒后继续下一批发送');
			});


			setTimeout(function(){
				_this.next(_this);
			},_this.time*1000)

	    },post_goods:function(data,call){
	    	var url = '/fetch/index.php?syn_key='+this.key;
	    	var edata = {'data':encodeURIComponent(JSON.stringify(data)),len:data.length,a:'post_goods'};
		    var _this = this;

		     $.ajax({
		     	url: url,
		     	type: 'POST',
		     	dataType: 'JSON',
		     	data: edata,
		     })
		     .done(function(rs) {

		     	if(rs.status == 'error') {
		     		_this._log(rs.msg,1);
		     		return ;
		     	}

		     	call(rs);
		     })	
		     .fail(function(rs) {
		     	showDialog('发布失败,请查看错误日志');
		     	L(rs);
		     });
	    },
	    parse:function(item){
				var rs = {};
				rs.num_iid = item[0];
				rs.title = item[1];
				rs.picurl = item[2];
				rs.shop_type = item[13] =='天猫' ? 1 :0;
				rs.yh_price = item[6];
				rs.sum = item[7];
				rs.bili = item[8];
				rs.nick = item[10];
				rs.url = item[5];

				rs.sid = item[11];
				rs.quan_sum = item[15];
				rs.quan_num = item[16];

				var reg2 = /满([\d\.]{1,6})元减([\d\.]{1,6})元/;
		        var tmp = item[17].match(reg2);

		        if(tmp && tmp[2]){
		        	rs.juan_price    = tmp[2];
				}else if(!tmp && item[15] && item[15].indexOf('元无条件券') >-1){
			 		rs.juan_price    = item[15].replace('元无条件券','');
				}
				 //防止无条件券,价格为负数
				if(rs.yh_price - rs.juan_price <0) return false;

				rs.start_time       = item[18];
				rs.end_time       =  item[19]+' 23:59:59';

				rs.juan_url    = item[21];
				let pid = sub_str(item[21],'&pid=','&af=1');

				rs.juan_url  = 'https://uland.taobao.com/coupon/edetail?activityId='+item[14];
				rs.juan_url +='&itemId='+item[0]+'&pid='+pid+'&src=kfz_utao&sid='+item[11];

				rs.status = 1;
				rs.bili_type = 1;
				return rs;

		}

}

$(function(){
	quan_upload.init();
});
