<?php
use yii\helpers\Html;
?>
<option value="">Seleccione unidad</option>
<?php foreach ($unidades as $unidad): ?>
    <option value="<?= $unidad->id_unidad ?>"><?= Html::encode($unidad->numero_unidad) ?></option>
<?php endforeach; ?>