<?php
session_start();
include('secure.php');
secure_page();
if (isset($_POST['logout'])){
    session_destroy();
    header('Location: login.php');
}
date_default_timezone_set('America/Sao_Paulo');

# pegando nome completo do usuário

$sql = connect();
$query = $sql->prepare("SELECT nome FROM sepaisdb.sepae WHERE email = ?;");
$query->bind_param("s", $_SESSION['email']);
$query->execute();
$result_query = $query->get_result();
$result_array = $result_query->fetch_all(MYSQLI_ASSOC);
$nome = $result_array[0]['nome']
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SEPAIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function updateTime() {
            var currentTime = new Date()
            var hours = currentTime.getHours()
            var minutes = currentTime.getMinutes()

            if (hours < 10) {
                hours = "0" + hours
            }

            if (minutes < 10) {
                minutes = "0" + minutes
            }

            var time = hours + ":" + minutes;
            document.getElementById('time').innerHTML = time;
        }
        setInterval(updateTime, 1000);
    </script>
</head>

<body>
    <nav class="nav-top w-full h-16 bg-[#040401] grid grid-cols-3 justify-items-center content-center">
        <div class="user ">
            <div class="flex items-center md:order-2">
                <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-[#00bf63]" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Abrir menu de usuário</span>
                    <img class="w-8 h-8 rounded-full" src="static/nereu.jpg" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900"><?php echo $nome;?></span>
                        <span class="block text-sm  text-gray-500 truncate"><?php echo $_SESSION['email']?></span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <form method="post"><input type="submit" name="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 m-auto" value="Logout"></form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="">
            <p class="text-white" id="time"></p>
        </div>
        <div class="">
            <img src="static/sepais_logo.png" class="sm:h-6 h-4">
        </div>
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
</body>

</html>