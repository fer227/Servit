<?php
?>

<div class="container">
    <h5 class="center-align">Productos entregados</h5>
    <table>
        <tbody>
            <?php foreach($entregados as $key=>$value): ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td>x<?php echo $value; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
