<?php use yii\widgets\ActiveForm;
use yii\helpers\Html;?>
<?php $this->registerCsrfMetaTags() ?>



<?php $form1= ActiveForm::begin(['id'=>'flagGen'])?>
<?= $form1-> field ($modelApple,"flagGen")->hiddenInput(['value' => rand(1,20)])->label(false);?>
<?= Html::submitButton('Сгенерировать яблоки');?>
<?php $form1= ActiveForm::end();?>



<?php  if (!empty($content)):?>

  <table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Цвет</th>
        <th scope="col">Дата Появления</th>
        <th scope="col">Дата падения</th>
        <th scope="col">Статус </th>
        <th scope="col">Съедено %</th>
        <th scope="col">Действия</th>
    </tr>
    </thead>
      <tbody>

    <?php foreach ($content as $cont):?>

        <tr>
            <th scope="row"><?=$cont->id?></th>
            <td><?=$cont->color?></td>
            <td><?=$cont->birthDate ?></td>
            <td><?php if($cont->downDate==null) {
                echo 'еще на дереве';}
                else{echo "$cont->downDate";}
                ?></td>
            <td><?=$cont->status?></td>
            <td><?=$cont->eat?></td>
            <td>
<?php if($cont->status=='Еще на дереве'){
     $form2= ActiveForm::begin(['id'=>"flagDown$cont->id"]);
    echo $form2-> field ($modelApple,"flagDown")->hiddenInput(['value' => "$cont->id"])->label(false);
    echo Html::submitButton('Упасть');
     $form2= ActiveForm::end();
} // кнопка упасть
 if($cont->status=='Лежит на земле' or 	$cont->status== 'На земле и надкушено') {
     $form3 = ActiveForm::begin(['id' => "eatId$cont->id"]);
     echo $form3->field($modelApple, 'eatId1')->hiddenInput(['value' => "$cont->id"])->label(false);
     echo $form3->field($modelApple, 'eatId2')->hiddenInput(['value' => "$cont->eat"])->label(false);
     echo $form3->field($modelApple, 'eatId')->label('Съесть от 0 до 100 %');
     echo Html::submitButton('Съесть');
     $form3 = ActiveForm::end();

 } //форма съесть
 if($cont->status=='Гнилое' or 	$cont->status== 'Съедено'){
     $form4= ActiveForm::begin(['id'=>"delete$cont->id"]);
     echo $form4-> field ($modelApple,"delete")->hiddenInput(['value' => "$cont->id"])->label(false);
     echo Html::submitButton('Удалить');
     $form4= ActiveForm::end();
 } // форма удаления
?>
            </td>
        </tr>

    <?php endforeach; ?>

      </tbody>
  </table>
    <?php endif; ?>
