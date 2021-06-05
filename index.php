<?php

$j = 0;
while (++$j <= 100) {
    if ($j % 3 == 0) echo $j . ' ';
}


do {
    if ($c == 0) {
        echo $c . '<br>0 - ноль <br>';
        $c++;
    }
    echo $c . ($c % 2 == 0 ? '- четное число' : ' - нечетное число') . '<br>';

} while (++$c <= 10);
echo '<br>';

$localitiesAndCities = [
    'Московская область' => [
        'Москва',
        'Зеленоград',
        'Клин'
    ],
    'Ленинградская область ' => [
        'Санкт-Петербург',
        'Всеволожск',
        'Павловск',
        'Кронштадт',
    ],
    'Рязанская область' => [
        'Сапожок',
        'Скопин',
        'Шилово',
        'Рыбное',
    ],
];

for ($i = 0; $i < count(array_keys($localitiesAndCities)); $i++) {
    echo array_keys($localitiesAndCities)[$i] . ': <br>';
    for ($j = 0; $j < count($localitiesAndCities[array_keys($localitiesAndCities)[$i]]); $j++) {
        $newLine = ($j == count($localitiesAndCities[array_keys($localitiesAndCities)[$i]]) - 1 ? '<br><br>' : '');
        echo $localitiesAndCities[array_keys($localitiesAndCities)[$i]][$j] . ', ' . $newLine;
    }
}


function ruTranslit($string): string
{
    $letters = [
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ё' => 'yo',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'i',
        'й' => 'y',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'О' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'kh',
        'ц' => 'ts',
        'ш' => 'sh',
        'щ' => 'sch',
        'ъ' => '\'',
        'ы' => 'y',
        'ь' => '\'',
        'э' => 'e',
        'ю' => 'yu',
        'я' => 'ya',
    ];
    return strtr($string, $letters);
}

echo ruTranslit('4 задание <br>');

function replaceSpaces($string): string
{
    return str_replace(' ', '_', $string);
}

echo replaceSpaces('это 5 задание');

echo '<br>';

$listTitles = [
    'Title 1',
    'Title 2',
    'Title 3',
    'Title 4',
    'Title 5',
];

//task 6
function createList($listTitles)
{
    echo '<ul>';
    for ($t = 0; $t < count($listTitles); $t++) {

        echo '<li>' . $listTitles[$t] . '</li>';

    }
    echo '</ul>';
}

createList($listTitles);

//task 7
for ($i = 0; $i < 10; print $i++);

