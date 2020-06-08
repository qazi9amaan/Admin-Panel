<style>
.table-responsive{
  height:306px; width:100%;
  overflow-y: auto;
  border:2px solid #444;
}.table-responsive:hover{border-color:red;}

table{width:100%;}
td{padding:24px; background:none;}
</style>

      
    
<div class="table-responsive">
    <p style="padding:16px;padding-bottom:0px">Activities</p>
  <table class="table table-bordered table-hover">
   
   <div style="padding:8px; ">
    <?php 
        $show_clear_btn =false;
        include 'activity_notifications.php' ;
    ?>
    
   </div> 
  </table>
</div>

<script>
    
    var $el = $(".table-responsive");
function anim() {
  var st = $el.scrollTop();
  var sb = $el.prop("scrollHeight")-$el.innerHeight();
  $el.animate({scrollTop: st<sb/2 ? sb : 0}, 6000, anim);
}
function stop(){
  $el.stop();
}
anim();
$el.hover(stop, anim);

</script>