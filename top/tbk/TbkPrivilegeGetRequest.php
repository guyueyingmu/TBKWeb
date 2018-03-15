<?php
/**
 * TOP API: taobao.tbk.uatm.favorites.get request
 * 
 * @author auto create
 * @since 1.0, 2016.04.29
 */
class TbkPrivilegeGetRequest
{
	/** 
	 * 需要返回的字段列表，不能为空，字段名之间使用逗号分隔
	 **/
	private $fields;

	private $itemId;
	private $adzoneId;
	private $platform;
	private $siteId;
	private $me;
	


	
	private $apiParas = array();
	
	public function setFields($fields)
	{
		$this->fields = $fields;
		$this->apiParas["fields"] = $fields;
	}

	public function getFields(){
		return $this->fields;
	}

	public function setItemId($iid){
		$this->itemId = $iid;
		$this->apiParas["item_d"] = $iid;
	}

	public function getItemId(){
		return $this->itemId;
	}

	public function setAdzoneId($iid){
		$this->adzoneId = $iid;
		$this->apiParas["adzone_id"] = $iid;
	}

	public function getAdzoneId(){
		return $this->adzoneId;
	}

	public function setPlatform($iid){
		$this->platform = $iid;
		$this->apiParas["platform"] = $iid;
	}

	public function getPlatform(){
		return $this->platform;
	}

	public function setSiteId($iid){
		$this->siteId = $iid;
		$this->apiParas["site_id"] = $iid;
	}

	public function getSiteId(){
		return $this->siteId;
	}

	public function setMe($iid){
		$this->me = $iid;
		$this->apiParas["me"] = $iid;
	}

	public function getMe(){
		return $this->me;
	}



	public function getApiMethodName()
	{
		return "taobao.tbk.privilege.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->itemId,"itemId");
		RequestCheckUtil::checkNotNull($this->itemId,"adzoneId");
		RequestCheckUtil::checkNotNull($this->adzoneId,"adzoneId");
		RequestCheckUtil::checkNotNull($this->siteId,"siteId");
	
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
