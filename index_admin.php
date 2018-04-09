<html>
<script type="text/javascript">
    function getReferer(){
        if(document.referrer){
            return document.referrer;
        }else{
            return false;
        }
    }

    function load(){
        var url = "https://www.ntao.club/";
        var host = window.location.host;
        console.log("host:"+host);
        var ref = getReferer();
        console.log("ref:"+ref);

        if(!ref && host.indexOf("admin.ntao.club")>=0){
            url = "//admin.ntao.club/admin.php";
        }

       var rl = document.createElement('a');
        rl.href=url;
        document.body.appendChild(rl);
    }
    load();
</script>
</html>