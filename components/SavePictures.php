<?php

/**
 * Класс для сохранения фотографий сотрудников и их миниатюр
 * Class SavePictures
 */
class SavePictures
{
    // функция принимает на вход файл, можно так же дописать, чтобы принималась и папка с картинками
    public static function savePic($picture){
        $picPath = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $picture['name'];
        move_uploaded_file($picture['tmp_name'], $picPath);

        // проверяем наличие папки
        $dir = $_SERVER['DOCUMENT_ROOT'] . "/images/minimages/";
        if (is_dir($dir)) {
            // путь к миниатюре
            $filepath = $dir . $picture['name'];
            // проверяем наличие мини файла и время изменения исходника
            if (!file_exists($filepath)) {
                list($width, $height) = getimagesize($picPath);
                $new_width = 100;
                $new_height = ($height * 100) / $width;
                // создаем холст
                $imgf = imagecreatetruecolor($new_width, $new_height);
                $image = imagecreatefromjpeg($picPath);
                imagecopyresampled($imgf, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($imgf, $filepath);
                imagedestroy($imgf);
            }
        }
    }
}