<div id="notification_drawer" class="overlay px-3">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div class="Activity_title"><span>Activity</span></div>
    <div style="overflow-y:scroll" class="overlay-content">
            <div class="container-fluid">
            <?php include 'activity_notifications.php'?>
            <?php include 'order_notifications.php'?>
        </div>
    </div>
</div>