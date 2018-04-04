<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
//http://open.taobao.com/apidoc/api.htm?path=scopeId:11655-apiId:24515	taobao.tbk.item.get 淘宝客基础API
//http://open.taobao.com/apidoc/api.htm?path=scopeId:11260-apiId:22569	obao.tbk.items.get 淘宝客推广商品查询

//阿里妈妈 申请网站后对应淘宝客api
include_once ROOT_PATH.'inc/api/apiBase.class.php';
class api_tbk  extends apiBase{
	public $get_ext = true;

    function __construct(){
        $this->use_taobaoke();
    }
    
   /*
   
   用初级包,则需要用基础包来扩展信息字段
   用基础包,就必须用初级包来扩展信息字段
   
   */
   
   //淘宝客基础API
	//http://open.taobao.com/doc2/apiDetail.htm?spm=0.0.0.0.D8quLk&scopeId=11655&apiId=24515
    function get($arr) {
        global $_G;
		
        include_once(ROOT_PATH . 'top/tbk/TbkItemGetRequest.php');
        $req = new TbkItemGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
		if(!$arr['keyword'] && !$arr['cid']){
			return array('count'=>0,'goods'=>array());
		}
		
		if($arr['keyword'])$req->setQ($arr['keyword']);
		if($arr['cid'])$req->setCat($arr['cid']);
		$req->setItemloc($arr['area']);
        if($arr['sort']){
            $req->setSort($arr['sort']);
        }else{
            $req->setSort("total_sales_des");
        }
		$req->setIsTmall($arr['mall_item']);
		if($arr['start_price'])$req->setStartPrice($arr['start_price']);
		if($arr['end_price'])$req->setEndPrice($arr['end_price']);
		if($arr['start_commission_rate'])$req->setStartTkRate($arr['start_commission_rate']*100);
		if($arr['end_commission_rate'])$req->setEndTkRate($arr['end_commission_rate'] * 100);

		$req->setPageNo($arr['page_no']);
		$req->setPageSize($arr['page_size']);

        $resp = $_G['TOP']->execute($req);

        top_check_error($resp, $this->show_error);
		$rt = array();
		$rt['count'] = $resp->total_results;
		
		if($rt['count']==0) return array('count'=>0,'goods'=>array());
		$rt['goods'] =  $this->parse($resp);
        return $rt;
    }

    function getHaoQuanQingDan($arr) {
        global $_G;

        include_once(ROOT_PATH . 'top/tbk/TbkDgItemCouponGetRequest.php');
        $req = new TbkDgItemCouponGetRequest;
        $id = substr(strrchr($_G[setting][pid], '_'),1);
        $req->setAdzoneId($id);
        if($arr['keyword'])$req->setQ($arr['keyword']);
        if($arr['cid'])$req->setCat($arr['cid']);

        $req->setPageNo($arr['page_no']);
        $req->setPageSize($arr['page_size']);

        $resp = $_G['TOP']->execute($req);

        top_check_error($resp, $this->show_error);
        $rt = array();
        $rt['count'] = $resp->total_results;

        if($rt['count']==0) return array('count'=>0,'goods'=>array());
        $rt['goods'] =  $this->parse($resp);

        return $rt;
    }


    function parse($resp) {
        $items=$resp->results->n_tbk_item;
        if(!$items){
            $items=$resp->results->tbk_coupon;
        }
		$goods_list = array();
	
		foreach($items as $k=>$item){
				$arr = array();
				
				$num_iid = $arr['num_iid'] =		(string)$item->num_iid ;						//商品ID
				$arr['title'] = 		trim_html($item->title,1);							//商品标题
                $arr['title'] = $arr['title'] .'['. $item->provcity.']';
				$arr['picurl'] = 		$item->pict_url;						//商品缩略图
				$arr['url'] = 			$item->item_url;						//商品链接地址
				$arr['price'] =			fix($item->reserve_price,1);			//原价
				$arr['yh_price'] =			fix($item->zk_final_price,1);			//原价
				$arr['images'] =	$item->small_images->string;
				$arr['shop_type'] =		$item->user_type ==1 ?'1':'2';	
				$arr['sid'] =		$item->seller_id."";	
			    $arr['juan_url'] = $item->coupon_click_url;
                if($arr['juan_url'] && strlen($arr['juan_url'])>50){
                    $re = $this->getShortUrl(Array($arr['juan_url']));
                    $re = $re->results->tbk_spread;
                    if(strcasecmp(current($re)->err_msg,"ok" ) == 0){
                        $arr['juan_url'] = current($re)->content;
                    }else{
                        logString($arr['juan_url']."cant get shorturl","shortUrlError");
                    }
                }

				//所有淘客API不返回这些字段
				 $arr['nick'] =      $item->nick;    
                $arr['sum'] =       $item->volume;  
                $arr['bili']  = '';
				
							
			$goods_list[$num_iid] = $arr;
		}

		return $goods_list;

    }
	
	
	function get_shop_by_taokouling($taokouiling){
        global $_G;

        include_once(ROOT_PATH . 'top/tbk/WirelessShareTpwdQueryRequest.php');
        $req = new WirelessShareTpwdQueryRequest();
        $req->setPasswordContent($taokouiling);

        $resp = $_G['TOP']->execute($req);

        top_check_error($resp, $this->show_error);
        return $resp;
    }


    function getShortUrl($urlarray){
        global $_G;

        include_once(ROOT_PATH . 'top/tbk/TbkSpreadGetRequest.php');
        $req = new TbkSpreadGetRequest;
        $requests = new TbkSpreadGetRequest;

        if(is_array($urlarray)){

            foreach ($urlarray as $k => $v) {
                $arr = array();
                $arr[url] = $v;
                $requests->putOtherTextParam($k,$arr);
            }
        }else{
            $arr = array();
            $arr[url] = $urlarray;
            $requests->putOtherTextParam(0,$arr);
        }

        $req->setRequests(json_encode($requests->getApiParas()));
        $resp = $_G['TOP']->execute($req);

        top_check_error($resp, $this->show_error);
        return $resp;
    }



    /*
     * 淘宝客商品关联推荐查询
     * 1:同类商品推荐，
     * */

 	function get_shop($uid,$nick,$size =20) {
        global $_G;

        include_once(ROOT_PATH . 'top/tbk/TbkShopsDetailGetRequest.php');
        $req = new TbkShopsDetailGetRequest;
        $req->setFields("user_id,seller_nick,shop_title,pic_url,shop_url");
		if($uid)$req->setSids($uid);
		if($nick)$req->setSellerNicks($nick);

        $resp = $_G['TOP']->execute($req);
        top_check_error($resp,$this->show_error);
		
		$rs = $this->parse_shop($resp);
        return $rs;
    }
	
	function parse_shop($resp){
		$item = (array)$resp->tbk_shops->tbk_shop[0];
		
		$shop = array();
		$shop['picurl'] = $item['pic_url'] ;
		$shop['nick'] = $item['seller_nick'] ;
		$shop['title'] = $item['shop_title'] ;
		$shop['url'] = $item['shop_url'] ;
		$shop['sid'] = $item['user_id'].'';
		
		return $shop;
		
	}


	function get_goods($num_iid){
			return $this->get_info($num_iid);
			
	}


	 /*
     * 淘宝客商品详情（简版）
     * taobao.tbk.item.info.get
     * $ids 商品num_iid列表,最多40个
     * */
    function get_info($ids) {
        global $_G;
        include_once(ROOT_PATH . 'top/tbk/TbkItemInfoGetRequest.php');
        if (is_array($ids)) {
            $ids = implode(",", $ids);
        }

        $req = new TbkItemInfoGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,nick,volume,seller_id");
        $req->setPlatform(1);
        $req->setNumIids($ids);

        $req->setPlatform(1);
        $resp = $_G['TOP']->execute($req);

        top_check_error($resp, $this->show_error);
        $rs = $this->parse_info($resp);

		if(count($rs) ==1 && $rs){
			sort($rs);
			$rs = $rs[0];
		}
        return $rs;
    }

    function parse_info($resp) {
        $item = $resp->results->n_tbk_item;
        $arr = array();

        foreach ($item as $k => $v) {
            $tmp = array();
            $tmp['url'] = $v->item_url;
			$tmp['nick'] = $v->nick;
			$tmp['sum'] = $v->volume;	//30天销量
            $num_iid = $tmp['num_iid'] =''. $v->num_iid;
            $tmp['picurl'] = $v->pict_url;

            $tmp['price'] = $v->reserve_price;
            $tmp['yh_price'] = $v->zk_final_price;
            $tmp['images'] = $v->small_images->string;
            $tmp['title'] = $v->title;
            $tmp['title'] =  $v->title.'['. $v->provcity.']';
            $tmp['shop_type'] = $v->user_type == 1 ? 1 : 2;
            $tmp['sid'] = $v->seller_id."";

            //if( $tmp['yh_price'] != $tmp['price'] ) {
              //  $tmp['zk']	= sprintf("%.1f",($tmp['yh_price']/$tmp['price']*10));
              //  $tmp['zk']	= 	str_replace('.0','',$tmp['zk']);
            //}
            $arr[$num_iid] = $tmp;
        }

        return $arr;
    }





    /*
     * 淘宝客商品关联推荐查询
     * @paremt relate_type 推荐类型，
     * 1:同类商品推荐，
     * 2:异类商品推荐，
     * 3:同店商品推荐，此时必须输入num_iid;
     * 4:店铺热门推荐，此时必须输入user_id，这里的user_id得通过taobao.tbk.shop.get这个接口去获取user_id字段;
     * 5:类目热门推荐，此时必须输入cid
     *
     * */

    function get_recommend($relate_type, $id,$size =24) {
        global $_G;

        include_once(ROOT_PATH . 'top/tbk/TbkItemRecommendGetRequest.php');
        $req = new TbkItemRecommendGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url");

        $req->setNumIid($id);
        $req->setCount($size);
        $req->setPlatform(1);
        $resp = $_G['TOP']->execute($req);
        top_check_error($resp,$this->show_error);
        $rs  = $this->parse_info($resp);
        return $rs;
    }

//http://open.taobao.com/doc2/apiDetail.htm?apiId=26520&scopeId=11998
public    function tkl($url,$text,$logo_url,$user_id = 1,$ext=""){
                global $_G;

                include_once(ROOT_PATH . 'top/tbk/WirelessShareTpwdCreateRequest.php');
                include_once(ROOT_PATH . 'top/tbk/IsvTpwdInfo.php');
               
                $req = new WirelessShareTpwdCreateRequest;
                $tpwd_param = new IsvTpwdInfo;
                $tpwd_param->logo= $logo_url;
                $tpwd_param->text=$text;
                $tpwd_param->url= $url;
                $tpwd_param->ext=$ext;
                $tpwd_param->user_id=$user_id;

       
                $req->setTpwdParam(json_encode($tpwd_param));
                $resp = $_G['TOP']->execute($req);

                top_check_error($resp,$this->show_error);
                $tkl=  $resp->model;
                return $tkl;
    }


    //taobao.tbk.privilege.get (单品券高效转链API)
    //http://open.taobao.com/docs/api.htm?spm=a1z6v.8204065.c3.32.1nC2UY&apiId=28625#
    //一般用户无权限
    function quan($iid,$pid){
             global $_G;
             if(!$pid) $pid = $_G['setting']['pid'];
             include_once(ROOT_PATH . 'top/tbk/TbkPrivilegeGetRequest.php');
             
             $req = new TbkPrivilegeGetRequest;
            $req->setItemId($iid);
            $pid = explode('_',$pid);
            $req->setAdzoneId($pid[3]);
            $req->setPlatform("2");
            $req->setSiteId($pid[2]);
            // $req->setMe("");

            $resp = $_G['TOP']->execute($req, $_SESSION['user']['refresh_token']);
          
            top_check_error($resp,$this->show_error);

    }



}