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

    function getHaoJuanQingDan($arr) {
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


    function getTongYongWuLiaoDaoGou($arr) {
        global $_G;

        include_once(ROOT_PATH . 'top/tbk/TbkDgMaterialOptionalRequest.php');
        $req = new TbkDgMaterialOptionalRequest;
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
        if($arr['start_dsr'])$req->setStartDsr($arr['start_dsr']);
        if($arr['has_coupon'])$req->setHasCoupon($arr['has_coupon']);

        $req->setPageNo($arr['page_no']);
        $req->setPageSize($arr['page_size']);

        $pid = $_G['setting']['pid'];
        $pid = explode('_',$pid);
        $req->setAdzoneId($pid[3]);
        $resp = $_G['TOP']->execute($req);

        top_check_error($resp, $this->show_error);
        $rt = array();
        $rt['count'] = $resp->total_results;

        if($rt['count']==0) return array('count'=>0,'goods'=>array());
        $rt['goods'] =  $this->parse($resp);

        $rt['goods'] = $this->parseShortUrl($rt['goods']);
        return $rt;
    }

    function parse($resp) {
		return $this->parse_good($resp);
    }

    function parseShortUrl($goods) {
        $array = Array();
        $i = 0;
        foreach($goods as $k=>$v){
            if(isset($v[juan_url]) && $v[juan_url]!=""){
                $array[$i] = $v[juan_url];
            }
            $i++;
            if($i % 20  != 0){
                continue;
            }

            $goods = $this->_parseShortUrl($goods,$array);
            $array = Array();
        }

        if(count($array) != 0){
            $goods = $this->_parseShortUrl($goods,$array);
        }
        return $goods;
    }

    function _parseShortUrl($goods,$array) {
        $resources = $this->getShortUrl($array)->results->tbk_spread;
        $i=0;
        foreach($array as $kk=>$vv){
            $v1 = $resources[$i];
            if(strcasecmp($v1->err_msg,"ok")==0){
                $goods[$kk][juan_url] = $v1->content;
                logString($goods[$kk][juan_url],"shortUrlTurnError");
            }else{
                logString($goods[$kk][juan_url],"shortUrlTurnError");
            }
            $i++;
        }
        return $goods;
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

            $i = 0;
            foreach ($urlarray as $k => $v) {
                $arr = array();
                $arr[url] = $v;
                $requests->putOtherTextParam($i++,$arr);
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
        $req = new TbkShopsDetailGetRequetaobao.tbk.shops.detailst;
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
        return $this->parse_good($resp);
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

    function get_open_id_by_orderId($arr) {
        global $_G;

        include_once(ROOT_PATH . 'top/tbk/OpenuidGetBytradeRequest.php');
        $req = new OpenuidGetBytradeRequest;
        $req->setTid($arr[orderId]);
        $resp = $_G['TOP']->execute($req,$arr[session]);
        top_check_error($resp,$this->show_error);
        return $resp;
    }

    function get_open_id($session) {
        global $_G;

        include_once(ROOT_PATH . 'top/tbk/OpenuidGetRequest.php');
        $req = new OpenuidGetRequest;
        $resp = $_G['TOP']->execute($req,$session);
        top_check_error($resp,$this->show_error);
        return $resp;
    }

    function refreshAccessToke($key) {
        global $_G;

        include_once(ROOT_PATH . 'top/tbk/TopAuthTokenRefreshRequest.php');
        $req = new TopAuthTokenRefreshRequest;
        $req->setRefreshToken($key);
        $resp = $_G['TOP']->execute($req);
        top_check_error($resp,$this->show_error);
        $info = json_decode ($resp,1);
        return $info;
    }

    function createAccessToke($arr) {
        global $_G;

        include_once(ROOT_PATH . 'top/tbk/TopAuthTokenCreateRequest.php');
        $req = new TopAuthTokenCreateRequest;
        $req->setCode($arr[code]);
        if($arr[uuid]) $req->setUuid($arr[uuid]);
        $resp = $_G['TOP']->execute($req);
        top_check_error($resp,$this->show_error);
        return $resp;
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


    /**
     * @param $resp
     * @param int $from 0:商品查询,1:
     * @return array|null
     */
    static function parse_good($resp,$from = 0) {
        if(is_array($resp)){
            $item = $resp;
        }else{
            $result= $resp->results;
            if(!$result){
                $result= $resp->result_list;
            }

            if(!$result){
                return null;
            }

            $item = $result->n_tbk_item;
            if(!$item){
                $item = $result->tbk_coupon;
            }

            if(!$item){
                $item = $result->uatm_tbk_item;
            }
            if(!$item){
                $item = $result->map_data;
            }
        }

        if(count($item) == 0){
            return null;
        }

        $arr = array();

        foreach ($item as $k => $v) {
            if(isset($v->status) && $v->status != 1 ){
                continue;
            }

            $tmp = array();
            $tmp['num_iid'] =''. $v->num_iid;
            $tmp['title'] = $v->title;
            $tmp['provcity'] = $v->provcity? $v->provcity:"";
            $tmp['url'] = $v->click_url?$v->click_url:$v->item_url;//商品链接地址(淘客地址优先)
            $tmp['picurl'] = $v->pict_url;
            $tmp['nick'] = $v->nick;
            $tmp['sum'] = $v->volume;	//30天销量
            $tmp['price'] = fix($v->reserve_price,1);//原价
            $tmp['yh_price'] = fix($v->zk_final_price,1);//折扣价(有可能不存在)
            $tmp['images'] = $v->small_images->string;
            $tmp['shop_type'] = $v->user_type? $v->user_type:-1;
            $tmp['sid'] = $v->seller_id."";
            if($v->small_images){
                $tmp['images'] = $v->small_images->string;
            }
            $tmp['start_time'] =  $v->coupon_start_time?$v->coupon_start_time:$v->event_start_time;
            $tmp['end_time'] = $v->coupon_end_time?$v->coupon_end_time:$v->event_end_time;
            if($tmp['end_time'] =='1970-01-01 00:00:00')   $tmp['end_time']=0;
            if($tmp['start_time']=='1970-01-01 00:00:00') $tmp['start_time']=0;
            $coupon_info = $v->coupon_info?$v->coupon_info:$v->juan_price;
            if($coupon_info){
                $patterns = "/\d+/";
                preg_match_all($patterns,$coupon_info,$arrt);
                $coupon_info = end($arrt[0]);
                $tmp['juan_price'] = $coupon_info;
            }
            if($coupon_info && isset($v->coupon_remain_count) && $v->coupon_remain_count == 0){
                continue;
            }

            if(isset($v->coupon_click_url)){
                $tmp['juan_url'] = $v->coupon_click_url;
            }else if(isset($v->coupon_id) && $v->coupon_id != ""){
                $tmp['juan_url'] = self::parse_juan_url($v->coupon_id,$tmp['sid'], $tmp['num_iid']);
            }

            if(isset($v->commission_rate)){
                $tmp['bili'] = $v->commission_rate*$tmp['price']/10000;
            }
           /* if($tmp['juan_url'] && strlen($tmp['juan_url'])>50){
                $re = $this->getShortUrl(Array($tmp['juan_url']));
                if(strcasecmp(current($re->results->tbk_spread)->err_msg,"ok" ) == 0){
                    $arr['juan_url'] = current($re)->content;
                }else{
                    logString($arr['juan_url']."cant get shorturl:returnData".json_decode($re),"shortUrlError");
                }
            }*/

            $arr[] = $tmp;
        }

        return $arr;
    }

    static function parse_juan_url($juanId,$sellerId,$itemId){
        global $_G;
        return "https://uland.taobao.com/coupon/edetail?activityId=".$juanId."&sellerId=".$sellerId."&pid=".$_G[setting][pid]."&itemId=".$itemId;
    }

}