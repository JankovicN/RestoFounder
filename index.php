<?php

// konektujemo se na bazu
include('config/db_connect.php');

$query = "SELECT * FROM restaurant ORDER BY name ASC";
$result = mysqli_query($conn, $query);
$restaurants = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<div class="container">
    <div class="card-content center row">
        <h4>Restaurants</h4>
    </div>
    <div class="row">
        <?php foreach ($restaurants as $restaurant) : ?>
            <div class="col s12 m6 l4 xl3">
                <div class="card z-depth-0 radius-card">
                    <img src="img/icon.png" alt="icon" class="icon-card">
                    <div class="card-content center">
                        <h5><?php echo $restaurant['name']; ?></h5>
                    </div>
                    <div class="card-action right-align radius-card">
                        <a href="restaurant.php?id=<?php echo $restaurant['id']; ?>" class="blue-text text-darken-2">
                            More Info
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if(count($restaurants)==0) : ?>
            <div class="card-content center row default_padding">
                <h3>There are no restaurants to show!</h3>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include('templates/footer.php'); ?>

</html>