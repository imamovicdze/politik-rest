<?php

/* @var $this yii\web\View */
/* @var $data */

use yii\helpers\Url;

$this->title = 'Random 5 Councillors';
?>

<a href="<?= Url::toRoute(['councillor/random']); ?>" class="btn btn-success">Refresh</a>

<table class="table">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">updated</th>
        <th scope="col">active</th>
        <th scope="col">code</th>
        <th scope="col">firstName</th>
        <th scope="col">lastName</th>
        <th scope="col">officialDenomination</th>
        <th scope="col">salutationLetter</th>
        <th scope="col">salutationTitle</th>
        <th scope="col">details</th>
    </tr>
    </thead>

    <?php foreach ($data as $councillor) { ?>
        <tbody>
        <tr>
            <th scope="row"><?= $councillor->id ?></th>
            <td><?= $councillor->updated ?></td>
            <td><?= $councillor->active ? $councillor->active : 0 ?></td>
            <td><?= $councillor->code ?></td>
            <td><?= $councillor->firstName ?></td>
            <td><?= $councillor->lastName ?></td>
            <td><?= $councillor->officialDenomination ?></td>
            <td><?= $councillor->salutationLetter ? $councillor->salutationLetter : 'null'?></td>
            <td><?= $councillor->salutationTitle ? $councillor->salutationTitle : 'null' ?></td>
            <td><a href="<?= Url::toRoute(['councillor/details', 'id' => $councillor->id]); ?>" class="btn btn-primary">View Details</a></td>
        </tr>
        </tbody>
    <?php } ?>
</table>
