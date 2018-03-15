<?php
if(!defined('IN_TTAE')) exit('Access Denied');


//百川API
//include_once	(ROOT_PATH.'top/request/TaeItemsListRequest.php');
include_once	(ROOT_PATH.'top/baichuan/TaeItemsListRequest.php');

include_once ROOT_PATH.'inc/api/apiBase.class.php';


//商品抓取和发布类
//百川高级电商能力
class api_baichuan extends apiBase{

		function __construct(){
			$this->use_baichuan();
		}

		function parse($i){

		}

		function get($i){
			
		}

		function get_list($list){
				return $this->get_goods($list);
		}

		//最大50 / 1组
		//http://open.taobao.com/apidoc/api.htm?path=scopeId:11681-apiId:23731
		//字段都会返回,只是查询是不能全写上,不然会报错.
		function get_goods($ids,$open_iid){
				global $_G;

				$req = new TaeItemsListRequest;


				$field = 'title,num,nick,pic_url,price,location,shop_name,post_fee';
				if(is_string($ids)){
					$ids = trim($ids,',');
				}else if(is_array($ids)){
					$ids = implode(',',$ids);
				}
				$req->setFields($field);
				$req->setNumIids($ids);
				$req->setOpenIids($open_iid);

				$resp = $_G['TOP']->execute($req);

				top_check_error($resp,true);

				$arr = array();
				$item = $resp->items->x_item;

				if(count($resp->items->x_item) ==1) {
						  $rs = $resp->items->x_item[0];
						  $arr = $this->parse_goods($rs);
						  return $arr;
				  }else{
					  $arr = array();
					  foreach($resp->items->x_item as $k=>$v){
						  $numiid = (string)$v->open_id;
						  $arr[$numiid] =$this->parse_goods($v);
					  }
					  return $arr;
				  }
				return false;

		}



		function parse_goods($item){
				global $_G;

				$arr = array();
				$arr['open_iid'] =		(string)$item->open_iid ;
				$arr['num_iid'] =		(string)$item->open_id ;						//商品ID
				$arr['title'] = 		$item->title;							//商品标题
				$arr['nick'] = 			$item->nick;							//卖家昵称
				$arr['picurl'] = 		$item->pic_url ;						//商品缩略图
				$arr['url'] = 			'http://item.taobao.com/item.htm?id=' .$arr['num_iid'] ;						//商品链接地址
				$arr['price'] =			sprintf("%.1f",$item->reserve_price);			//原价


				$arr['shop_type'] =		$item->mall?'1':'2';

				//注意价格,有些优惠价是原价,返回时可以过滤
				if($item->price_wap){
					$arr['yh_price'] =		$item->price_wap;
				}else if($item->price){
					$arr['yh_price'] =		$item->price;
				}else if($item->ju_price){
					$arr['yh_price'] =		$item->ju_price;
				}else{
					$arr['yh_price'] =		$item->reserve_price;
				}

				$arr['yh_price'] =sprintf("%.1f",$arr['yh_price']);


				$arr['bili'] =		$item->tk_rate ? ($item->tk_rate/100):'-1';
				if($item->tk_rate>0){
					$arr['bili'] =	$item->tk_rate/100;
					//$arr['bili'] = intval($item->tk_rate) * $arr['yh_price']/100;
					$tmp['yongjin'] 			= 			($arr['yh_price'] * $v->tk_rate) /100 / 100;

				}else if($item->istk){
					//$arr['bili'] =	'';	//防止是更新时,给替换了

				}else{
					$arr['bili'] =	'-1';
				}
				return $arr;
		}

		function get_sku($num_iid,$open_iid){
				global $_G;
				if(!$num_iid && !$open_iid) return false;
				if(!class_exists('TaeItemDetailGetRequest'))include_once	(ROOT_PATH.'top/baichuan/TaeItemDetailGetRequest.php');

				if(!$open_iid){
					$rs = $this->get_goods($num_iid);
					$open_iid = $rs['open_iid'];
				}

				$req = new TaeItemDetailGetRequest;
				//$req->setFields("itemInfo,priceInfo,skuInfo,stockInfo,rateInfo,descInfo,sellerInfo,mobileDescInfo,deliveryInfo,storeInfo,itemBuyInfo,couponInfo");
				$req->setFields("priceInfo,skuInfo,stockInfo");
				$req->setOpenIid($open_iid);
				$resp = $_G['TOP']->execute($req, $sessionKey);
				top_check_error($resp,true);
				$rs =  $resp->data;
				return $rs;
		}



		//iids 最大100个
		//添加批量订阅
		//http://open.taobao.com/doc2/apiDetail.htm?apiId=26974&scopeId=11681
		function add_list ($iids){
				global $_G;
				if(is_string($iids)){
					$iids = trim($iids,',');
				}else if(is_array($iids)){
					$iids = implode(',',$iids);
				}else{
					msg('商品ID不能为空');
				}
				if(!class_exists('BaichuanItemsSubscribeRequest'))include_once	(ROOT_PATH.'top/baichuan/BaichuanItemsSubscribeRequest.php');
				$req = new BaichuanItemsSubscribeRequest;

				$req->setItemIds($iids);
				$resp = $_G['TOP']->execute($req);
				top_check_error($resp,true);

				$item = $resp->result->result_list->result_meta[0];
				$code = $item->code;

				if($code == 0) {
					return true;
				}else {
					L('百川增加订阅失败:'.json_encode($item));
					msg($item->msg);
				}
		}

		//添加单个订阅
		function add($num_iid){
			global $_G;
			if(!$num_iid) msg('商品ID不能为空');

			if(!class_exists('BaichuanItemSubscribeRequest'))include_once	(ROOT_PATH.'top/baichuan/BaichuanItemSubscribeRequest.php');
			$req = new BaichuanItemSubscribeRequest;
			$req->setItemId($num_iid);
			$resp = $_G['TOP']->execute($req);
			top_check_error($resp,true);

			$item = $resp->result->result_list->result_meta[0];
				$code = $item->code;

				if($code == 0 || $code == 10) {
					return true;
				}else {
					L('百川增加订阅失败:'.json_encode($item));
					msg($item->msg);
				}
		}

		//批量删除商品订阅
		//http://open.taobao.com/docs/api.htm?spm=a219a.7395905.0.0.t6iOjV&scopeId=11681&apiId=26976
		function remove_all($iids){
				global $_G;
				if(is_string($iids)){
					$iids = trim($iids,',');
				}else if(is_array($iids)){
					$iids = implode(',',$iids);
				}else{
					msg('商品ID不能为空');
				}
				if(!class_exists('BaichuanItemsUnsubscribeRequest'))
				include_once	(ROOT_PATH.'top/baichuan/BaichuanItemsUnsubscribeRequest.php');
				$req = new BaichuanItemsUnsubscribeRequest;
				$req->setItemIds($iids);
				$resp = $_G['TOP']->execute($req);
				top_check_error($resp,true);

				$item = $resp->result->result_list->result_meta[0];
				$code = $item->code;

				if($code == 0) {
					return true;
				}else {
					L('百川增加订阅失败:'.json_encode($item));
					msg($item->msg);
				}

		}


		//http://open.taobao.com/docs/api.htm?spm=a219a.7395905.0.0.syB2lh&scopeId=11681&apiId=26975
		//删除单个订阅
		function remove($num_iid){
				global $_G;
				if(!$num_iid) msg('商品ID不能为空');

				if(!class_exists('BaichuanItemUnsubscribeRequest'))include_once	(ROOT_PATH.'top/baichuan/BaichuanItemUnsubscribeRequest.php');

				$req = new BaichuanItemUnsubscribeRequest;
				$req->setItemId($num_iid);
				$resp = $_G['TOP']->execute($req);

				top_check_error($resp,true);

				$item = $resp->result->result_list->result_meta[0];
				$code = $item->code;
				if($code == 0 || $code == 10 || $code == 11) {
					return true;
				}else {
					L('删除单个订阅失败:'.json_encode($item));
					msg ($item->msg);
				}
		}


		function debug_get_msg_list(){
//模拟订单成功
$item = array(
	array(
    "content"=>'{"extre":"","paid_fee":"0.10","shop_title":"美轮美奂3","is_eticket":false,"create_order_time":"2017-05-27 23:57:30","order_id":"23549091627480590","order_status":"2","seller_nick":"温暖宝贝666","auction_infos":[{"detail_order_id":"23549091627480590","auction_id":"AAE0GkG8ABssheA0S8cm_QI6","real_pay":"0.10","auction_pict_url":"i4/T14GGMFy4bXXXXXXXX_!!0-item_pic.jpg","auction_title":"1毛钱图片商品温暖主题电脑壁纸秒发0.1元自动发货好评主题收藏","auction_amount":"1"}]}',
    "id"=>7.2315018607813E+18,
    "pub_app_key"=>'12497914',
    "pub_time"=>'2017-05-27 23:57:38',
    "topic"=>'taobao_tae_BaichuanTradePaidDone',
  )
);


//订单创建
// $item = array(
// 	array(
//     "content"=>'{"extre":"","paid_fee":"0.10","shop_title":"美轮美奂3","is_eticket":false,"create_order_time":"2017-05-27 23:57:30","order_id":"23549091627480590","order_status":"7","seller_nick":"温暖宝贝666","auction_infos":[{"detail_order_id":"23549091627480590","auction_id":"AAE0GkG8ABssheA0S8cm_QI6","real_pay":"0.10","auction_pict_url":"i4/T14GGMFy4bXXXXXXXX_!!0-item_pic.jpg","auction_title":"1毛钱图片商品温暖主题电脑壁纸秒发0.1元自动发货好评主题收藏","auction_amount":"1"}]}',
//     "id"=>7.2315018607813E+18,
//     "pub_app_key"=>'12497914',
//     "pub_time"=>'2017-05-27 23:57:38',
//     "topic"=>'taobao_tae_BaichuanTradeCreated',
//   )
// );


			$item = json_encode($item);
			$item = json_decode($item,false);
			if(empty($item)) return false;
			$this->parse_msg($item);
			return count($item);
		}

		//消费多条消息
		//http://open.taobao.com/docs/api.htm?spm=a219a.7395905.0.0.kXG5tD&apiId=21986
		function get_msg_list(){
			global $_G;

			if(!class_exists('TmcMessagesConsumeRequest'))include_once	(ROOT_PATH.'top/baichuan/TmcMessagesConsumeRequest.php');
			$req = new TmcMessagesConsumeRequest;
			//$req->setGroupName('default');
			$req->setQuantity("10");
			$resp = $_G['TOP']->execute($req);
			top_check_error($resp,true);
			$item = $resp->messages->tmc_message;


			if(empty($item)) return false;
			$this->parse_msg($item);
			return count($item);
		}

		function parse_msg($list){
			$rs = array();
			$res = array();
			foreach($list as $k=>$v){
				$method = 'msg_'.$v->topic;
				$res[] = sprintf("%.0f",$v->id)."";

				if(method_exists($this,$method)){
				//	L($v->content);		//方便观察日志
					$con = json_decode($v->content,true);
					$rs[] = $this->$method($con);
				}
			}
			$this->confirm_msg($res);
			return $rs;
		}

		//确认消费消息的状态
		//http://open.taobao.com/docs/api.htm?spm=a219a.7395905.0.0.wk0mTb&apiId=21985
		function confirm_msg($iids){
			global $_G;
			if(is_string($iids)){
				$iids = trim($iids,',');
			}else if(is_array($iids)){
				$iids = implode(',',$iids);
			}else{
				msg('商品ID不能为空');
			}
			if(!class_exists('TmcMessagesConfirmRequest'))include_once	(ROOT_PATH.'top/baichuan/TmcMessagesConfirmRequest.php');
			$req = new TmcMessagesConfirmRequest;
			//$req->setGroupName("");
			$req->setSMessageIds($iids);
			$resp = $_G['TOP']->execute($req);
			top_check_error($resp,false);
			return true;
		}
		
		//交易成功
		//字段名称	字段描述	字段类别	字段类型	是否可空	示例值	其它信息
		// auction_infos	商品列表，类型为List；其中每个商品对应一个Map，包含商品模糊Id(auction_id)，商品标题(auction_title)，商品缩略图(auction_pict_url)这是auction_infos这个字段的描述	复杂列表		否		
		// buyer_id	买家混淆id	基本类型	String	否		
		// create_order_time	订单创建时间	基本类型	String	是	123456	
		// extre	扩展字段	基本类型	String	是		
		// is_eticket	电子凭证类订单标示。true：是电子凭证类订单；空or false：不是电子凭证类订单	基本类型	Boolean	是	false	
		// order_id	主订单id	基本类型	String	否		
		// order_status	订单状态：1-等待买家付款,2-等待卖家发货,6-交易成功  7-创建订单消息(下单未付款)	基本类型	String	否		
		// paid_fee	买家实付金额、单位元。格式： 100.00	基本类型	String	否		
		// seller_nick	卖家nick	基本类型	String	是	123456	
		// shop_title	店铺名称	基本类型	String	是	123456
		// 
		//array(0=>'待审核',1=>'待用户认领',2=>'已失效',3=>'已返积分',4=>'待返积分');		
		// 
		function msg_taobao_tae_BaichuanTradeSuccess($item){
			
				$arr= array();
				$order_id = $item['order_id'];
				if($item['order_status'] == 1 || $item['order_status'] ==  7 ){
					//等待买家付款  创建订单消息(下单未付款)
						$arr['status']= 0;
				}else if($item['order_status'] == 2 || $item['order_status'] == 6){
					//等待卖家发货 6-交易成功
					$arr['status']= 4;
					if($item['order_status'] == 6) $arr['end_time'] = TIMESTAMP;
				}else if($item['order_status'] == 4 || $item['order_status'] == 8){
					//退款后交易关闭；   创建订单后交易关闭基本类型
					$arr['status']= 2;
				}else {
					$arr['status']= 0;
				}

				if($item['buyer_id']){
					$buyer_id = $item['buyer_id'];
					$user =  DB::fetch_first("SELECT uid,username FROM ".DB::table('member')." WHERE login_id ='$buyer_id'");
					if(!$user['uid']){
						L('已创建订单但用户不存在msg_taobao_tae_BaichuanTradeSuccess '.$arr['order_number']);
						 return ;
					}
					$arr['uid'] = $user['uid'];
					$arr['username'] = $user['username'];
				}
	
				$rs = DB::fetch_first("SELECT id,uid,status FROM ".DB::table('order_list')." WHERE order_number ='$order_id'");

				if($arr['status'] == 4 && !$arr['uid'] && !$rs['uid']) $arr['status'] =1;	//待认领
				if($rs['id']==0) {
						$arr['order_number']= $item['order_id'];
						$arr['pingtai']= $item['extre'];
						$arr['type']= 3;	//消息订阅
						$arr['dateline']= TIMESTAMP;
						$arr['price']= $item['paid_fee'];
						$arr['title']= $item['auction_infos'][0]['auction_title'];
						$arr['create_time']= dmktime($item['create_order_time']);
						DB::insert("order_list",$arr);
				}else{

					DB::update('order_list',$arr,"id=".$rs['id']);
				}

		}

		 
		 // 创建订单
		function msg_taobao_tae_BaichuanTradeCreated($item){
				$this->msg_taobao_tae_BaichuanTradeSuccess($item);
		}


		//付款成功
		function msg_taobao_tae_BaichuanTradePaidDone($item){
				$this->msg_taobao_tae_BaichuanTradeSuccess($item);
		}

		//交易关闭
		function msg_taobao_tae_BaichuanTradeClosed($item){
				$order_id = $item['order_id'];
				$rs = DB::fetch_first("SELECT id FROM ".DB::table('order_list')." WHERE order_number ='$order_id'");
				if($rs['id']>0) {
					DB::update('order_list',array('status'=>2),"id=".$rs['id']);
				}
		}


		//商品下架
		//字段名称	字段描述	字段类别	字段类型	是否可空	示例值	其它信息
		// item_id	商品id	基本类型	String	否	123456	
		// item_title	商品标题	基本类型	String	是	袜子超厚超厚冬天	
		// timestamp	下架发生时间	基本类型	Date	否	2016-05-31 18:03:14
		function msg_taobao_tae_ItemDownShelf($item){
			$iid = $item['num_iid'];
			DB::update('goods',array('status'=>9),"num_iid='".$iid."'");
		}

		//商品售空
		//字段名称	字段描述	字段类别	字段类型	是否可空	示例值	其它信息
		// item_id	商品id	基本类型	String	否	123456	
		// item_title	商品标题	基本类型	String	是	养猫专用猫砂	
		// timestamp	卖空时间	基本类型	Date	否	2016-05-31 19:46:02
		function msg_taobao_tae_ItemSoldOut($item){
			$iid = $item['num_iid'];
			DB::update('goods',array('status'=>9),"num_iid='".$iid."'");
		}

		//商品删除消息
		//字段名称	字段描述	字段类别	字段类型	是否可空	示例值	其它信息
		// item_id	商品id	基本类型	String	否	123456	
		// item_title	商品标题	基本类型	String	是	养猫专用猫砂	
		// timestamp	卖空时间	基本类型	Date	否	2016-05-31 19:46:02
		function msg_taobao_tae_ItemDelete($item){
			$iid = $item['num_iid'];
			DB::update('goods',array('status'=>9),"num_iid='".$iid."'");
		}


//下面的可以不需要
/*********************************************************************************************************/

		//商品上架
		//字段名称	字段描述	字段类别	字段类型	是否可空	示例值	其它信息
		// item_id	商品id	基本类型	String	否	123456	
		// item_info	商品详情	复杂类型		否		
		// timestamp	商品上架时间	基本类型	Date	否	2016-05-31 18:54:37	
		function msg_taobao_tae_ItemUpShelf($item){
			//$iid = $item['num_iid'];
			//DB::update('goods',array('status'=>1),"num_iid='".$iid."'");
		}


		//商品主图变更
		//字段名称	字段描述	字段类别	字段类型	是否可空	示例值	其它信息
		// item_id	商品id	基本类型	String	否	123456	
		// item_info	商品详情	复杂类型		否		
		// timestamp	主图变更的时间戳	基本类型	Date	否	2016-05-31 18:07:37	
		function msg_taobao_tae_ItemImageChange($item){

		}

		//sku删除
		//字段名称	字段描述	字段类别	字段类型	是否可空	示例值	其它信息
		// item_id	商品id	基本类型	String	否	23412312	
		// item_title	商品标题	基本类型	String	是	大毛衣手织	
		// sku_desc	sku描述	基本类型	String	是	红色大红色	
		// sku_id	skuId	基本类型	String	否	1234562341	
		// timestamp	删除sku的时间	基本类型	Date	否	2016-05-31 18:18:59
		function msg_taobao_tae_ItemSkuDelete($item){

		}


		//商品标题变更
		//字段名称	字段描述	字段类别	字段类型	是否可空	示例值	其它信息
		// item_id	商品id	基本类型	String	否	123456	
		// item_info	商品详情	复杂类型		否		
		// timestamp	商品标题修改时间	基本类型	Date	否	2016-05-31 19:42:10	
		function msg_taobao_tae_ItemTitleChange($item){

		}

		//订阅的商品变更消息
		// 字段名称	字段描述	字段类别	字段类型	是否可空	示例值	其它信息
		// item_id	商品id	基本类型	String	否	123456	
		// item_info	商品详情	复杂类型		否		
		// timestamp	消息发生的时间戳	基本类型	Date	否	2016-05-27 14:53:09	
		function msg_taobao_tae_ItemPriceChange($item){
			$info = $item['item_info'];
			$iid = $info['num_iid'];


		}

		//退款成功
		//字段名称	字段描述	字段类别	字段类型	是否可空	示例值	其它信息
		// auction_id	商品id	基本类型	String	是	123456	
		// buyer_id	买家混淆ID	基本类型	String	否	231423412	
		// extre	预留字段，ISV个性化业务扩展属性	基本类型	String	否	{}	
		// oid	子订单ID	基本类型	String	否	223423423	
		// refund_fee	退款金额	基本类型	String	否	10.1	
		// refund_id	退款单ID	基本类型	String	否	23412341234	
		// seller_nick	卖家昵称	基本类型	String	否	卖家卖家	
		// tid	主订单ID	基本类型	String	否	234234234	
		function msg_taobao_tae_BaichuanTradeRefundSuccess($item){
			//$this->msg_taobao_tae_BaichuanTradeCreated($item);
				//有效易关闭,可以不用写退款的
				// $order_id = $item['tid'];
				// $rs = DB::fetch_first("SELECT id,uid FROM ".DB::table('order_list')." WHERE order_number ='$order_id'");
				// if($rs['id']>0) {
				// 	DB::update('order_list',array('status'=>2),"id=".$rs['id']);
				// }
		}

		//商品信息变更
		//字段名称	字段描述	字段类别	字段类型	是否可空	示例值	其它信息
		// auction_change_info	对应的是一个由Map转换为的json串，现在只有itemStatus（商品状态）这一个key，
		// 				对应的value有两个：-1（商品状态不可用）和1（商品状态可用）	基本类型	String	否		
		// open_iid	商品混淆Id	基本类型	String	否
		// {
		//   "timestamp": "2016-05-27 14:53:09",
		//   "item_id": "123456", //商品id
		//   "item_info": {
		//     "location": "杭州", //所在地
		//     "sku_infos": [
		//       {
		//         "price": "1.99", //商品价格
		//         "quantity": "1", //数量
		//         "sku_id": "23412341", 
		//         "promotion_price": "1.65" //最低价
		//       }
		//     ],
		//     "shop_name": "yoyo的衣服店", //店铺名称
		//     "promotion_price": "1.33",
		//     "post_for_free": "true",
		//     "title": "毛绒袜子",
		//     "price": "3.44",
		//     "cart_support": "true",
		//     "promotion_tips": "淘金币满20抵4元",
		//     "quantity": "234",
		//     "seller_type": "taobao",
		//     "in_sale": "true",
		//     "seller_nick": "yoyo衣服好", //卖家昵称
		//     "img_urls": [
		//       "http://img.jpg,http://isdfasd.jpg" //商品主图地址
		//     ]
		//   }
		// }
		function taobao_tae_BaichuanAuctionChange($item){
				
		}	

}

?>
