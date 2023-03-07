<?php

namespace backend\controllers;
use common\models\Apple;
use yii;

class AppleController extends AppController
{
 public function actionApple()
{
    $modelApple = new Apple();
    if ($modelApple->load(Yii::$app->request->post()) ) {
        if ($modelApple->flagGen != 0) {
            $count = $modelApple->flagGen;
            $arrayApple = [];
            for ($i = 0; $i <= $count; $i++) {
                $arr = [];
                $arrayCol = ['Красное', 'Желтое', 'Зеленое'];
                $arrayRand = array_rand($arrayCol, 1);
                $arr[0] = $arrayCol[$arrayRand];
                $arrayApple[$i] = $arr;
            }
            Yii::$app->db->createCommand()->batchInsert('apple', ['color'], $arrayApple)->execute();//загрузка
            // массив новых строк в базу
        } // нажатие кнопки случайной генерации яблок
        elseif ($modelApple->flagDown) {

            $today = date("Y-m-d H:i:s");
            Yii::$app->db->createCommand()->update('apple', ['downDate' => $today, 'status' => 'Лежит на земле'], "id= $modelApple->flagDown")->execute();
        }//устанавл дату падения по событию нажатие кноки упась
 elseif ($modelApple->eatId + $modelApple->eatId2 <= 1000 and $modelApple->eatId != 0) {
                Yii::$app->db->createCommand()->update('apple', ['eat' => $modelApple->eatId + $modelApple->eatId2, 'status' => 'На земле и надкушено'], "id= $modelApple->eatId1")->execute();

        } //съедаем яблоко
        elseif ($modelApple->delete != 0) {
            Yii::$app->db->createCommand()->delete('apple', "id=$modelApple->delete")->execute();
        }// удаление яблок
    }
    $content=Apple::find()->all();//загружаем в данные из базы в переменную
        foreach ($content as $cont) {
            if($cont->status=='Лежит на земле' or $cont->status=='На земле и надкушено') {
            $today = strtotime(date("Y-m-d H:i:s"));
            $now = $today - strtotime($cont->downDate);
            if ($now > 18000) {
                //   $cont->id=$id;
                Yii::$app->db->createCommand()->update('apple', ['status' => 'Гнилое'], "id= $cont->id")->execute();
                header("Refresh: 0");

            }
        }
            if($cont->eat==100 and $cont->status!='Съедено'){
                Yii::$app->db->createCommand()->update('apple', ['status' => 'Съедено'], "id= $cont->id")->execute();
                header("Refresh: 0");
            }
    }// тут проверки на гнилое и съедено
return $this-> render('apple',compact('content','modelApple'));// передаем во вью
}
}
