<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAL_ROOT_WEB . '/config.inc'; ?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
    // Parâmetros
    $user_id = cal_get_session_attribute('user_id', 0);

    $stud_key = cal_get_parameter('k', '');
    $stse_order = cal_get_parameter('stse_order', 0);
    $stse_answer = cal_get_parameter('stse_answer', 0);

    // Variáveis
    $stud_id = 0;
    $card_id = 0;
    $card_true = 0;
    $card_false = 0;

    if ($stse_answer == 'true') $stse_answer = 1;
    elseif ($stse_answer == 'false') $stse_answer = 0;
    else $stse_answer = -1; // não deve existir -1 no banco de dados

    try {
        // Procurando o stud_id
        $sql = sprintf(" select stud_id from car_study where stud_key = '%s' and user_id = %d",
                        $mysqli->real_escape_string(cal_never_null($stud_key)),
                        $user_id);

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $stud_id = $row['stud_id'];
        }

        // Procurando o card_id na sessão do estudo
        $sql = sprintf(' 
                        select a.card_id, b.card_true, b.card_false
                          from car_study_session a, car_card b
                         where a.stud_id = %d
                           and a.user_id = %d
                           and a.stse_order = %d
                           and a.stse_answer is null
                           and a.card_id = b.card_id',
                        $stud_id,
                        $user_id,
                        $stse_order);

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $card_id = $row['card_id'];
            $card_true = $row['card_true'];
            $card_false = $row['card_false'];
        }

        if ($card_id != 0) {
            // Atualizando a resposta
            $sql = sprintf(' 
                        update car_study_session
                           set stse_answer = %d
                         where stse_order = %d
                           and user_id = %d
                           and stud_id = %d',
                $stse_answer,
                $stse_order,
                $user_id,
                $stud_id);

            $result = $mysqli->query($sql);

            if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);

            // Procurando as respostas certas e erradas da sessão de estudo
            $sql = sprintf("
                        select sum(stud_true) as stud_true, sum(stud_false) as stud_false
                          from (
                          select count(*) as stud_true, '0' as stud_false from car_study_session where stse_answer = 1 and stud_id = %d and user_id = %d
                          union all
                          select '0' as stud_true, count(*) as stud_true from car_study_session where stse_answer = 0 and stud_id = %d and user_id = %d) as t1",
                $stud_id,
                $user_id,
                $stud_id,
                $user_id);

            $result = $mysqli->query($sql);

            if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);

            $stud_true = 0;
            $stud_false = 0;

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $stud_true = $row['stud_true'];
                $stud_false = $row['stud_false'];
            }

            // Atualizando a quantidade de respostas certas (true) e erradas (false)
            $sql = sprintf('
                        update car_study
                           set stud_true = %d, 
                               stud_false = %d
                         where stud_id = %d
                           and user_id = %d',
                $stud_true,
                $stud_false,
                $stud_id,
                $user_id);

            $result = $mysqli->query($sql);

            if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);

            // Atualizando as respostas no cartão
            if ($user_id != CAL_USER_ID_MASTER) {
                if ($stse_answer == 1) { // true
                    $card_true += 1;
                    $card_rate = cal_percent($card_true, $card_true + $card_false);

                    $sql = sprintf('
                                update car_card
                                   set card_true = %d,
                                       card_rate = %d,
                                       card_sequence = card_sequence + 1,
                                       card_last_study = now()
                                 where card_id = %d
                                   and user_id = %d',
                        $card_true,
                        $card_rate,
                        $card_id,
                        $user_id);

                } else { // false
                    $card_false += 1;
                    $card_rate = cal_percent($card_true, $card_true + $card_false);

                    $sql = sprintf('
                                update car_card
                                   set card_false = %d,
                                       card_rate = %d,
                                       card_sequence = 0,
                                       card_last_study = now()
                                 where card_id = %d
                                   and user_id = %d',
                        $card_false,
                        $card_rate,
                        $card_id,
                        $user_id);
                }
            }

            $result = $mysqli->query($sql);

            if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
        }

        $mysqli->commit();
    } catch(Exception $e) {
        $mysqli->rollback();

        cal_set_session_error_message($e->getMessage());
    }

    $mysqli->close();

    cal_redirect(CAL_PATH_WEB . '/dash/study?k=' . $stud_key);
?>