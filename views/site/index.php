<?php

/* @var $this yii\web\View */
/* @var $data */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<h3>Filter</h3>
<a href="<?= Url::toRoute(['site/index', 'pageNumber' => 1]); ?>" class="btn btn-primary">1</a>
<a href="<?= Url::toRoute(['site/index', 'pageNumber' => 2]); ?>" class="btn btn-primary">2</a>
<a href="<?= Url::to(['site/index', 'pageNumber' => 3]); ?>" class="btn btn-primary">3</a>
<a href="<?= Url::to(['site/index', 'pageNumber' => 4]); ?>" class="btn btn-primary">4</a>
<a href="<?= Url::to(['site/index', 'pageNumber' => 5]); ?>" class="btn btn-primary">5</a>

<span><b> Sort by: </b></span>
<a href="<?= Url::to(['site/index', 'sort' => 'firstName']); ?>" class="btn btn-primary">First Name</a>
<a href="<?= Url::to(['site/index', 'sort' => 'lastName']); ?>" class="btn btn-primary">Last Name</a>

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
        </tr>
        </tbody>
    <?php } ?>
</table>
