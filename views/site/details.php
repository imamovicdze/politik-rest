<?php

/* @var $this yii\web\View */
/* @var $data */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>

<a href="<?= Url::toRoute(['site/random']); ?>" class="btn btn-primary">Back</a>

<table class="table">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">canton</th>
        <th scope="col">cantonName</th>
    </tr>
    </thead>


        <tbody>
        <tr>
            <th scope="row"><?= $data->id ?></th>
            <td><?= $data->canton ? $data->canton : 'null'?></td>
            <td><?= $data->cantonName ? $data->cantonName : 'null' ?></td>
            <td><?php // $data->party ? $data->party : 'null' ?></td>
            <td><?php // $data->partyName ? $data->partyName : 'null' ?></td>


        </tr>
        </tbody>

</table>
