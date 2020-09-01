<?php
use yii\helpers\Html;
?>

<div class="container">
    <div class="row"></div>
    <div class="row">
        <div class="col l3 m6 s12">
            <div style="border-radius: 10px; box-shadow: 0 3px 8px 0 rgba(38,198,218,.5)!important; background: linear-gradient(to right, #0e91ac, #01c2df);; height: 150px">
                <div style="padding: 4%!important;" class="padding-4">
                    <div class="row">
                        <div class="col s7">
                            <i style="padding: 15px; border-radius:50%; background-color:rgba(0,0,0,.18); margin-top: 5%!important;" class="white-text material-icons background-round mt-5">
                                people
                            </i>
                            <h5 class="white-text">Clientela</h5>
                        </div>
                        <div class="col s5 right-align">
                            <h5 class="white-text"><?php echo $clientela; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col l3 m6 s12">
            <div style="border-radius: 10px; box-shadow: 0 3px 8px 0 rgba(244,143,177,.5)!important; background: linear-gradient(to right, #fe5d70, #fe909d); height: 150px">
                <div style="padding: 4%!important;" class="padding-4">
                    <div class="row">
                        <div class="col s7">
                            <i style="padding: 15px; border-radius:50%; background-color:rgba(0,0,0,.18); margin-top: 5%!important;" class="white-text material-icons background-round mt-5">
                                mood_bad
                            </i>
                            <h5 class="white-text">Quejas</h5>
                        </div>
                        <div class="col s5 right-align">
                            <h5 class="white-text">0</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col l3 m6 s12">
            <div style="border-radius: 10px; box-shadow: 0 3px 8px 0 rgba(255,121,50,0.5)!important; background: linear-gradient(to right, #fe9365, #feb798); height: 150px">
                <div style="padding: 4%!important;" class="padding-4">
                    <div class="row">
                        <div class="col s7">
                            <i style="padding: 15px; border-radius:50%; background-color:rgba(0,0,0,.18); margin-top: 5%!important;" class="white-text material-icons background-round mt-5">
                                mood
                            </i>
                            <h5 class="white-text">Propinas</h5>
                        </div>
                        <div class="col s5 right-align">
                            <h5 class="white-text"><?php echo $propinas; ?> €</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col l3 m6 s12">
            <div style="border-radius: 10px;box-shadow: 0 3px 8px 0 rgba(29,233,182,.5)!important; background: linear-gradient(to right, #0ac282, #0df3a3);; height: 150px">
                <div style="padding: 4%!important;" class="padding-4">
                    <div class="row">
                        <div class="col s7">
                            <i style="padding: 15px; border-radius:50%; background-color:rgba(0,0,0,.18); margin-top: 5%!important;" class="white-text material-icons background-round mt-5">
                                attach_money
                            </i>
                            <h5 class="white-text">Ganancias</h5>
                        </div>
                        <div class="col s5 right-align">
                            <h5 class="white-text"><?php echo $ganancias; ?> €</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s6">
            <blockquote>
                "Experiencia" y "Ambiente" son la media sobre cinco. La opción de ver más detalles estará próximamente.
            </blockquote>
        </div>
        <div class="col s6 right-align">
            <a class="btn-large disabled">Periodo de tiempo<i class="material-icons right">today</i></a>
        </div>
    </div>

    <?php foreach($datos as $key=>$value): ?>
        <h4><?php echo $key; ?></h4>
        <div class="card">
            <div class="card-content">

        <table class="striped center-align">
            <thead>
                <tr>
                    <th class="center-align"></th>
                    <th class="center-align">¿Repetiría?</th>
                    <th class="center-align">¿Recomendaría?</th>
                    <th class="center-align">Propinas</th>
                    <th class="center-align">Experiencia</th>
                    <th class="center-align">Ambiente</th>
                    <th class="center-align">Quejas</th>
                    <th class="center-align">+Info.</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($value['datos'] as $key2=>$value2): ?>
                    <tr>
                        <td>
                            <?php if($value['es_barra'] == 1): ?>
                                Barra <?php echo $key2; ?>
                            <?php else: ?>
                                Mesa <?php echo $key2; ?>
                            <?php endif; ?>
                        </td>
                        <?php if($value2['repetiria'] >= 60): ?>
                            <td class="center-align green-text text-darken-1"><?php echo $value2['repetiria']; ?>%</td>
                        <?php elseif($value2['repetiria'] < 45): ?>
                            <td class="center-align red-text text-darken-1"><?php echo $value2['repetiria']; ?>%</td>
                        <?php else: ?>
                            <td class="center-align"><?php echo $value2['repetiria']; ?>%</td>
                        <?php endif; ?>

                        <?php if($value2['recomendaria'] >= 60): ?>
                            <td class="center-align green-text text-darken-1"><?php echo $value2['recomendaria']; ?>%</td>
                        <?php elseif($value2['recomendaria'] < 45): ?>
                            <td class="center-align red-text text-darken-1"><?php echo $value2['recomendaria']; ?>%</td>
                        <?php else: ?>
                            <td class="center-align"><?php echo $value2['recomendaria']; ?>%</td>
                        <?php endif; ?>

                        <td class="center-align"><?php echo $value2['propinas']; ?> €</td>

                        <?php if($value2['experiencia'] >= 3): ?>
                            <td class="center-align green-text text-darken-1"><?php echo $value2['experiencia']; ?></td>
                        <?php elseif($value2['experiencia'] <= 2): ?>
                            <td class="center-align red-text text-darken-1"><?php echo $value2['experiencia']; ?></td>
                        <?php else: ?>
                            <td class="center-align"><?php echo $value2['experiencia']; ?></td>
                        <?php endif; ?>

                        <?php if($value2['ambiente'] >= 3): ?>
                            <td class="center-align green-text text-darken-1"><?php echo $value2['ambiente']; ?></td>
                        <?php elseif($value2['ambiente'] <= 2): ?>
                            <td class="center-align red-text text-darken-1"><?php echo $value2['ambiente']; ?></td>
                        <?php else: ?>
                            <td class="center-align"><?php echo $value2['ambiente']; ?></td>
                        <?php endif; ?>

                        <td class="center-align">0</td>

                        <td class="center-align"><a href="#"><i class="material-icons indigo-text text-lighten-1">info</i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>

