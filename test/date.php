<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php' ;?>
<?php include_once CAR_ROOT_WEB . '/config.inc' ;?>
<?php
    $header_title = 'Test Date - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<script>
    function padZero(value) {
        return value < 10 ? "0" + value : value;
    }

    $(document).ready(function() {
        var offset = new Date().getTimezoneOffset(); // Obtém o offset em minutos
        var hours = Math.floor(Math.abs(offset) / 60);
        var minutes = Math.abs(offset) % 60;
        var sign = offset < 0 ? "+" : "-"; // Determina o sinal do offset
        var timezone = sign + padZero(hours) + ":" + padZero(minutes);

        console.log("Fuso Horário: " + timezone);

        $.ajax({
            url: "<?= CAR_PATH_WEB; ?>/test/set-timezone.php",
            type: "POST",
            data: {timezone: timezone},
            success: function (response) {
                console.log("Fuso horário definido com sucesso");
                // Faça algo com a resposta do servidor, se necessário
            },
            error: function (xhr, status, error) {
                console.log("Erro ao definir o fuso horário: " + error);
                // Trate o erro, se necessário
            }
        });
    });
</script>
<?php
    $sql = sprintf("SET time_zone = '-3:00'");
    
    $mysqli->query($sql);

    $sql = sprintf('select now() as timestamp');

    $timestamp = 0;

    $result = $mysqli->query($sql);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $timestamp = $row['timestamp'];
    }
?>
<?= $timestamp; ?>
<hr/>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>

