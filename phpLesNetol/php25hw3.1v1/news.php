<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class News
{
    private $news;
    public function __construct($name)
    {
        $file = file_get_contents($name);
        $decode = json_decode($file, true);
        $this->news = $decode;
    }

    public function getNews()
    {
        $newsList ='';
        foreach ($this->news as $item)
        {
            $newsList .= '<h3>' . $item['title'] . '</h3>' . '<b>' . $item['data'] . '</b>' . '<p>' . $item['text'] . '</p>' . '<br>';

        }
        return $newsList;
    }

    public function getComments()
    {

    }

}

$newsPolicy = new News('newsPolicy.json');
$newsWeather = new News('newsWeather.json');
$newsSport = new News('newsSport.json');

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новости</title>
</head>
<body>

<?=$newsPolicy->getNews();?>
<?=$newsWeather->getNews();?>
<?=$newsSport->getNews();?>

</body>
</html>

