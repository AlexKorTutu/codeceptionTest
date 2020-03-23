<?php
declare(strict_types=1);

//Разбираем .csv построчно
$handle = fopen(__DIR__ . '/../_data/ssseo.csv', "r");
$rows = [];
while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
    $rows[] = $data;
}
fclose($handle);

$errors = '';

foreach ($rows as $row){
    $result = '';
    $matches = [];
    $matches2 = [];
    $url = $row[0];
    $title = $row[1];
    $descr = $row[2];

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_COOKIE => "test=SEO"

    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options));
    if( !$result = curl_exec($ch))
    {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);

    echo 'проверяем URL:' . $url . ':' . PHP_EOL;

    //проверяем title
    preg_match("/<title>(.+)<\/title>/", $result, $matches);
    if ($title  === $matches[1]) {
        echo '<title>                  =======>' . 'OK' . PHP_EOL;
    } else {
        echo '<title>                  =======>' . 'error' . PHP_EOL;
        $errors .= $url . ':' . PHP_EOL .
            '<title>' . PHP_EOL .
            "actual: $matches[1]" . PHP_EOL .
            "expected: $title" . PHP_EOL . PHP_EOL;
    }

    //проверяем meta description
    preg_match('/\<meta name=\"description\" content=\"' . '(.+)' . '">/iU', $result, $matches2);
    if ($descr  === $matches2[1]) {
        echo 'meta description         =======>' . 'OK' . PHP_EOL . PHP_EOL;
    } else {
        echo 'meta description         =======>' . 'error' . PHP_EOL . PHP_EOL;
        $errors .= $url . ':' . PHP_EOL .
            'meta description' . PHP_EOL .
            "actual: $matches2[1]" . PHP_EOL .
            "expected: $descr" . PHP_EOL . PHP_EOL;
    }

}

//выводим ошибки после цикла
echo '==========================================' . PHP_EOL .
    'Обнаружены следующие ошибки:' . PHP_EOL . $errors;