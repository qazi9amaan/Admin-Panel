<?php 




?>

<style>

#profile-img-tag-div >img{
    width : 200px; 
    height : 300px;
    padding : 2px;
}

</style>

<input type="file" data-previous="<?php echo htmlspecialchars($edit ? $customer['file_name'] : '', ENT_QUOTES, 'UTF-8'); ?>"  name="files[]"  multiple id="profile-img">

<img src="" id="profile-img-tag"  class="pt-3" width="200px" />
<div id="profile-img-tag-div">

<?php 
if(isset($customer)){
    $images = explode(",",$customer['file_name']);
    foreach ($images as &$image)
    {
        $imageURL = '/admin/uploads/'.$image;
        ?>
        <img src="<?php echo $imageURL; ?>" alt="" />
        <?php
    }}

?>

<?php 
if(isset($product)){
    $images = explode(",",$product['file_name']);
    foreach ($images as &$image)
    {
        $imageURL = '/admin/uploads/'.$image;
        ?>
        <img src="<?php echo $imageURL; ?>" alt="" />
        <?php
    }}

?>


</div>

<script type="text/javascript">

    function readURL(input) {
        document.getElementById('profile-img-tag-div').innerHTML= null;
        $('#profile-img-tag').attr('src',null);
        if (input.files.length > 5){
            alert('Sorry! Maximum 5 Images..');
            return;
        }   
        if (input.files.length == 1) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
                $('#profile-img-tag').style('height', '300px');
            }
            reader.readAsDataURL(input.files[0]);
        }else{
           
            readmultifiles(input.files)
        }
    }

    function readmultifiles(files) {
        var reader = new FileReader();  
        function readFile(index) {
            if( index >= files.length ) return;
            var file = files[index];
            reader.onload = function(e) {  
            // get file content  
            var bin = e.target.result;
            var new_img = document.createElement("img");
            new_img.src =e.target.result
            document.getElementById('profile-img-tag-div').appendChild(new_img);              
            readFile(index+1)
            }
            reader.readAsDataURL(file);
        }
        readFile(0);
    }

    $("#profile-img").change(function(){
        readURL(this);
        delete_product_images($(this).data('previous'));
    });

</script>