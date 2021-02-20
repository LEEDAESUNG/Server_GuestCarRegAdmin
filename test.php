<style>
    .box.on{color:#999;}
</style>

<input type="checkbox" id="chk">
<div class="box on">
    버튼입니다. <button type="button">버튼</button>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script charset='euc-kr'>
$(".box button").attr("disabled", true);
    $("#chk").on('click',function(){
        var chk = $('input:checkbox[id="chk"]').is(":checked");
        if(chk==true){
            $(".box button").removeAttr('disabled');
            $(".box").removeClass("on");
        }else{
            $(".box button").attr("disabled", true);
            $(".box").addClass("on");
        }
    });
