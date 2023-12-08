<?php

include('config/db_connect.php');
include('models/Restaurant.php');

$name = $city = $type = $address = '';

$errors = [
    'name' => '', 'city' => '', 'type' => '',
    'address' => ''
];

if (isset($_POST['add'])) {

    if (empty($_POST['name'])) {
        $errors['name'] = 'Name is required!';
    } else {
        $name = $_POST['name'];
    }

    if (empty($_POST['city'])) {
        $errors['city'] = 'City is required!';
    } else {
        $city = $_POST['city'];
    }

    if (empty($_POST['type'])) {
        $errors['type'] = 'Type of restaurant is required!';
    } else {
        $type = $_POST['type'];
    }

    if (empty($_POST['address'])) {
        $errors['address'] = 'Address is required!';
    } else {
        $address = $_POST['address'];
    }

    if (!array_filter($errors)) {
        $name = $_POST['name'];
        $city = $_POST['city'];
        $type = $_POST['type'];
        $address = $_POST['address'];
        $userid = $_POST['userid'];

        $newRestaurant = new Restaurant(
            null,
            $userid,
            $name,
            $city,
            $type,
            $address,
        );

        $newRestaurant->createRestaurant();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<section class="container">
    <h4 class="center">Submit Restaurant</h4>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="white form" method="POST">
        <label for="name">Restaurant name:</label>
        <input type="text" name="name" placeholder="Enter restaurant name" value="<?php echo htmlspecialchars($name) ?>">
        <div class="blue-text"><?php echo $errors['name']; ?></div>

        <label for="city">City:</label>
        <input type="text" name="city" placeholder="Enter city" value="<?php echo htmlspecialchars($city) ?>" onkeyup="suggestCity(this.value)">
        <div class="blue-text"><?php echo $errors['city']; ?></div>
        <p><span id="citySuggest"></span></p>

        <label for="type">Type of restaurant:</label>
        <input type="text" name="type" placeholder="Enter restaurant type" value="<?php echo htmlspecialchars($type) ?>" onkeyup="suggestType(this.value)">
        <div class="blue-text"><?php echo $errors['type']; ?></div>
        <p><span id="typeSuggest"></span></p>

        <label for="address">Address:</label>
        <input type="text" name="address" placeholder="Enter restaurant addres" value="<?php echo htmlspecialchars($address) ?>">
        <div class="blue-text"><?php echo $errors['address']; ?></div>

        <input type="hidden" name="userid" value="<?php echo $loggedId; ?>">

        <div class="center">
            <input type="submit" name="add" value="Submit restaurant" class="btn blue darken-2 z-depth-0">
        </div>
    </form>


</section>

<?php include('templates/footer.php'); ?>

<script>
    function suggestCity(str = "") {
        if (str.length == 0) {
            document.getElementById("citySuggest").innerHTML = "";
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("citySuggest").innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "ajax/cities.php?query=" + str, true);
            xmlhttp.send();
        }
    }
</script>

<script>
    function suggestType(str = "") {
        if (str.length == 0) {
            document.getElementById("typeSuggest").innerHTML = "";
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("typeSuggest").innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "ajax/types.php?query=" + str, true);
            xmlhttp.send();
        }
    }
</script>

</html>