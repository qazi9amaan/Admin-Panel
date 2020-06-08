function delete_product_images(images) {
    jQuery.ajax({
        url: "/admin/functions/functions.php",
        type: "GET",
        data: 'deleteimages=true&images=' + images,
        success: function(data) {
            console.log(data)
        }
    });
}


function add_associate_product(id, sp, fp) {
    jQuery.ajax({
        url: "/admin/functions/functions.php",
        type: "POST",
        data: {
            saveproduct: true,
            id: id,
            sp: sp,
            fp: fp,
        },
        success: function(data) {
            location.reload();
        }
    });
}

/* Open when someone clicks on the span element */
function openNav() {
    document.getElementById("notification_drawer").style.width = "100%";
    $('#page-wrapper').css('display', 'none');
    $('#notification_btn').css('background', '#e7e7e7');
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
    document.getElementById("notification_drawer").style.width = "0%";
    $('#page-wrapper').css('display', 'block');
    $('#notification_btn').css('background', '');


}