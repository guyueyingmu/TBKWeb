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
        var host = window.location.host;
        console.log("host:"+host);

        var ref = getReferer();
        console.log("ref:"+ref);

      /*  var rl = document.createElement('a');
        rl.href= "https://www.ntao.club/";
        document.body.appendChild(rl);
*/
    }
    load();
</script>
</html>