<?php

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.mcstatus.io/v2/status/java/minecraft.kotika.pl",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
}
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="style.css"/>
    <title>Serwer Minecraft - Kotika</title>
</head>
<body>
<div class="container">
    <div class="menu">
        <nav>
            <ul>
                <li class="players">

                    <?php
                    $data = json_decode($response, true);
                    $online = $data['online'];
                    if (!empty($online)) {
                        echo '<div class="circle"></div>';
                        $players_online = $data['players']['online'];
                        $players_max = $data['players']['max'];
                        echo "Gracze online: ";
                        echo "<b>" . $players_online . "/" . $players_max . "</b>";
                    } else {
                        echo '<div class="circle red"></div>';
                        echo "Serwer offline.";
                    }
                    ?>
                </li>
                <div style="display: flex; gap: 1.5rem">
                    <a href="#"><li class="shop">SKLEP</li></a>
                    <a href="banlist.php"><li class="bans">BANLIST</li></a>
                </div>
            </ul>
        </nav>
    </div>
    <main>
        <h2>MC.KOTIKA.PL</h2>
        <p>MC Spigot 1.16.1</p>
    </main>
</div>
</body>
</html>
