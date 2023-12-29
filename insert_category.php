
<?php
include_once("../db.php");

if(isset($_POST['insert_cat'])){
    $category_title = $_POST['cat_title'];
    $cat_description = $_POST['cat_description'];

    $cat_image_name = $_FILES['cat_image']['name'];
    $cat_image_tmp = $_FILES['cat_image']['tmp_name'];
    $cat_image_size = $_FILES['cat_image']['size'];
    $cat_image_error = $_FILES['cat_image']['error'];

    if($cat_image_error === 0){
        $cat_image_destination = "../pictures/" . $cat_image_name;
        move_uploaded_file($cat_image_tmp, $cat_image_destination);
        
        $select_query = "SELECT * FROM categories WHERE cat_name = '$category_title'";
        $result_select = mysqli_query($conn, $select_query);
        $number = mysqli_num_rows($result_select);

        if($number > 0){
            echo "<script>alert('This is already present in the database');</script>";
        } else {
            $insert_query = "INSERT INTO categories (cat_name, cat_description, cat_image) VALUES ('$category_title', '$cat_description', '$cat_image_destination')";
            $result = mysqli_query($conn, $insert_query);

            if($result){
                echo "<script>alert('Category has been inserted successfully');</script>";
            }
        }
    } else {
        echo "<script>alert('Error uploading file');</script>";
    }
}
?>

<form action="" method="post" enctype="multipart/form-data" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1">
            <input type="text" class="form-control" name="cat_description" placeholder="Category Description" aria-label="Category Description" aria-describedby="basic-addon1">
        </span>
    </div>

    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1">
            <input type="file" class="form-control" name="cat_image" accept="image/*" aria-label="Category Image" aria-describedby="basic-addon1">
        </span>
    </div>

    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1">
            <input type="text" class="form-control" name="cat_title" placeholder="Category Name" aria-label="Category Name" aria-describedby="basic-addon1">
        </span>
    </div>

    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_cat" value="Insert Categories">
    </div>
</form>

