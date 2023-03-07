<?php

namespace common\models;
use yii\db\ActiveRecord;


class Apple extends ActiveRecord
{
public $flagGen; //флга команда сгенерировать яблоки
public $flagDown; // флаг команда упасть
public $eatId; // % яблока который необходимо съесть
public $eatId1; // айди столбйа которые есть
public $eatId2; // предыдущее значение столбца
public $delete; // флаг удаления
    public function rules() // валидация формы
    {
        return [

            [['eatId','flagDown','flagGen','eatId1','eatId2','delete'] ,'trim'], // обрезаем пробеыл
            ['eatId','string','max' => 3,'tooLong' => 'Максимальная длина 3 цифры'], // ограничиваем в 3 символа
            ['eatId', 'validateEatId']// создаем собсвенный валидатор

        ];
    }
// разобраться с валидацией всякие символы исключить и тд
    public function validateEatId($appleEat) {
        $eatProc=$this->$appleEat;

        if ($eatProc <= 100)
        {
            $this->addError($appleEat, 'Можно использовать только целые числа от 0 до 100');
        }
}
}
