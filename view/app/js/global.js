var set_obj = $("meta[name='set']");
if(set_obj.length>0)	{
	  var set = set_obj.attr('content').split('|');
	  TAE			=  set[0] == 1 ? true:false;
	  CURSCRIPT	=  set[1] ;
	  CURMODULE	=  set[2] ;
	  CURACTION	=  set[3] ;		  
	  UID			= parseInt(set[4]);	
	  USERNAME	=  set[5];
	  DUOSHUO_KEY	=  set[6];
	  LEFT_BAR	=  set[7];
}