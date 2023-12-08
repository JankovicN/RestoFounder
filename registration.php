<?php

include('config/db_connect.php');
include('models/User.php');

// promenljive u formi
$email = $username = $password = $confirmPassword = $nationality =  '';

// niz u kom će za svako polje biti ispisana greška prilikom validacije
$errors = [
    'email' => '', 'username' => '', 'password' => '',
    'confirmPassword' => '', 'nationality' => ''
];

if (isset($_POST['registration'])) { // kada pritisnemo submit dugme sa nazivom registration

    if (empty($_POST['email'])) {  // provera da li je prazno polje
        $errors['email'] = 'Email is required!';  // greška koja se upisuje u niz grešaka
    } else {
        $email = $_POST['email']; // dodela vrednosti kako bi u slučaju ispravnosti forme ostala upisana za ponovni unos
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email address!';
        }
    }

    if (empty($_POST['username'])) {
        $errors['username'] = 'Username is required!';
    } else {
        $username = $_POST['username'];

        // provera da li već postoji korisničko ime koje je uneto
        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        $userWithSameUsername = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        if ($userWithSameUsername != null) { // ako niz nije prazan - imamo korisnike sa tim username
            $errors['username'] = "User with username $username already exists!";
        }
    }

    if (empty($_POST['password'])) {
        $errors['password'] = 'Password is required!';
    } else {
        $password = $_POST['password'];
        if (strlen($password) < 8) {   // provera da li je password kraći od 8 znakova
            $errors['password'] = 'Password must be at least 8 characters long!';
        }
    }

    if (empty($_POST['confirmPassword'])) {
        $errors['confirmPassword'] = 'Password confirmation is required!';
    } else {
        $confirmPassword = $_POST['confirmPassword'];
        if ($confirmPassword != $password) {   // provera da li se šifre slažu
            $errors['confirmPassword'] = 'Passwords do not match!';
            $confirmPassword = '';
            $password = '';
        }
    }

    include('ajax/countries.php');
    if (empty($_POST['nationality'])) {
        $errors['nationality'] = 'Nationality is required!';
    } else {
        $nationality = $_POST['nationality'];
        if (!in_array($nationality, $countries)) {
            $errors['nationality'] = 'No such country exists!';
            $nationality = '';
        }
    }

    if (!array_filter($errors)) {  // ako niz grešaka ima samo false vrednosti tj. prazne stringove 
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $nationality = $_POST['nationality'];

        $newUser = new User(null, $email, $username, $password, $nationality);
        $newUser->createUser();
    }
}


?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php') ?>

<section class="container">
    <h4 class="center default_padding">Register to insert restaurants</h4>

    <!-- FORM -->
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="white form" method="POST">
        <label for="email">Email:</label>
        <input type="text" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>">
        <div class="blue-text"><?php echo $errors['email']; ?></div>

        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="Enter your username"  value="<?php echo htmlspecialchars($username); ?>">
        <div class="blue-text"><?php echo $errors['username']; ?></div>

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Enter your password"  value="<?php echo htmlspecialchars($password); ?>">
        <div class="blue-text"><?php echo $errors['password']; ?></div>

        <label for="confirmPassword">Confirm password:</label>
        <input type="password" name="confirmPassword" placeholder="Repeat your password"  value="<?php echo htmlspecialchars($confirmPassword); ?>">
        <div class="blue-text"><?php echo $errors['confirmPassword']; ?></div>

        <label for="nationality">Nationality:</label>
        <input type="text" name="nationality" placeholder="Enter your nationality"  value="<?php echo htmlspecialchars($nationality) ?>" onkeyup="suggestNationality(this.value)">
        <div class="blue-text"><?php echo $errors['nationality']; ?></div>
        <p><span id="natioanalitySuggest"></span></p>

        <div class="center">
            <input type="submit" name="registration" value="Create account" class="btn blue darken-2 z-depth-0">
        </div>
    </form>
</section>

<?php include('templates/footer.php') ?>

<script>
    
    function suggestNationality(str = "") {
        if (str.length == 0) {
            document.getElementById("natioanalitySuggest").innerHTML = "";
        } else {
            
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() { 
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("natioanalitySuggest").innerHTML = this.responseText; 
                }
            }
            xmlhttp.open("GET", "ajax/countries.php?query=" + str, true); 
            xmlhttp.send(); 
        }
    }
</script>

</html>